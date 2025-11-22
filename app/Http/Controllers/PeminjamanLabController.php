<?php
namespace App\Http\Controllers;

use App\Models\PeminjamanLab;
use App\Models\JadwalLab;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // Kita butuh Transaction
use Illuminate\Support\Facades\Auth;


class PeminjamanLabController extends Controller
{
    public function create()
    {
        // 1. Ambil semua data lab untuk ditampilkan di dropdown form
        $labs = \App\Models\Lab::all(); 
        
        // 2. Tampilkan file view 'resources/views/peminjaman/create.blade.php'
        // sambil membawa data $labs
        return view('peminjamanLab.create', compact('labs'));
    }
    public function store(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'lab_id' => 'required|exists:lab,id_lab', // Cek tabel lab kolom id_lab
            'tanggal' => 'required|date|after_or_equal:today',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
            'kegiatan' => 'required|string',
            'surat' => 'required|file|mimes:pdf,jpg,png|max:2048',
        ]);

        // 2. Logic Validasi Jadwal Kosong
        // Cek apakah di tabel jadwal_lab sudah ada yang make di jam segitu?
        $bentrok = PeminjamanLab::cekBentrokan(
            $request->lab_id, 
            $request->tanggal, 
            $request->jam_mulai, 
            $request->jam_selesai
        )->exists();

        if ($bentrok) {
            return back()->withErrors(['jam_mulai' => 'Jadwal lab pada jam tersebut sudah terisi!']);
        }

        // 3. Logic Upload & Simpan Data (Pakai DB Transaction)
        // Kita pakai transaction biar kalau error di tengah jalan, data tidak masuk setengah-setengah
        try {
            DB::beginTransaction();

            // A. Upload Surat
            $pathSurat = null;
            if ($request->hasFile('surat')) {
                // Simpan ke folder 'public/surat_peminjaman'
                $pathSurat = $request->file('surat')->store('surat_peminjaman', 'public');
            }

            // B. Simpan ke Tabel JADWAL_LAB dulu (Karena dibutuhkan ID-nya)
            $jadwal = JadwalLab::create([
                'lab_id' => $request->lab_id,
                'tanggal' => $request->tanggal,
                'jam_mulai' => $request->jam_mulai,
                'jam_selesai' => $request->jam_selesai,
                'status' => 'terpakai', // Default kita set terpakai agar slot tertutup
                'kegiatan' => $request->kegiatan
            ]);

            // C. Simpan ke Tabel PEMINJAMAN_LAB
            PeminjamanLab::create([
                'user_id' => Auth::id(), // Ambil ID user yang login
                'lab_id' => $request->lab_id,
                'jadwal_id' => $jadwal->id, // Ambil ID dari jadwal yang baru dibuat
                'surat_file' => $pathSurat,
                'status' => 'pending', // Default pending menunggu approval admin
            ]);

            // Masukkan data ke tabel notifikasi sesuai struktur SQL kamu
            \App\Models\Notifikasi::create([
                'user_id' => 1, // Notif untuk peminjam
                'pesan' => 'Pengajuan peminjaman lab Anda sedang diproses menunggu persetujuan.',
                'type' => 'laboratorium' // Sesuai enum di database
            ]);

            DB::commit(); // Simpan permanen

            return redirect()->back()->with('success', 'Pengajuan peminjaman berhasil dikirim!');

        } catch (\Exception $e) {
            DB::rollback(); // Batalkan semua kalau error
            return back()->withErrors(['error' => 'Terjadi kesalahan sistem: ' . $e->getMessage()]);
        }
    }
    
    public function checkAvailability(Request $request)
    {
        $labId = $request->input('lab_id');
        $tanggal = $request->input('tanggal');
        $jamMulai = $request->input('jam_mulai');
        $jamSelesai = $request->input('jam_selesai');

        // Ambil semua jadwal yang sudah dipesan untuk lab dan tanggal tertentu
        $bookedSlots = JadwalLab::where('lab_id', $labId)
            ->where('tanggal', $tanggal)
            ->where('status', 'terpakai')
            ->orderBy('jam_mulai')
            ->get(['jam_mulai', 'jam_selesai', 'kegiatan']);

        // Cek apakah ada bentrokan jika jam mulai dan selesai sudah diisi
        $isBentrok = false;
        if ($jamMulai && $jamSelesai) {
            $isBentrok = PeminjamanLab::cekBentrokan(
                $labId, 
                $tanggal, 
                $jamMulai, 
                $jamSelesai
            )->exists();
        }

        return response()->json([
            'bookedSlots' => $bookedSlots,
            'isBentrok' => $isBentrok
        ]);
    }
}
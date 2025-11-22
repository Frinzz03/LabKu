<?php

namespace App\Http\Controllers;

use App\Models\PeminjamanLab;
use App\Models\JadwalLab;
use App\Models\Notifikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Lab; 

class AdminPeminjamanController extends Controller
{
    // 1. Menampilkan Daftar Pengajuan (Dashboard Admin)
// Pastikan import Model Lab di paling atas


    public function index(Request $request)
    {
        // 1. Siapkan Query Dasar
        // Kita tidak langsung ->get(), tapi simpan di variabel $query dulu
        $query = PeminjamanLab::join('user', 'peminjaman_lab.user_id', '=', 'user.id')
            ->join('lab', 'peminjaman_lab.lab_id', '=', 'lab.id_lab')
            ->join('jadwal_lab', 'peminjaman_lab.jadwal_id', '=', 'jadwal_lab.id')
            ->select(
                'peminjaman_lab.*', 
                'user.nama as nama_peminjam', 
                'user.nim',
                'lab.nama_lab',
                'jadwal_lab.tanggal',
                'jadwal_lab.jam_mulai',
                'jadwal_lab.jam_selesai',
                'jadwal_lab.kegiatan'
            )
            ->orderBy('peminjaman_lab.created_at', 'desc');

        // 2. Logika Filter: Jika ada request 'lab_id', tambahkan kondisi WHERE
        if ($request->has('lab_id') && $request->lab_id != '') {
            $query->where('peminjaman_lab.lab_id', $request->lab_id);
        }

        // 3. Logika Filter: Jika ada request 'status', tambahkan kondisi WHERE
        if ($request->has('status') && $request->status != '') {
            $query->where('peminjaman_lab.status', $request->status);
        }

        // 4. Eksekusi Query (Ambil Datanya)
        $peminjaman = $query->get();

        // 5. Ambil data semua Lab untuk isi Dropdown Filter
        $labs = Lab::all();

        // Kirim data peminjaman DAN data labs ke view
        return view('admin.peminjamanLab', compact('peminjaman', 'labs'));
    }

    // 2. Logika Menyetujui (Approve)
    public function approve($id)
    {
        $peminjaman = PeminjamanLab::findOrFail($id);
        
        // Update status jadi disetujui
        $peminjaman->update(['status' => 'disetujui']);

        // Kirim Notifikasi ke User
        Notifikasi::create([
            'user_id' => $peminjaman->user_id,
            'pesan' => 'Hore! Pengajuan peminjaman lab Anda telah DISETUJUI.',
            'type' => 'laboratorium'
        ]);

        return redirect()->back()->with('success', 'Peminjaman berhasil disetujui.');
    }

    // 3. Logika Menolak (Reject)
    public function reject(Request $request, $id)
    {
        $request->validate([
            'alasan_penolakan' => 'required|string'
        ]);

        $peminjaman = PeminjamanLab::findOrFail($id);

        try {
            DB::beginTransaction();

            // A. Update status peminjaman jadi ditolak & simpan alasan
            $peminjaman->update([
                'status' => 'ditolak',
                'alasan_penolakan' => $request->alasan_penolakan
            ]);

            // B. PENTING: Lepaskan Jadwal Lab
            // Ubah status jadwal menjadi 'tersedia' agar slot tersebut tidak merah di kalender
            // dan bisa dibooking orang lain.
            JadwalLab::where('id', $peminjaman->jadwal_id)->update([
                'status' => 'tersedia' 
            ]);

            // C. Kirim Notifikasi ke User
            Notifikasi::create([
                'user_id' => $peminjaman->user_id,
                'pesan' => 'Maaf, pengajuan peminjaman lab Anda DITOLAK. Alasan: ' . $request->alasan_penolakan,
                'type' => 'laboratorium'
            ]);

            DB::commit();
            return redirect()->back()->with('success', 'Peminjaman berhasil ditolak dan jadwal telah dibuka kembali.');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
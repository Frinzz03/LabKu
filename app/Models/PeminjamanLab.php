<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PeminjamanLab extends Model
{
    protected $table = 'peminjaman_lab';
    protected $primaryKey = 'id';
    // Timestamps true karena di SQL ada column 'created_at' (tapi pastikan updated_at dinonaktifkan kalau tidak ada kolomnya)
    const CREATED_AT = 'created_at';
    const UPDATED_AT = null; 

    protected $fillable = ['user_id', 'lab_id', 'jadwal_id', 'surat_file', 'status', 'alasan_penolakan'];

    // Scope untuk Validasi Jadwal (Logic Core)
    public function scopeCekBentrokan($query, $lab_id, $tanggal, $mulai, $selesai)
    {
        // Kita cek ke tabel jadwal_lab, bukan tabel peminjaman_lab langsung
        return \App\Models\JadwalLab::where('lab_id', $lab_id)
            ->where('tanggal', $tanggal)
            ->where('status', 'terpakai') // Asumsi kalau ada jadwal berarti terpakai
            ->where(function ($q) use ($mulai, $selesai) {
                $q->whereBetween('jam_mulai', [$mulai, $selesai])
                  ->orWhereBetween('jam_selesai', [$mulai, $selesai])
                  ->orWhere(function ($sub) use ($mulai, $selesai) {
                      $sub->where('jam_mulai', '<=', $mulai)
                          ->where('jam_selesai', '>=', $selesai);
                  });
            });
    }
}
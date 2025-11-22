<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notifikasi extends Model
{
    // Menghubungkan ke tabel 'notifikasi' di database
    protected $table = 'notifikasi';

    // Primary key sesuai SQL
    protected $primaryKey = 'id';

    // Konfigurasi Timestamps
    // Karena di tabel SQL kamu hanya ada 'created_at' dan TIDAK ada 'updated_at'
    // Kita harus mematikan fitur update timestamp standar Laravel agar tidak error.
    public $timestamps = true; 
    const CREATED_AT = 'created_at';
    const UPDATED_AT = null; 

    // Kolom yang boleh diisi (Mass Assignment)
    protected $fillable = [
        'user_id',
        'pesan',
        'type' // Enum: 'barang' atau 'laboratorium'
    ];

    /**
     * Relasi ke User (Opsional, tapi berguna jika ingin menampilkan nama penerima notif)
     */
    public function user()
    {
        // Relasi ke tabel 'user' dengan foreign key 'user_id'
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
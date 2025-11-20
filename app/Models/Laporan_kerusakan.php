<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Laporan_kerusakan extends Model
{
    protected $table = 'laporan_kerusakan';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'dekripsi',
        'biaya_perbaikan',
        'status'
    ];

    public function detail_peminjaman_barang():BelongsTo{
        return $this->belongsTo(Peminjaman_barang_detail::class, 'peminjaman_detail_id', 'id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Peminjaman_barang_detail extends Model
{
    protected $table = 'peminjaman_barang_detail';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'jumlah',
        'status',
        'catatan'
    ];

    public function peminjaman(): BelongsTo{
        return $this->belongsTo(Peminjaman_barang::class, 'peminjaman_id', 'id');

    }

    public function peminjaman_barang():BelongsTo{
        return $this->belongsTo(Barang::class, 'barang_id', 'id_barang');
    }

    public function laporan_kerusakan():HasMany{
        return $this->hasMany(Laporan_kerusakan::class, 'peminjaman_detail_id', 'id');
    }
}

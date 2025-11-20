<?php

namespace App\Models;

use App\Http\Controllers\Peminjaman_barang as ControllersPeminjaman_barang;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Peminjaman_barang extends Model
{
    protected $table = 'peminjaman_barang';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'tanggal_pinjam',
        'tanggal_kembali',
        'surat_file',
        'status',
        'alasan_penolakan',

    ];

    public function user():BelongsTo{
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

    public function detail_peminjaman_barang():HasMany{
        return $this->hasMany(Peminjaman_barang_detail::class, 'peminjaman_id', 'id');
    }

}

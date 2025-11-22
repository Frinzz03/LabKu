<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lab extends Model
{
    protected $table = 'lab';      // Sesuai SQL
    protected $primaryKey = 'id_lab'; // Sesuai SQL
    public $timestamps = false;    // Di SQL tidak ada created_at/updated_at di tabel ini

    protected $fillable = ['nama_lab', 'id_admin', 'kapasitas', 'deskripsi'];
}
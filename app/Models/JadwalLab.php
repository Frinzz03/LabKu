<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JadwalLab extends Model
{
    protected $table = 'jadwal_lab';
    protected $primaryKey = 'id';
    public $timestamps = false; 

    protected $fillable = ['lab_id', 'tanggal', 'jam_mulai', 'jam_selesai', 'status', 'kegiatan'];

    // Relasi ke Lab
    public function lab()
    {
        return $this->belongsTo(Lab::class, 'lab_id', 'id_lab');
    }
}
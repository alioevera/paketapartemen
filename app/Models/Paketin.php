<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Paketin extends Model
{
    protected $table = 'paketin';
    protected $primaryKey = 'paketin_id';
    public $timestamps = false;

    protected $fillable = [
        'user_nik',
        'input_date',
        'tower_id',
        'penghuni_id',
        'unit',
        'bentuk_paket',
        'jumlah_paket',
        'lokasi_simpan',
        'expedisi_id',
        'foto_paket',
        'hasil_ocr',
        'status_verifikasi',
    ];

    protected $casts = [
        'input_date' => 'datetime',
    ];

    public function reception()
    {
        return $this->belongsTo(Reception::class, 'user_nik', 'user_nik');
    }

    public function expedisi()
    {
        return $this->belongsTo(Expedisi::class, 'expedisi_id', 'expedisi_id');
    }

    public function tower()
    {
        return $this->belongsTo(Tower::class, 'tower_id', 'tower_id');
    }

    public function penghuni()
    {
        return $this->belongsTo(Penghuni::class, 'penghuni_id', 'penghuni_id');
    }

    public function paketout()
    {
        return $this->hasOne(Paketout::class, 'paketin_id', 'paketin_id');
    }
}
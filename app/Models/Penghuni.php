<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penghuni extends Model
{
    protected $table = 'penghuni';
    protected $primaryKey = 'penghuni_id';
    public $timestamps = false;

    protected $fillable = [
        'tower_id',
        'unit',
        'nama_penghuni',
        'nomor_telepon',
        'email',
    ];

    public function tower()
    {
        return $this->belongsTo(Tower::class, 'tower_id', 'tower_id');
    }
}
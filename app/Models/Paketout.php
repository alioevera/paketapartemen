<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Paketout extends Model
{
    protected $table = 'paketout';
    protected $primaryKey = 'paketout_id';
    public $timestamps = false;

    protected $fillable = [
        'paketin_id',
        'user_nik',
        'out_date',
        'pengambil',
        'send_pengingat',
        'pengingat_dikirim_at',
    ];

    protected $casts = [
        'out_date' => 'datetime',
        'send_pengingat' => 'boolean',
        'pengingat_dikirim_at' => 'datetime',
    ];

    public function paketin()
    {
        return $this->belongsTo(Paketin::class, 'paketin_id', 'paketin_id');
    }

    public function reception()
    {
        return $this->belongsTo(Reception::class, 'user_nik', 'user_nik');
    }
}
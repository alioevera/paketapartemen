<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expedisi extends Model
{
    protected $table = 'expedisi';
    protected $primaryKey = 'expedisi_id';
    public $timestamps = false;

    protected $fillable = [
        'expedisi_name',
    ];

    public function paketin()
    {
        return $this->hasMany(Paketin::class, 'expedisi_id', 'expedisi_id');
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tower extends Model
{
    protected $table = 'tower';
    protected $primaryKey = 'tower_id';
    public $timestamps = false;

    protected $fillable = [
        'tower_name',
    ];

    public function penghuni()
    {
        return $this->hasMany(Penghuni::class, 'tower_id', 'tower_id');
    }

    public function paketin()
    {
        return $this->hasMany(Paketin::class, 'tower_id', 'tower_id');
    }
}
<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Reception extends Authenticatable
{
    protected $table = 'reception';
    protected $primaryKey = 'user_nik';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'user_nik',
        'user_name',
        'username',
        'password',
        'role',
        'tower_id',
    ];

    protected $hidden = [
        'password',
    ];

    public function tower()
    {
        return $this->belongsTo(Tower::class, 'tower_id', 'tower_id');
    }
}
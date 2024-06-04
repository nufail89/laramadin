<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Lembaga extends Model
{
    protected $table = 't_lembaga';

    public $timestamps = false;

    public function tUsrLembaga()
    {
        return $this->hasMany(TUsrPerson::class, 'lembaga_id');
    }
}

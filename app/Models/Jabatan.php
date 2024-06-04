<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jabatan extends Model
{
    protected $table = 't_jabatan';

    public $timestamps = false;

    public function tUsrLembaga()
    {
        return $this->hasMany(TUsrPerson::class, 'jabatan_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TUsrPerson extends Model
{
    protected $table = 't_usr_person';

    public $timestamps = true;

    public function lembaga()
    {
        return $this->belongsTo(Lembaga::class, 'lembaga_id');
    }

    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class, 'jabatan_id');
    }

    public function asatidz()
    {
        return $this->belongsTo(Asatidz::class, 'person_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

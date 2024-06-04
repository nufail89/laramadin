<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Asatidz extends Model
{
    protected $table = 't_asatidz';

    public $timestamps = true;

    public function usrLembaga()
    {
        return $this->hasMany(TUsrPerson::class, 'person_id');
    }
}

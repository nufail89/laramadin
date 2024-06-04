<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'admin_users';

    public $timestamps = true;

    public function tUsrPerson()
    {
        return $this->hasMany(TUsrPerson::class, 'user_id');
    }
}

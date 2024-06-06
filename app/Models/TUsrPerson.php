<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TUsrPerson extends Model
{
    protected $table = 't_usr_person';

    public $timestamps = true;
    protected $primaryKey = 'id'; // menyatakan kolom id sebagai primary key

    // Mendaftarkan event "creating" untuk model
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $string = md5($model->lembaga_id . '-' . $model->induk);
            $sub = [];
            $sub[1] = substr($string,0,8);
            $sub[2] = substr($string,8,4);
            $sub[3] = substr($string,12,4);
            $sub[4] = substr($string,16,4);
            $sub[5] = substr($string,20,12);
            $model->id = implode('-',$sub);
        });
    }


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

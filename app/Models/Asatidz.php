<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class Asatidz extends Model
{
    protected $table = 't_asatidz';

    public $timestamps = true;

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->nik)) {
                do {
                    $randomNik = Str::random(20);
                } while (static::where('nik', $randomNik)->exists());
                $model->nik = $randomNik;
            }
        });
    }

    public function usrLembaga()
    {
        return $this->hasMany(TUsrPerson::class, 'person_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use OpenAdmin\Admin\Auth\Database\Administrator;


class Admins extends Administrator implements AuthenticatableContract
{
    
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OldUser extends Model
{
    // 更改数据表为Users
    protected $table = 'users';
}

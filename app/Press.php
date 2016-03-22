<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Press extends Model
{
    /**
     * 一个出版社有很多曲子
     * @method musics
     * @return [type] [description]
     */
    public function musics()
    {
        return $this->hasMany('App\Music');
    }
}

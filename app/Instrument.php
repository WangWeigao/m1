<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Instrument extends Model
{
    //
    public function musics()
    {
        /**
         * 一个乐器有很多首曲子
         */
        return $this->hasMany('App\Music');
    }
}

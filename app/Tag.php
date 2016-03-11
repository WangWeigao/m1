<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    /**
     * 曲目的标签
     */
    public function musics()
    {
        return $this->morphedByMany('App\Music', 'taggable');
    }
}

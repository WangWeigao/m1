<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Music extends Model
{
    /**
     * 允许导入的字段
     * @var array
     */
    protected $guarded = [];

    /**
     * 曲子所用的乐器
     */
    public function instrument()
    {
        return $this->belongsTo('App\Instrument');
    }

    /**
     * 曲子的标签
     */
    public function tags()
    {
        return $this->morphToMany('App\Tag', 'taggable');
    }

    /**
     * 曲子的出版社
     */
    public function press()
    {
        return $this->belongsTo('App\Press');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Music extends Model
{
    use softDeletes;
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

    /**
     * 取得添加的用户
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'operator');
    }

    /**
     * 取得备注
     */
    public function editor()
    {
        return $this->belongsTo('App\User', 'note_operator');
    }

    /**
     * 取得主办机构
     */
    public function organizer()
    {
        return $this->belongsTo('App\Organizer', 'organizer_id');
    }
}

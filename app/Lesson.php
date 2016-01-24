<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    protected $primaryKey = 'lid';
    /**
     * 通过课程表获取用户信息
     * @method user
     * @return [type] [description]
     */
    public function user()
    {
        return $this->belongsTo('App\OldUser', 'teacher_uid', 'uid');
    }
}

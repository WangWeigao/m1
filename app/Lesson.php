<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    /**
     * 数据库表中没有时间戳字段, 所以禁用
     * @var boolean
     */
    public $timestamps = false;

    /**
     * 通过课程信息取得教师信息
     * @method user
     * @return [type] [description]
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'uid', 'teacher_uid');
    }
}

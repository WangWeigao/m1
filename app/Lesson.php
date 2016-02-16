<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    /**
     * 允许导入的字段
     * @var array
     */
    protected $guarded = [];

    protected $primaryKey = 'lid';
    /**
     * 通过课程表获取用户信息
     * @method user
     * @return [type] [description]
     */
    public function user()
    {
        return $this->belongsTo('App\StudentUser', 'teacher_uid', 'uid');
    }
}

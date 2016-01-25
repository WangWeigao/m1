<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OldUser extends Model
{
    // 更改数据表为Users
    protected $table = 'users';

    // 不在表中添加 updated_at 和 created_at
    public $timestamps = false;

    /*
     * 获得用户的订单
     * @method orders
     * @return [type] [description]
     */
    public function orders()
    {
        return $this->hasMany('App\Order', 'student_uid', 'uid');
    }


    /**
     * 取得教师发布的课程列表
     * @method lessons
     * @return [type] [description]
     */
    public function lessons()
    {
        return $this->hasMany('App\Lesson', 'teacher_uid', 'uid');
    }
}
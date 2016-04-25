<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudentUser extends Model
{
    /**
     * 允许导入的字段
     * @var array
     */
    protected $guarded = [];

    // 更改数据表为Users
    protected $table = 'users';

    // 更改主键为uid
    protected $primaryKey = 'uid';

    // 不在表中添加 updated_at 和 created_at
    public $timestamps = false;

    /**
     * 需要被强制转换类型的字段
     */
    protected $casts = [
     'instrument_id' => 'json'
    ];

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

    public function robot_durations()
    {
        return $this->hasMany('App\RobotDuration', 'user_id', 'uid');
    }

    public function user_actions()
    {
        return $this->hasMany('App\UserAction', 'user_id', 'uid');
    }
}

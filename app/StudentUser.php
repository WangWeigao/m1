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
    public function robot_orders()
    {
        return $this->hasMany('App\RobotOrder', 'user_id', 'uid');
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

    public function practice()
    {
        return $this->hasMany('App\Practice', 'uid', 'uid');
    }

    public function user_actions()
    {
        return $this->hasMany('App\UserAction', 'user_id', 'uid');
    }

    public function getSexAttribute($value)
    {
        if (in_array($value, [1,2])) {
            $arr = ['男', '女'];
            $value = $arr[$value-1];
        }
        return $value;
    }

    public function getAccountGradeAttribute($value)
    {
        if ($value == 1) {
            $value = 'VIP1';
        }elseif ($value == 2) {
            $value = 'VIP2';
        }else {
            $value = '免费用户';
        }
        return $value;
    }

    public function orders()
    {
        return $this->hasMany('App\RobotOrder', 'user_id', 'uid');
    }

    public function user_prev_month_practice_time_sum()
    {
        return $this->belongTo('App\UserPrevMonthPracticeTimeSum', 'uid', 'uid');
    }

    public function user_curr_month_practice_time_sum()
    {
        return $this->belongTo('App\UserCurrMonthPracticeTimeSum', 'uid', 'uid');
    }

    public function getChannelAttribute($value)
    {
        switch ($value) {
            case '0':
                $user_type = '手机';
                break;
            case '1':
                $user_type = '微信';
                break;
            case '2':
                $user_type = 'QQ';
                break;
            case '3':
                $user_type = '微博';
                break;
            default:
                $user_type = '';
                break;
        }
        return $user_type;
    }

}

<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
// use Illuminate\Database\Eloquent\Model;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * 数据库表中没有时间戳字段, 所以禁用
     * @var boolean
     */
    // public $timestamps = false;


    /**
     * 查询用户的表名称
     */
    protected $table = 'admin_users';

    /*
     * 获得用户的订单
     * @method orders
     * @return [type] [description]
     */
    public function orders()
    {
        return $this->hasMany('App\Order', 'student_uid', 'id');
    }


    /**
     * 取得教师发布的课程列表
     * @method lessons
     * @return [type] [description]
     */
    public function lessons()
    {
        return $this->hasMany('App\Lesson', 'teacher_uid', 'id');
    }


    public function getLogin()
    {
        return view('login');
    }
}

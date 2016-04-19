<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

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
     * Change the default table users to admin_users
     * @var string
     */
    protected $table = 'admin_users';


    /**
     * 用户角色
     * @method roles
     * @return [type] [description]
     */
    public function roles()
    {
        return $this->belongsToMany('App\Role');
    }

    public function musics()
    {
        return $this->hasMany('App\Music', 'operator');
    }

    public function robot_durations()
    {
        return $this->hasMany('App\RobotDuration', 'user_id', 'uid');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    /**
     * 通过订单取得用户信息
     * @method user
     * @return [type] [description]
     */
    public function user()
    {
        return $this->belongsTo('App\OldUser', 'uid', 'teacher_uid');
    }
}

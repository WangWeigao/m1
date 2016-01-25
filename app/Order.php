<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    /**
     * orders表的主键
     * @var integer
     */
    protected $primaryKey = 'oid';

    /**
     * 通过订单取得用户信息
     * @method user
     * @return [type] [description]
     */
    public function user()
    {
        return $this->belongsTo('App\OldUser', 'teacher_uid', 'uid');
    }
}

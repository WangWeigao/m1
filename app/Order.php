<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    /**
     * 允许导入的字段
     * @var array
     */
    protected $guarded = [];

    /**
     * orders表的主键
     * @var string
     */
    protected $primaryKey = 'oid';

    /**
     * 通过订单取得用户信息
     * @method user
     * @return [type] [description]
     */
    public function user()
    {
        return $this->belongsTo('App\StudentUser', 'teacher_uid', 'uid');
    }
}

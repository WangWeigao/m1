<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RobotOrder extends Model
{
    /**
     * 订单状态
     */
    public function getStatusAttribute($value)
    {
        switch ($value) {
            case '1':
                return '待付款';
                break;
            case '2':
                return '取消订单';
                break;
            case '3':
                return '已付款';
                break;

            default:
                return '-';
                break;
        }
    }

    /**
     * 渠道来源
     */
    public function getChannelAttribute($value)
    {
        switch ($value) {
            case '1':
                return 'APPStore';
                break;
            case '2':
                return 'Android';
                break;
            case '3':
                return 'Card';
                break;

            default:
                return '-';
                break;
        }
    }

    public function getTypeAttribute($value)
    {
        switch ($value) {
            case '1':
                return 'VIP1';
                break;
            case '2':
                return 'VIP2';
                break;

            default:
                return '-';
                break;
        }
    }

    public function user()
    {
        return $this->belongsTo('App\StudentUser', 'user_id', 'uid');
    }
}

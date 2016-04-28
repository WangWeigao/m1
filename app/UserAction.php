<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserAction extends Model
{
    public function getDurationAttribute($value)
    {
        if (!empty($value)) {
            $temp = gmstrftime("%H %M %S", $value);
            $temp_array = explode(' ', $temp);
            $value = $temp_array[0] . '小时'
                             . $temp_array[1] . '分'
                             . $temp_array[2] . '秒';
        }
        return $value;
    }
}

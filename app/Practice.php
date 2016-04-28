<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Practice extends Model
{
    protected $table = 'practice';

    public function getMidiPathAttribute($value)
    {
        return explode(',', $value);
    }

    public function getErrorNumberAttribute($value)
    {
        return explode(',', $value);
    }

    public function getErrorTempoAttribute($value)
    {
        return explode(',', $value);
    }

    public function music()
    {
        return $this->belongsTo('App\Music', 'music_id', 'id');
    }


    public function getPracticeTimeAttribute($value)
    {
        if (!empty($value)) {
            $temp = gmstrftime('%H %M %S', $value);
            $temp = explode(' ', $temp);
            $value = $temp[0] .'小时'
                    . $temp[1] .'分'
                    . $temp[2] .'秒';
        }
        return $value;
    }

}

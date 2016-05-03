<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Play_record extends Model
{
    /**
     * 允许软删除
     */
    protected $dates = ['deleted_at'];

    /**
     *
     */
    protected $casts = [
        'errors' => 'array'
    ];

    public function music()
    {
        return $this->belongsTo('App\Music', 'music_id', 'id');
    }

    public function getDurationAttribute($value)
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

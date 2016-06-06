<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Practice extends Model
{
    protected $table = 'practice';
    protected $primaryKey = 'pid';
    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo('App\StudentUser', 'uid', 'uid');
    }

    public function getMidiPathAttribute($value)
    {
        return explode(',', $value);
    }

    public function getOriginMidiPathAttribute($value)
    {
        return explode(',', $value);
    }

    public function getMatchMeasuresAttribute($value)
    {
        return explode(',', $value);
    }

    public function getErrorMeasuresAttribute($value)
    {
        return explode(',', $value);
    }

    public function getFastMeasuresAttribute($value)
    {
        return explode(',', $value);
    }

    public function getSlowMeasuresAttribute($value)
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
            $temp = gmstrftime('%M %S', $value);
            $temp = explode(' ', $temp);
            $value = $temp[0] .':'
                    . $temp[1];
        }
        return $value;
    }

}

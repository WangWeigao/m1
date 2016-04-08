<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Play_record extends Model
{
    public function music()
    {
        return $this->belongsTo('App\Music', 'music_id', 'id');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MatchForTest extends Model
{
    public function practice() {
        return $this->belongsTo('App\Practice', 'user_id', 'uid');
    }
}

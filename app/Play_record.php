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
    public function music()
    {
        return $this->belongsTo('App\Music', 'music_id', 'id');
    }
}

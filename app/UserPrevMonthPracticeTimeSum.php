<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserPrevMonthPracticeTimeSum extends Model
{
    public $table = 'user_prev_month_practice_time_sum';

    public function user_curr_month_practice_time_sum()
    {
        return $this->hasOne('App\UserCurrMonthPracticeTimeSum', 'uid', 'uid');
    }
}

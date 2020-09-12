<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Time;

class Subject extends Model
{
    public function times()
    {
        return $this->hasMany('App\Models\Time');
    }
}

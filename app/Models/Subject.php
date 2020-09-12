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

    protected static function boot()
    {
        parent::boot();
        static::deleting(function ($model) {
            $times = Time::where('subject_id',$model->id);
            $times->delete();
        });
    }
}

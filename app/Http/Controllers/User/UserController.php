<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Subject;
use App\Models\Spare_time;
use App\Models\Time;
use DB;
use Carbon\Carbon;

class UserController extends Controller
{

    public function training_list()
    {
        $user_id = Auth::id();
        $user = User::with([
            'subjects',
            'subjects.times'
        ])->find($user_id);
        $subject_id = DB::select("SELECT id FROM subjects WHERE user_id = '$user_id'");
        $subject_id = $subject_id[0]->id;
        $times = DB::select("SELECT * FROM times WHERE subject_id = '$subject_id'");
        $reserveds = User::with([
            'subjects',
            'subjects.times' => function ($query) {
                $query->where('is_reserved', true);
            },
        ])->find($user_id);
        return view('user/training_list', [
            'times' => $times,
            'reserveds' => $reserveds,
            'result' => 'none',
        ]);
    }

    public function training_edit()
    {
        return view('user/training_edit', []);
    }

    public function post_training_edit(Request $request)
    {

        $user_id = Auth::id();
        $user = User::with([
            'subjects',
            'subjects.times'
        ])->find($user_id);
        $subject_id = Subject::where('user_id',$user_id)->first();
        $subject_id = $subject_id->id;
        $times_delete = Time::where("subject_id", $subject_id);
        $spare_time = Spare_time::where("user_id", $user_id);
        if ($times_delete != null) {
            $times_delete->delete();
        }

        if ($spare_time != null) {
            $spare_time->delete();
        }

        $subjects = DB::select("SELECT * FROM subjects WHERE user_id = '$user_id'");

        foreach ($subjects as $subject) {
            foreach ($request->times as $time) {
                $user_time = new Time();
                $user_time->subject_id = $subject->id;
                $user_time->time_name = $time;
                $user_time->is_reserved = false;
                $user_time->timestamps = false;
                $user_time->save();

                $user_spare_time = new Spare_time();
                $user_spare_time->time_name = $time;
                $user_spare_time->user_id = $user_id;
                $user_spare_time->timestamps = false;
                $user_spare_time->save();
            }
        }

        $user = User::with([
            'subjects',
            'subjects.times'
        ])->find($user_id);
        $subject_id = DB::select("SELECT id FROM subjects WHERE user_id = '$user_id'");
        $subject_id = $subject_id[0]->id;
        $times = DB::select("SELECT * FROM times WHERE subject_id = '$subject_id'");

        $reserveds = User::with([
            'subjects',
            'subjects.times' => function ($query) {
                $query->where('is_reserved', true);
            },
        ])->find($user_id);

        $result = 'success';
        return view('user/training_list', [
            'user' => $user,
            'times' => $times,
            'result' => $result,
            'reserveds' =>$reserveds,
        ]);
    }
}

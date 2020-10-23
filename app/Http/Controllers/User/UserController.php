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
        $subject_id = DB::select("SELECT id FROM subjects WHERE user_id = '$user_id'");
        $subject_id = $subject_id[0]->id;
        $times = DB::select("SELECT * FROM times WHERE subject_id = '$subject_id'");
        $time_list = [];
        foreach ($times as $time) {
            $time_list[] = $time->time_name;
        }
        $time_list = array_unique($time_list);
        $reserveds = User::with([
            'subjects',
            'subjects.times' => function ($query) {
                $query->where('is_reserved', true);
            },
        ])->find($user_id);
        $time_unique = [];
        foreach ($reserveds->subjects as $subject) {
            foreach ($subject->times as $time) {
                array_push($time_unique, $time->time_name);
            }
        }
        $time_unique = array_unique($time_unique);
        foreach ($time_unique as $value) {
            $kamoku = [];
            foreach ($reserveds->subjects as $subject) {
                foreach ($subject->times as $time) {
                    if ($time->time_name === $value) {
                        array_push($kamoku, $subject->name);
                    }
                }
            }
            $reserve_list[$value] = $kamoku;
        }
        return view('user/training_list', [
            'time_list' => $time_list,
            'reserve_list' => $reserve_list,
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
        $subject_id = Subject::where('user_id', $user_id)->get();
        foreach ($subject_id as $id) {
            $times_delete = Time::where("subject_id", $id->id)->get();
            if ($times_delete != null) {
                foreach ($times_delete as $time_delete) {
                    $time_delete->delete();
                }
            }
        }
        $spare_time = Spare_time::where("user_id", $user_id);

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
            }
        }

        foreach ($request->times as $time) {
            $user_spare_time = new Spare_time();
            $user_spare_time->time_name = $time;
            $user_spare_time->user_id = $user_id;
            $user_spare_time->timestamps = false;
            $user_spare_time->save();
        }


        $subject_id = DB::select("SELECT id FROM subjects WHERE user_id = '$user_id'");
        $subject_id = $subject_id[0]->id;
        $times = DB::select("SELECT * FROM times WHERE subject_id = '$subject_id'");
        $time_list = [];
        foreach ($times as $time) {
            $time_list[] = $time->time_name;
        }
        $time_list = array_unique($time_list);
        $reserveds = User::with([
            'subjects',
            'subjects.times' => function ($query) {
                $query->where('is_reserved', true);
            },
        ])->find($user_id);
        $time_unique = [];
        foreach ($reserveds->subjects as $subject) {
            foreach ($subject->times as $time) {
                array_push($time_unique, $time->time_name);
            }
        }
        $time_unique = array_unique($time_unique);
        foreach ($time_unique as $value) {
            $kamoku = [];
            foreach ($reserveds->subjects as $subject) {
                foreach ($subject->times as $time) {
                    if ($time->time_name === $value) {
                        array_push($kamoku, $subject->name);
                    }
                }
            }
            $reserve_list[$value] = $kamoku;
        }
        if(empty($reserve_list)){
            $reserve_list = null;
        }
        return view('user/training_list', [
            'time_list' => $time_list,
            'reserve_list' => $reserve_list,
            'result' => 'none',
        ]);
    }
}

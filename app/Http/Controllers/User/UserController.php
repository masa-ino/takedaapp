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
        if (empty($reserve_list)) {
            $reserve_list = null;
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
        $reserved_list = [];
        $no_search_time_list = [];
        foreach ($subject_id as $id) {
            $times_delete = Time::where("subject_id", $id->id)->get();
            if ($times_delete != null) {
                $reserved_time_list = [];
                foreach ($times_delete as $time_delete) {
                    if ($time_delete->is_reserved == true) {
                        array_push($reserved_time_list, $time_delete->time_name);
                        array_push($no_search_time_list, $time_delete->time_name);
                    }
                    $time_delete->delete();
                }
            }
            if (!empty($reserved_time_list)) {
                $reserved_list[$id->name] = $reserved_time_list;
            }
        }
        $spare_time = Spare_time::where("user_id", $user_id);

        if ($spare_time != null) {
            $spare_time->delete();
        }
        $no_search_time_list = array_unique($no_search_time_list);
        $subjects = DB::select("SELECT * FROM subjects WHERE user_id = '$user_id'");
        foreach ($subjects as $subject) {
            foreach ($request->times as $time) {
                $user_time = new Time();
                $user_time->subject_id = $subject->id;
                $user_time->time_name = $time;
                $user_time->is_reserved = false;
                if (isset($reserved_list[$subject->name])) {
                    foreach ($reserved_list[$subject->name] as $reserved_time) {
                        if ($reserved_time === $user_time->time_name) {
                            $user_time->is_reserved = true;
                        }
                    }
                }
                foreach($no_search_time_list as $no_search_time_name){
                    if($time === $no_search_time_name){
                        $user_time->no_search = true;
                    }
                }


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
        if (empty($reserve_list)) {
            $reserve_list = null;
        }
        return view('user/training_list', [
            'time_list' => $time_list,
            'reserve_list' => $reserve_list,
            'result' => 'none',
        ]);
    }
}

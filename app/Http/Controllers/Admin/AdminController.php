<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Subject;
use App\Models\Time;
use App\Models\Spare_time;
use DB;

class AdminController extends Controller
{
    public function create_user()
    {

        return view('admin/create_user', [
            'result' => 'none',
        ]);
    }

    public function post_create_user(Request $request)
    {
        // フォルダモデルのインスタンスを作成する
        $user = new User();
        // タイトルに入力値を代入する
        $user->name = $request->name;
        $user->password = Hash::make($request->password);
        $user->created_at = Carbon::now();

        $users = DB::select("SELECT * FROM users WHERE name = '$user->name'");
        if ($users) {
            $result = 'error';
            return view('admin/create_user', [
                'result' => $result,
            ]);
        } else {
            $result = 'success';
            $user->save();
        }

        $user_id = DB::select("SELECT id FROM users WHERE name = '$user->name'");
        $id = $user_id[0]->id;

        foreach ($request->subjects as $subject) {
            $user_subject = new Subject();
            $user_subject->user_id = $id;
            $user_subject->name = $subject;
            $user_subject->timestamps = false;
            $user_subject->save();
        }

        return view('admin/create_user', [
            'result' => $result,
        ]);
    }

    public function user_list()
    {

        $users = User::with('subjects:user_id,name')->get();

        return view('admin/user_list', [
            'users' => $users,
            'result' => 'none',
        ]);
    }

    public function user_delete(User $user)
    {
        if ($user != null) {
            $delete_subjects = Subject::where('user_id', $user->id)->get();
            $subject_id = $delete_subjects[0]->id;
            $delete_times =Time::where('subject_id', $subject_id)->get();
            foreach($delete_times as $delete_time){
                $delete_time->delete();
            }
            foreach($delete_subjects as $delete_subject){
                $delete_subject->delete();
            }
            $delete_spare_times = Spare_time::where('user_id', $user->id)->get();
            foreach($delete_spare_times as $delete_spare_time){
                $delete_spare_time->delete();
            }
            $user->delete();
            $result = 'success';
        } else {
            $result = 'error';
        }

        $users = User::with('subjects:user_id,name')->get();

        return view('admin/user_list', [
            'users' => $users,
            'result' => $result
        ]);
    }

    public function user_edit(User $user)
    {
        return view('admin/user_edit', [
            'user' => $user,
            'result' => 'none'
        ]);
    }

    public function post_user_edit(User $user, Request $request)
    {

        $user->updated_at = Carbon::now();
        $delete_subjects = Subject::where('user_id', $user->id)->get();
        foreach($delete_subjects as $delete_subject){
            $delete_subject->delete();
        }

        foreach ($request->subjects as $subject) {
            $user_subject = new Subject();
            $user_subject->user_id = $user->id;
            $user_subject->name = $subject;
            $user_subject->timestamps = false;
            $user_subject->save();
        }
        $spare_times = Spare_time::where("user_id", $user->id)->get();
        if ($spare_times != null) {
            $subjects = Subject::where('user_id', $user->id)->get();
            foreach ($subjects as $subject) {
                foreach ($spare_times as $time) {
                    $user_time = new Time();
                    $user_time->subject_id = $subject->id;
                    $user_time->time_name = $time->time_name;
                    $user_time->is_reserved = false;
                    $user_time->timestamps = false;
                    $user_time->save();
                }
            }
        }
        $user->save();

        $users = User::with('subjects:user_id,name')->get();

        $result = "success_edit";

        return view('admin/user_list', [
            'users' => $users,
            'result' => $result,
        ]);
    }

    public function training_search()
    {
        return view('admin/training_search', [
            'result' => 'none',
        ]);
    }

    public function post_training_search(Request $request)
    {
        $subject_list = [];
        $time_list = [];
        $result = 'none';
        if ($request->subjects && $request->times) {
            foreach ($request->subjects as $subject_key => $subject) {
                array_push($subject_list, $subject);
            }
            foreach ($request->times as $time_key => $time) {
                array_push($time_list, $time);
            }

            $users = User::with([
                'subjects' => function ($query) use ($subject_list) {
                    $query->whereIn('name', $subject_list);
                },
                'subjects.times' => function ($query) use ($time_list) {
                    $query->whereIn('time_name', $time_list);
                    $query->where('is_reserved', 'false');
                },
            ])->get();
            $i = 0;
            foreach ($users as $user) {
                foreach ($user->subjects as $subject) {
                    foreach ($subject->times as $time) {
                        if ($subject && $time) {
                            $i++;
                        }
                    }
                }
            }
            if ($i !== 0) {
                $result = 'success';
            }
        } elseif ($request->subjects && !$request->times) {
            foreach ($request->subjects as $subject_key => $subject) {
                array_push($subject_list, $subject);
            }

            $users = User::with([
                'subjects' => function ($query) use ($subject_list) {
                    $query->whereIn('name', $subject_list);
                },
                'subjects.times' => function ($query) {
                    $query->where('is_reserved', 'false');
                },
            ])->get();
            $i = 0;
            foreach ($users as $user) {
                foreach ($user->subjects as $subject) {
                    foreach ($subject->times as $time) {
                        if ($subject && $time) {
                            $i++;
                        }
                    }
                }
            }
            if ($i !== 0) {
                $result = 'success';
            }
        } elseif (!$request->subjects && $request->times) {
            foreach ($request->times as $time_key => $time) {
                array_push($time_list, $time);
            }

            $users = User::with([
                'subjects',
                'subjects.times' => function ($query) use ($time_list) {
                    $query->whereIn('time_name', $time_list);
                    $query->where('is_reserved', 'false');
                },
            ])->get();
            $i = 0;
            foreach ($users as $user) {
                foreach ($user->subjects as $subject) {
                    foreach ($subject->times as $time) {
                        if ($subject && $time) {
                            $i++;
                        }
                    }
                }
            }
            if ($i !== 0) {
                $result = 'success';
            }
        } else {
            $users = null;
        }
        return view('admin/result_search', [
            'users' => $users,
            'result' => $result,
        ]);
    }

    public function post_training_search_result(Time $time)
    {
        $time->is_reserved = true;
        $time->timestamps = false;
        $time->save();
        $result = 'success';
        return view('admin/training_search', [
            'result' => $result,
        ]);
    }

    public function training_reserved()
    {
        $users = User::with([
            'subjects',
            'subjects.times' => function ($query) {
                $query->where('is_reserved', true);
            },
        ])->get();
        return view('admin/training_reserved', [
            'users' => $users,
            'result' => 'none',
        ]);
    }

    public function post_training_reserved(Time $time)
    {
        $time->is_reserved = false;
        $time->timestamps = false;
        $time->save();
        $result = 'success';
        $users = User::with([
            'subjects',
            'subjects.times' => function ($query) {
                $query->where('is_reserved', true);
            },
        ])->get();
        return view('admin/training_reserved', [
            'users' => $users,
            'result' => $result,
        ]);
    }
}

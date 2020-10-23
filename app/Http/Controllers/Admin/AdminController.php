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
            foreach ($delete_subjects as $delete_subject) {
                $delete_times = Time::where('subject_id', $delete_subject->id)->get();
                foreach ($delete_times as $delete_time) {
                    $delete_time->delete();
                }
                $delete_subject->delete();
            }
            $delete_spare_times = Spare_time::where('user_id', $user->id)->get();
            foreach ($delete_spare_times as $delete_spare_time) {
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
        foreach ($delete_subjects as $delete_subject) {
            $delete_times = Time::where('subject_id', $delete_subject->id)->get();
            foreach ($delete_times as $delete_time) {
                $delete_time->delete();
            }
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
        $user_list = [];
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
                    $query->where('no_search', false);
                },
            ])->get();
            $i = 0;
            foreach ($users as $user) {
                $subject_check = 0;
                foreach ($user->subjects as $subject) {
                    foreach ($subject_list as $subject_part) {
                        if ($subject_part === $subject->name) {
                            $subject_check++;
                        }
                    }
                }
                if ($subject_check === count($subject_list)) {
                    array_push($user_list, $user);
                }
            }
            foreach ($user_list as $user) {
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
                    $query->where('no_search', false);
                },
            ])->get();
            $i = 0;
            foreach ($users as $user) {
                $subject_check = 0;
                foreach ($user->subjects as $subject) {
                    foreach ($subject_list as $subject_part) {
                        if ($subject_part === $subject->name) {
                            $subject_check++;
                        }
                    }
                }
                if ($subject_check === count($subject_list)) {
                    array_push($user_list, $user);
                }
            }
            foreach ($user_list as $user) {
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
                    $query->where('is_reserved', false);
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
            'users' => $user_list,
            'result' => $result,
            'subjects' => $subject_list,
        ]);
    }

    public function post_training_search_result(User $user, Time $time, Request $request)
    {
        $subjects = $request->subjects;
        $search_user = User::with([
            'subjects' => function ($query) use ($subjects) {
                $query->whereIn('name', $subjects);
            },
            'subjects.times' => function ($query) use ($time) {
                $query->where('time_name', $time->time_name);
            },
        ])->find($user->id);
        foreach ($search_user->subjects as $search_subject) {
            foreach ($search_subject->times as $search_time) {
                $search_time->is_reserved = true;
                $search_time->timestamps = false;
                $search_time->save();
            }
        }
        $no_search_user = User::with([
            'subjects',
            'subjects.times' => function ($query) use ($time) {
                $query->where('time_name', $time->time_name);
            },
        ])->find($user->id);
        foreach ($no_search_user->subjects as $search_subject) {
            foreach ($search_subject->times as $search_time) {
                $search_time->no_search = true;
                $search_time->timestamps = false;
                $search_time->save();
            }
        }
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
        $user_list = [];
        foreach ($users as $user) {
            $user_content = [];
            $user_content['name'] = $user->name;
            $user_content['id'] = $user->id;

            $time_unique = [];
            foreach ($user->subjects as $subject) {
                foreach ($subject->times as $time) {
                    array_push($time_unique, $time->time_name);
                }
            }
            $time_unique = array_unique($time_unique);
            $times_list = [];
            foreach ($time_unique as $value) {
                $reserve_list = [];
                $kamoku = [];
                foreach ($user->subjects as $subject) {
                    foreach ($subject->times as $time) {
                        if ($time->time_name === $value) {
                            array_push($kamoku, $subject->name);
                        }
                    }
                }
                $reserve_list['time_name'] = $value;
                $reserve_list['subjects'] = $kamoku;
                array_push($times_list, $reserve_list);
            }
            $user_content['times'] = $times_list;
            if (!empty($user_content['times'])) {
                array_push($user_list, $user_content);
            }
        }



        return view('admin/training_reserved', [
            'users' => $user_list,
            'result' => 'none',
        ]);
    }

    public function post_training_reserved(User $user, Request $request)
    {
        $users = User::with([
            'subjects' => function ($query) use ($request) {
                $query->whereIn('name', $request->subjects);
            },
            'subjects.times' => function ($query) use($request){
                $query->where('is_reserved', true)
                ->where('time_name',$request->time);
            }
        ])->find($user->id);
        foreach ($users->subjects as $subject) {
            foreach ($subject->times as $time) {
                $time->is_reserved = false;
                $time->timestamps = false;
                $time->save();
            }
        }
        $search_users = User::with([
            'subjects',
            'subjects.times' => function ($query) use ($request) {
                $query->where('time_name', $request->time);
            },
        ])->find($user->id);
        foreach ($search_users->subjects as $subject) {
            foreach ($subject->times as $time) {
                $time->no_search = false;
                $time->timestamps = false;
                $time->save();
            }
        }
        $result = 'success';


        $update_users = User::with([
            'subjects',
            'subjects.times' => function ($query) {
                $query->where('is_reserved', true);
            },
        ])->get();
        $user_list = [];
        foreach ($update_users as $user_one) {
            $user_content = [];
            $user_content['name'] = $user_one->name;
            $user_content['id'] = $user_one->id;

            $time_unique = [];
            foreach ($user_one->subjects as $subject) {
                foreach ($subject->times as $time) {
                    array_push($time_unique, $time->time_name);
                }
            }
            $time_unique = array_unique($time_unique);
            $times_list = [];
            foreach ($time_unique as $value) {
                $reserve_list = [];
                $kamoku = [];
                foreach ($user_one->subjects as $subject) {
                    foreach ($subject->times as $time) {
                        if ($time->time_name === $value) {
                            array_push($kamoku, $subject->name);
                        }
                    }
                }
                $reserve_list['time_name'] = $value;
                $reserve_list['subjects'] = $kamoku;
                array_push($times_list, $reserve_list);
            }
            $user_content['times'] = $times_list;
            if (!empty($user_content['times'])) {
                array_push($user_list, $user_content);
            }
        }



        return view('admin/training_reserved', [
            'users' => $user_list,
            'result' => 'none',
        ]);
    }
}

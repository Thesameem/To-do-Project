<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tasks;

class TasksController extends Controller
{
    public function show(Request $request){
        $User = $request->user();
        $UserTasks=Tasks::where('user_id',$User->id)->get();
        return $UserTasks;
    }

    }



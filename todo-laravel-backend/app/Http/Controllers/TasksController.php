<?php

namespace App\Http\Controllers;

use App\Models\Tasks;
use App\Models\Activity;
use Illuminate\Http\Request;

class TasksController extends Controller {

    
    public function show (Request $request) {

        $user = $request->user();
        $UserTasks = Tasks::where('user_id', $user->id)->get();

        $Activities = Activity::all();
        $index = 0;
        $AllActivities = array();
        foreach ($Activities as $key => $value) {
            $AllActivities[$index] = array (
                'id'            => $value->id,
                'user_id'       => $value->user_id,
                'title'         => $value->title,
                'description'   => $value->description,
                'unread'        => $value->unread
            );
        }

        return response()->json([
            'success'   => true,
            'reason'    => null,
            'response'  => [
                'tasks' => $UserTasks,
                'activities' => $AllActivities
            ]
        ]);

    }


    public function create (Request $request) {
        $UserID = $request->user()->id;
        $NewTask = Tasks::create([
            'user_id'       => $UserID,
            'title'         => $request->title,
            'description'   => $request->description
        ]);

        // create activity
        Activity::create([
            'user_id'   => $UserID,
            'icon'      => 'user',
            'detail'    => 'You have created new task <strong>' . $request->title . '</strong>',
            'unread'    => true
        ]);

        return response()->json([
            'success'   => true,
            'reason'    => 'created',
            'response'  => $NewTask
        ]);
    }

    public function delete (Request $request, $id) {
        $UserID = $request->user()->id;

        // get the task anc collect detail info for activity
        $Task = Tasks::where('user_id', $UserID)->where('id', $id)->first();
        $Detail = 'You have deleted a task <strong>' . $Task->title . '</strong>';

        Tasks::where('user_id', $UserID)->where('id', $id)->delete();

        // create activity
        Activity::create([
            'user_id'   => $UserID,
            'icon'      => 'delete',
            'detail'    => $Detail,
            'unread'    => true
        ]);

        return response()->json([
            'error'     => false,
            'reason'    => 'deleted',
            'response'  => null
        ]);
    }

    // this method will work for both function complete or incomplete
    // to set as true or false (toggle)
    public function complete (Request $request, $id) {
        $UserID = $request->user()->id;
        $Task = Tasks::where('user_id', $UserID)->where('id', $id)->first();

        // get detail message
        $Detail = "";
        if ($Task->completed) $Detail = "Task <strong>" . $Task->title . "</strong> successfully incomplete.";
        else $Detail = "Task " . '<strong>' . $Task->title . "</strong> successfully completed";

        // update complete or incomplete
        $Task->update([
            'completed'     => !$Task->completed
        ]);

        // create activity
        Activity::create([
            'user_id'   => $UserID,
            'icon'      => 'complete',
            'detail'    => $Detail,
            'unread'    => true
        ]);

        return response()->json([
            'error'     => false,
            'reason'    => 'updated',
            'response'  => $Task
        ]);
    }

    // this method will work for both function favorite or unfavorite
    // to set as true or false (toggle)
    public function favorite (Request $request, $id) {
        $UserID = $request->user()->id;
        $Task = Tasks::where('user_id', $UserID)->where('id', $id)->first();

        // get detail message
        $Detail = "";
        if (!$Task->favorite) $Detail = "Task <strong>" . $Task->title . "</strong> favorite in your list.";
        else $Detail = "Task <strong>" . $Task->title . "</strong> unfavorite from your list.";

        // update complete or incomplete
        $Task->update([
            'favorite'     => !$Task->favorite
        ]);

        // create activity
        Activity::create([
            'user_id'   => $UserID,
            'icon'      => 'favorite',
            'detail'    => $Detail,
            'unread'    => true
        ]);

        return response()->json([
            'error'     => false,
            'reason'    => 'updated',
            'response'  => $Task
        ]);
    }

    // update task
    public function update (Request $request, $id) {
        $UserID = $request->user()->id;
        $Task = Tasks::where('user_id', $UserID)->where('id', $id)->first();

        $Task->update($request->all());

         // create activity
         Activity::create([
            'user_id'   => $UserID,
            'icon'      => 'update',
            'detail'    => 'You have updated a task <strong>' . $request->title . '</strong>',
            'unread'    => true
        ]);

        return response()->json([
            'error'     => false,
            'reason'    => 'updated',
            'response'  => $Task
        ]);
    }

    
}

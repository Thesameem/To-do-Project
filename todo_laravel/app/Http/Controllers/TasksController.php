<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tasks;
use App\Models\Activity;

class TasksController extends Controller
{
    public function show(Request $request){
        $User = $request->user();
        $UserTasks=Tasks::where('user_id',$User->id)->get();
        return response()->json([
            'success'=> true,
            'reason'=>null,
            'response'=>$UserTasks,
        ]);


    }

    public function create(Request $request){
        $UserID=$request->user()->id;
       $NewTask= Tasks::create([
        'user_id'     =>$UserID,
        'title'       =>$request->title,
        'description' =>$request->description,
       ]);

       //create activity
         Activity::create([
            'user_id'  => $UserID,
            'icon'  => 'user',
            'detail'    =>  'You have created new task' .$request->title,
           ]);
       return response()->json([
        'success'    =>true,
        'reason'     =>'create',
        'response'   =>$NewTask,
       ]);
    }
    public function delete(Request $request,$id){
        $UserID=$request->user()->id;

        //get the task and collect detail info for activity
        $Task=Tasks::where('user_id',$UserID)->where('id', $id)->first();
        $Detail = 'You have a deleted a task'  .$Task->title;

        $Task=Tasks::where('user_id',$UserID)->where('id', $id)->delete();

        Activity::create([
            'user_id'  => $UserID,
            'icon'  => 'delete',
            'detail'    => $Detail, 
           ]);

        return response()->json([
            'success'  =>true,
            'reason'   =>'deleted',
            'response' =>null,
            
        ]);
    }

    //this will work for both function complete and incomplete 
    public function complete(Request $request,$id){
        $UserID=$request->user()->id;
        $Task=Tasks::where('user_id',$UserID)->where('id',$id)->first();

        //get detail message
        $Detail="";
        if($Task->completed) $Detail='Task' . $Task->title . 'Successfully incomplete';
        else $Detail='Task' . $Task->title . 'successfully completed';

        //update complete pr incomplete
        $Task->update([
            'completed'   =>!$Task->completed,
        ]);

        Activity::create([
            'user_id'  => $UserID,
            'icon'  => 'complete',
            'detail'    =>  $Detail,
           ]);
        return response()->json([
            'error'  =>false,
            'reason'   =>'updated',
            'response' =>$Task,
            
        ]);
    }

        //this will work for both function favourite and unfavourite

        public function favourite(Request $request,$id){
           $UserID=$request->user()->id;
           $Task= Tasks::where('user_id',$UserID)->where('id',$id)->first();
            
        //get detail message
        $Detail="";
        if($Task->favourite) $Detail='Task' . $Task->title . 'Successfully favourite in my list';
        else $Detail='Task' . $Task->title . 'unfavourite from list';
            //update complete pr incomplete
            $Task->update([
                'favourite'   =>!$Task->favourite,
            ]);

            Activity::create([
                'user_id'  => $UserID,
                'icon'  => 'favourite',
                'detail'    =>  $Detail,
               ]);

            
            return response()->json([
                'error'  =>false,
                'reason'   =>'updated',
                'response' =>$Task,
                
            ]);

        }
         //update task
            public function updatetask(Request $request,$id) {
                $UserID=$request->user()->id;
                $Task= Tasks::where('user_id',$UserID)->where('id',$id)->first();
                //update task
                $Task->update($request->all());

                Activity::create([
                    'user_id'  => $UserID,
                    'icon'  => 'favourite',
                    'detail'    => 'You have updated a task' . $request->title,
                   ]);
    

                return response()->json([
                    'error'   =>false,
                    'reason'  =>'task updated',
                    'response'  => $Task,
                ]);
            }
}



<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tasks;

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
       return response()->json([
        'success'    =>true,
        'reason'     =>'create',
        'response'   =>$NewTask,
       ]);
    }

    public function delete(Request $request,$id){
        $UserID=$request->user()->id;
        Tasks::where('user_id',$UserID)->where('id', $id)->delete();
        return response()->json([
            'success'  =>true,
            'reason'   =>'deleted',
            'response' =>null,
            
        ]);
    }

    //this will work for both function complete and incomplete 
    public function complete(Request $request,$id){
        $UserID=$request->user()->id;
       $Task= Tasks::where('user_id',$UserID)->where('id',$id)->first();

        //update complete pr incomplete
        $Task->update([
            'completed'   =>!$Task->completed,
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
    
            //update complete pr incomplete
            $Task->update([
                'favourite'   =>!$Task->favourite,
            ]);

            
            return response()->json([
                'error'  =>false,
                'reason'   =>'updated',
                'response' =>$Task,
                
            ]);
        }
}



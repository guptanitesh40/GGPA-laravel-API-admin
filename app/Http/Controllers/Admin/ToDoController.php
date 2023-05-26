<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\AddToDoRequest;
use App\Models\ToDo;
use Crypt;
use DB;
class ToDoController extends Controller
{
    //

    public function __construct() {
    }

    public function add(AddToDoRequest $request) {
        DB::beginTransaction();
        try {

            if(!empty($request->id)) $id=Crypt::decrypt($request->id);

            if(!empty($id))
                $toDoObj=ToDo::find($id);
            else
               $toDoObj=new ToDo;

        	$toDoObj->to_do_text=$request->to_do_text;
            $toDoObj->due_time=date('Y-m-d H:i:s',strtotime($request->due_time));
        	$toDoObj->active_flag=1;
        	if($toDoObj->save()) {
                DB::commit();
                return redirect()->back()->with('msg',"Item added successfully");
            }
            else {
                DB::rollBack();
                return redirect()->back()->with('error_msg',"Error occurred, Please try again later");
            }
            
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect(route('admin.error')); 
        }
    }

    public function changeToDoStatus(Request $request) {

        try {
        
            $toDoObj=ToDo::find(Crypt::decrypt($request->id));
            $toDoObj->active_flag=$request->status;
            $toDoObj->save();
            echo 1;
        
        } catch (\Exception $e) {
            echo 0;
        }
    }

    public function changeItemOrder(Request $request) {
        try {
            $i=0;
            foreach ($request->item as $key => $value) {
                
                $toDoObj=ToDo::find($value);
                $toDoObj->order_by=$i;
                $toDoObj->save();
                $i++;
            }
            echo 1;
            
        } catch (\Exception $e) {
            echo 0;
        }
    }



}

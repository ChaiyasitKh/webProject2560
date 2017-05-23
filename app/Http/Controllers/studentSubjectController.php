<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\subject;
use App\practice;
use App\user;
use Auth;
class studentSubjectController extends Controller
{
    public function index(Request $request){
      if(Auth::user() == null){
        return redirect('login');
      }
      $sub_id = $request->input('sub_id');
      $tmp_sub_name = subject::where('sub_id',$sub_id)->select('sub_name')->get();
      $sub_name = $tmp_sub_name[0]->sub_name;
      $current_date = date('Y-m-d H:i:s');
      $tmp_obj = practice::where('sub_id',$sub_id)->where('send_late','>',$current_date)
                            ->orderBy('created_at','desc')->get();
      $obj = array();
      foreach ($tmp_obj as $key => $value) {
        $check_file = $value->sub_id."_".$value->pract_id.".txt";
        if(file_exists($check_file)){
          $obj[$key] = $tmp_obj[$key];
        }
      }
      //$obj = practice::where('sub_id',$sub_id)->where('send_late','>',$current_date)->get();
       //dd($obj);
      $std_obj = user::where('status',"Student")->where('sub_id',$sub_id)->join('subjects','subjects.id' , '=', 'users.id')->get();
      //dd($std_obj);
      return view('studentSubject')->with('sub_id',$sub_id)->with('sub_name',$sub_name)
                                  ->with('obj',$obj)->with('std_obj',$std_obj);

    }

}

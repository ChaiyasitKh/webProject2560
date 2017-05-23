<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\subject;
use App\practice;
use App\user;
use App\score;
use Auth;
class subjectController extends Controller
{
    //
    public function index(Request $request){
      if(Auth::user() == null){
        return redirect('login');
      }
      $sub_id = $request->input('sub_id');
      $delete_sub = $request->input('delete');
      if($delete_sub != null){//delete feature------------------------------------
        //dd($sub_id);
        subject::where('sub_id',$sub_id)->delete();
        practice::where('sub_id',$sub_id)->delete();
        score::where('sub_id',$sub_id)->delete();
        return redirect('/');
      }
      $tmp_sub_name = subject::where('sub_id',$sub_id)->select('sub_name')->get();
      $sub_name = $tmp_sub_name[0]->sub_name;
      //dd($sub_name);
      $obj = practice::where('sub_id',$sub_id)->orderBy('created_at','desc')->get();
      $std_obj = user::where('status',"Student")->where('sub_id',$sub_id)->join('subjects','subjects.id' , '=', 'users.id')->get();
      //dd($sub_id);
      return view('subject')->with('sub_name',$sub_name)->with('obj',$obj)->with('subID',$sub_id)->with('std_obj',$std_obj);
    }
    public function store(Request $request){
      if(Auth::user() == null){
        return redirect('login');
      }
      //  echo $request->input('pracName')."<br>";
      //  echo  $request->input('pracID')."<br>";
      //  echo  $request->input('sub_id')."<br>";
      // dd($request);

       $sub_id = $request->input('sub_id');
       $sub_name = $request->input('sub_name');
       $prac_name = $request->input('pracName');
       $prac_id = $request->input('pracID');
       $due_date = $request->input('due_date');
       $hr = $request->input('hr');
       $min = $request->input('min');
       $split = explode("/",$due_date);
       $date = $split[2]."-".$split[0]."-".$split[1]." ".$hr.":".$min.":00";
       $Fdate = date_create_from_format('Y-m-d H:i:s', $date);//https://stackoverflow.com/questions/8063057/convert-this-string-to-datetime
      // dd($split,$date,$Fdate,$hr,$min);

       $obj = new practice();
       $obj->sub_id = $sub_id;
       $obj->pract_name = $prac_name;
       $obj->pract_ID = $prac_id;
       $obj->send_late = $Fdate;
       $obj->save();
       $obj = practice::where('sub_id',$sub_id)->orderBy('created_at','desc')->get();
       $std_obj = user::where('status',"Student")->join('subjects','subjects.id' , '=', 'users.id')->get();

       return view('subject')->with('sub_name',$sub_name)->with('obj',$obj)->with('subID',$sub_id)->with('std_obj',$std_obj);
    }

}

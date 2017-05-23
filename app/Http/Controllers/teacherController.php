<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\subject;

class teacherController extends Controller
{
    //
    public function index(){
      if(Auth::user() == null){
        return redirect('login');
      }
       $user_id = Auth::user()->id;
       $obj = subject::where('id',$user_id)->orderBy('created_at','desc')->get();
       return view('teacher')->with('obj',$obj);
    }
    public function store(Request $request){
       $sub_name = $request->input('subName');
       $sub_id = $request->input('subID');
       $user_id = Auth::user()->id;
       $tmp_subID = subject::where('sub_id',$sub_id)->get();

        //check haved sub_id
       if($tmp_subID!="[]"){
         $obj = subject::where('id',$user_id)->orderBy('created_at','desc')->get();
         return view('teacher')->with('obj',$obj);
       }
        //not haved sub_id
       $obj = new subject();
       $obj->id = $user_id;
       $obj->sub_id = $sub_id;
       $obj->sub_name = $sub_name;
       $obj->save();
       $obj = subject::where('id',$user_id)->orderBy('created_at','desc')->get();
       return view('teacher')->with('obj',$obj);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\subject;

class studentController extends Controller
{
    public function index(){
      if(Auth::user() == null){
        return redirect('login');
      }
      $user_id = Auth::user()->id;
      $obj = subject::where('id',$user_id)->get();
      return view('student')->with('obj',$obj);;
    }

    public function store(Request $request){
      if(Auth::user() == null){
        return redirect('login');
      }
      $sub_id = $request->input('sub_id');
      //dd(subject::where('sub_id',$sub_id)->get());
      $subject = subject::where('sub_id',$sub_id)->get();

      if($subject=='[]'){//check null sub_id
        return redirect('/');
      }
      // dd($subject);
      // dd($subject[0]->sub_name);
      $user_id = Auth::user()->id;
      $obj = new subject();
      $obj->id = $user_id;
      $obj->sub_id = $sub_id;
      $obj->sub_name = $subject[0]->sub_name;
      $obj->save();
      $obj = subject::where('id',$user_id)->get();
      return view('student')->with('obj',$obj);;
    }
}

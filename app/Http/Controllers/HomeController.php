<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use App\subject;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // The user is logged in...
        $user = Auth::user();
        //$data = array('name'=>$user->name,'email'=>$user->email);
        if($user->status == 'Teacher'){
          $obj = subject::where('id',$user->id)->get();
          return view('teacher')->with('obj',$obj);
        }
         //student
         $obj = subject::where('id',$user->id)->get();
         return view('student')->with('obj',$obj);

      //return view('home');
    }
}

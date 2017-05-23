<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\user;
use App\score;
use App\practice;
use Auth;

class checkExerciseController extends Controller
{
  public function index(Request $request){
    if(Auth::user() == null){
      return redirect('login');
    }
      $std_id = $request->input('std_id');
      $Tmp_std_name = user::where('id',$std_id)->select('name')->get();
      $std_name = $Tmp_std_name[0]->name;
      //dd($std_id);
      $sub_id = $request->input('sub_id');
      $pract_id = $request->input('pract_id');
      $Tmp_pract_name = practice::where('pract_id',$pract_id)->select('pract_name')->get();
      $pract_name = $Tmp_pract_name[0]->pract_name;
      //dd($pract_name);
      $std_score = score::where('id',$std_id)->where('sub_id',$sub_id)
                          ->where('pract_id',$pract_id)->select('score')->get();

      $student_submitted = user::join('subjects','subjects.id' , '=', 'users.id')
                                  ->join('practices','practices.sub_id','=','subjects.sub_id')
                                  ->where('status','Student')->where('subjects.sub_id',$sub_id)
                                  ->where('practices.pract_id',$pract_id)
                                  ->select('users.student_id','users.id','users.name')->get();
      if($student_submitted == '[]')
          $student_submitted="";

      $student = score::where('sub_id',$sub_id)->where('pract_id',$pract_id)
                      ->join('users','users.id' , '=', 'scores.id')
                      ->select('users.id','users.student_id','users.name','scores.score')->get();
      $id_score = array();
      $cnt=0;
      if($student=='[]'){
        $student="";
      }else{
        foreach($student as $key => $val){
          $id_score[$cnt++] = $val->id;
        }
      }
      $cnt=0;
      $student_name=array();//is $student_submitted
      $student_id = array();//is $student_submitted
      if($student_submitted!=""){
        foreach($student_submitted as $key => $val){
          $tmp_std_id = $val->id;
          $file_name = $sub_id."_".$pract_id."_".$tmp_std_id.".txt";
          if(!in_array($tmp_std_id,$id_score)){
            if(file_exists($file_name)){
              $student_name[$tmp_std_id] = $val->name;
              $student_id[$tmp_std_id] = $val->student_id;
            }
          }
        }
      }

      if($std_score != '[]'){ //student ara checked have score -----------------------------
        //dd($std_score);
        $file_name = $sub_id."_".$pract_id."_".$std_id.".txt";
        $readfile = fopen($file_name,"r");
        $option = intval(fgets($readfile));//option
        $num_exer = intval(fgets($readfile));//num_exer
        $question = array();
        $answer = array();
        $score = array();
        $cnt=0;
        while(!feof($readfile)) {
          $question[$cnt]=fgets($readfile);
          $answer[$cnt]=fgets($readfile);
          $score[$cnt++]=intval(fgets($readfile));
        }
        fclose($readfile);
        return view('checkExercise')->with('answer',$answer)->with('question',$question)->with('std_name',$std_name)
                                    ->with('num_exer',$num_exer)->with('sub_id',$sub_id)->with('std_id',$std_id)
                                    ->with('pract_id',$pract_id)->with('pract_name',$pract_name)->with('score',$score)
                                    ->with('student_name',$student_name)->with('student',$student)->with('student_id',$student_id);

      }

      //not check_Exercise -------------------------------------------------

      $file_name = $sub_id."_".$pract_id."_".$std_id.".txt";
      $readfile = fopen($file_name,"r");
      $option = intval(fgets($readfile));//option
      $num_exer = intval(fgets($readfile));//num_exer
      $question = array();
      $answer = array();
      $cnt=0;
      while(!feof($readfile)) {
        $question[$cnt]=fgets($readfile);
        $answer[$cnt]=fgets($readfile);
        $cnt++;
      }
      fclose($readfile);
    //  dd($student_name,$student_id,$student_submitted);
      return view('checkExercise')->with('answer',$answer)->with('question',$question)->with('std_name',$std_name)
                                  ->with('num_exer',$num_exer)->with('sub_id',$sub_id)->with('std_id',$std_id)
                                  ->with('pract_id',$pract_id)->with('pract_name',$pract_name)
                                  ->with('student_name',$student_name)->with('student_id',$student_id)
                                  ->with('student',$student);
      //dd($question,$answer);
  }


  public function store(Request $request){
    if(Auth::user() == null){
      return redirect('login');
    }
      $num_exer = $request->input('num_exer');
      $pract_id = $request->input('pract_id');
      $sub_id = $request->input('sub_id');
      $pract_name = $request->input('pract_name');
      $std_id = $request->input('std_id');
      $Tmp_std_name = user::where('id',$std_id)->select('name')->get();
      $std_name = $Tmp_std_name[0]->name;
      $score = array();
      for($i=0;$i<$num_exer;$i++){
        $score[$i]= floatval($request->input('score_'.$i));
      }
      //dd(array_sum($score));
      $obj = new score();
      $obj->sub_id = $sub_id;
      $obj->pract_id = $pract_id;
      $obj->id = $std_id;
      $obj->score = array_sum($score);
      $obj->save();
      $student = score::where('sub_id',$sub_id)->where('pract_id',$pract_id)
                  ->join('users','users.id' , '=', 'scores.id')
                  ->select('users.id','users.student_id','users.name','scores.score')->get();
      if($student=='[]')
        $student="";
      $file_name = $sub_id."_".$pract_id."_".$std_id.".txt";
      $readfile = fopen($file_name,"r");
      $option = fgets($readfile);
      $num_exer = fgets($readfile);
      $question = array();
      $answer = array();
      $cnt=0;
      while(!feof($readfile)){
          $question[$cnt] = fgets($readfile);
          $answer[$cnt++] = fgets($readfile);
      }
      fclose($readfile);

      $myfile = fopen($file_name,"w");
      fwrite($myfile,$option);
      fwrite($myfile,$num_exer);
      for($i=0;$i<$num_exer;$i++){
        fwrite($myfile,$question[$i]);
        fwrite($myfile,$answer[$i]);
        fwrite($myfile,$score[$i]."\n");
      }
      fclose($myfile);
      $student_submitted = user::join('subjects','subjects.id' , '=', 'users.id')
                                  ->join('practices','practices.sub_id','=','subjects.sub_id')
                                  ->where('status','Student')->where('subjects.sub_id',$sub_id)
                                  ->where('practices.pract_id',$pract_id)
                                  ->select('users.id','users.student_id','users.name')->get();
      if($student_submitted == '[]')
          $student_submitted="";
      $id_score = array();
      $cnt=0;
      if($student=='[]'){
        $student="";
      }else{
        foreach($student as $key => $val){
          $id_score[$cnt++] = $val->id;
        }
      }
      $student_id = array();//is $student_submitted
      $student_name=array();
      foreach($student_submitted as $key => $val){
        $tmp_std_id = $val->id;
        $file_name = $sub_id."_".$pract_id."_".$tmp_std_id.".txt";
        if(!in_array($tmp_std_id,$id_score)){
          if(file_exists($file_name)){
            $student_name[$tmp_std_id] = $val->name;
            $student_id[$tmp_std_id] = $val->student_id;
          }
        }
      }
      return view('checkExercise')->with('answer',$answer)->with('question',$question)->with('std_name',$std_name)
                                  ->with('num_exer',$num_exer)->with('sub_id',$sub_id)->with('std_id',$std_id)
                                  ->with('pract_id',$pract_id)->with('pract_name',$pract_name)->with('score',$score)
                                  ->with('student_name',$student_name)->with('student',$student)
                                  ->with('student_id',$student_id);

      //dd($score,$std_id,$std_name);
  }

}

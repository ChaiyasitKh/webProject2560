<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\score;
use App\user;
use App\practice;
use App\subject;
use Auth;

class practiceController extends Controller
{
    //
    public function index(Request $request){
       if(Auth::user() == null){
         return redirect('login');
       }
        $sub_id = $request->input('sub_id');
        $pract_id = $request->input('pract_id');
        $ch_due_date = $request->input('ch_due_date');

        if($ch_due_date !=null){//due date have change
          $due_date = $request->input('due_date');
          $hr = $request->input('hr');
          $min = $request->input('min');
          $split = explode("/",$due_date);
          $date = $split[2]."-".$split[0]."-".$split[1]." ".$hr.":".$min.":00";
          $Fdate = date_create_from_format('Y-m-d H:i:s', $date);
          //Update due date
          practice::where('pract_id',$pract_id)
                    ->where('sub_id',$sub_id)
                    ->update(['send_late' => $Fdate]);
        }
        $Tmp_pract = practice::where('pract_id',$pract_id)
                          ->where('sub_id',$sub_id)
                          ->select('pract_name','send_late')->get();
        $pract_name = $Tmp_pract[0]->pract_name;
        $due_date = $Tmp_pract[0]->send_late;
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

        $check_file = $sub_id."_".$pract_id.".txt";
        if(!file_exists($check_file)){// have no file---------------------------------------------------------
           return view('practice')->with('pract_name',$pract_name)->with('check_file','0')
                                  ->with('student',$student)->with('sub_id',$sub_id)
                                  ->with('pract_id',$pract_id)->with('due_date',$due_date);
        }
        // read file
        $file_name = $sub_id."_".$pract_id.".txt";
        $readfile = fopen($file_name, "r") or die("Unable to open file!");
        $option = intval(fgets($readfile));//option
        $num_exer = intval(fgets($readfile));//num_exer
        // echo($option);
        // dd($num_exer);
        if($option==0){//subjective
          $question = array();
          $cnt=0;
          while(!feof($readfile)) {
            $question[$cnt]=fgets($readfile);
            $cnt++;
          }
          fclose($readfile);
          $student_submitted = user::join('subjects','subjects.id' , '=', 'users.id')
                                      ->join('practices','practices.sub_id','=','subjects.sub_id')
                                      ->where('status','Student')->where('subjects.sub_id',$sub_id)
                                      ->where('practices.pract_id',$pract_id)
                                      ->select('users.id','users.student_id','users.name')->get();
          if($student_submitted == '[]')
              $student_submitted="";

          $student_id = array();//is $student_submitted
          $student_name=array();//is $student_submitted
          if($student_submitted!=""){
            foreach($student_submitted as $key => $val){
              $std_id = $val->id;
              $file_name = $sub_id."_".$pract_id."_".$std_id.".txt";
              if(!in_array($std_id,$id_score)){
                if(file_exists($file_name)){
                  $student_id[$std_id] = $val->student_id;
                  $student_name[$std_id] = $val->name;
                }
              }
            }
         }
          //dd($student_id);
          //dd($student_name);
          return view('practice')->with('pract_name',$pract_name)->with('check_file','1')//check_file=1 -> have file
                                ->with('student',$student)->with('sub_id',$sub_id)->with('student_id',$student_id)
                                ->with('pract_id',$pract_id)->with('option',$option)
                                ->with('num_exer',$num_exer)->with('due_date',$due_date)
                                ->with('question',$question)->with('student_name',$student_name);
        }
        //multiple
        $tmp_allData = array();
        $cnt=0;
        while(!feof($readfile)) {
          $tmp_allData[$cnt]=fgets($readfile);
          $cnt++;
        }
        $question = array();
        $choice = array();
        $answer = array();
        $cnt=0;
        //dd($tmp_allData);
        for($i=0;$i<$num_exer;$i++){//save file to 3 array
          $question[$i] = $tmp_allData[$cnt];
          $cnt++;
          for($j=1;$j<=4;$j++){
            $choice[$i."_".$j] = $tmp_allData[$cnt];
            $cnt++;
          }
          $answer[$i]=$tmp_allData[$cnt];
          $cnt++;
        }
      //  dd($pract_name);
        fclose($readfile);
        return view('practice')->with('pract_name',$pract_name)->with('check_file','1')//check_file=1 -> have file
                              ->with('student',$student)->with('sub_id',$sub_id)
                              ->with('pract_id',$pract_id)->with('option',$option)
                              ->with('num_exer',$num_exer)->with('due_date',$due_date)
                              ->with('question',$question)->with('choice',$choice)->with('answer',$answer);

      //  return view('practice')->with('check_file','1')->with('student',$student)->with('sub_id',$sub_id);
    }

    public function store(Request $request){
      if(Auth::user() == null){
        return redirect('login');
      }

      $option = $request->input('option');
      $num_exer = $request->input('num_exer');
      $sub_id = $request->input('sub_id');
      $pract_id = $request->input('pract_id');
      $pract_name = $request->input('pract_name');
      $due_dateTmp = practice::where('pract_id',$pract_id)
                        ->where('sub_id',$sub_id)
                        ->select('send_late')->get();
      $due_date = $due_dateTmp[0]->send_late;
    //  echo $pract_name;
      $student = score::where('sub_id',$sub_id)->where('pract_id',$pract_id)
                  ->join('users','users.id' , '=', 'scores.id')
                  ->select('users.name','scores.score')->get();

        if($request->input('1')!=null){
          $option = $request->input('option');
          $num_exer = $request->input('num_exer');
          $sub_id = $request->input('sub_id');
          $pract_id = $request->input('pract_id');
          if($option==0){ //subjective
            $question = array();
            $cnt=0;
            for($i=1;$i<=$num_exer;$i++){
              $question[$i-1] = $request->input($i);
            }
            $file_name = $sub_id."_".$pract_id.".txt";
            $myfile = fopen($file_name, "w") or die("Unable to open file!");
            fwrite($myfile, $option."\n"); //choice or subjective
            fwrite($myfile, $num_exer."\n"); //number of exercise
            foreach ($question as $value) {
              //echo $value." ";
              $txt = $value."\n";
              fwrite($myfile, $txt);
            }
            fclose($myfile);
            return view('practice')->with('pract_name',$pract_name)->with('check_file','1')//check_file=1 -> have file
                                  ->with('student',$student)->with('sub_id',$sub_id)
                                  ->with('pract_id',$pract_id)->with('option',$option)
                                  ->with('num_exer',$num_exer)->with('due_date',$due_date)
                                  ->with('question',$question);

          }else{ //multiple choice
            $question_for_write = array();
            $cnt=0;

            for($i=1;$i<=$num_exer;$i++){
              //question
              $question_for_write[$cnt] = $request->input($i);
              $cnt++;
              //choice
              for($j=1;$j<=4;$j++){
                $question_for_write[$cnt] = $request->input($i."_".$j);
                $cnt++;
              }
              //answer
              $question_for_write[$cnt] = $request->input("ans".$i);
              $cnt++;
            }
            $file_name = $sub_id."_".$pract_id.".txt";
            $myfile = fopen($file_name, "w") or die("Unable to open file!");
            fwrite($myfile, $option."\n"); //choice or subjective
            fwrite($myfile, $num_exer."\n"); //number of exercise
            foreach ($question_for_write as $value) {
              //echo $value." ";
              $txt = $value."\n";
              fwrite($myfile, $txt);
            }
            $readfile = fopen($file_name, "r") or die("Unable to open file!");
            fgets($readfile);//option
            fgets($readfile);//num_exer
            $tmp_allData = array();
            $cnt=0;
            while(!feof($readfile)) {
              $tmp_allData[$cnt]=fgets($readfile);
              $cnt++;
            }
            $question = array();
            $choice = array();
            $answer = array();
            $cnt=0;
            //dd($tmp_allData);
            for($i=0;$i<$num_exer;$i++){//save file to 3 array
              $question[$i] = $tmp_allData[$cnt];
              $cnt++;
              for($j=1;$j<=4;$j++){
                $choice[$i."_".$j] = $tmp_allData[$cnt];
                $cnt++;
              }
              $answer[$i]=$tmp_allData[$cnt];
              $cnt++;
            }
          //  dd($pract_name);
            fclose($myfile);
            fclose($readfile);
            return view('practice')->with('pract_name',$pract_name)->with('check_file','1')//check_file=1 -> have file
                                  ->with('student',$student)->with('sub_id',$sub_id)
                                  ->with('pract_id',$pract_id)->with('option',$option)
                                  ->with('num_exer',$num_exer)->with('due_date',$due_date)
                                  ->with('question',$question)->with('choice',$choice)->with('answer',$answer);
          }//endif multiple choice

        }//endif check exercise



        // echo $option."<br>";
        // dd($num_exer,$sub_id,$pract_id);
        //dd($sub_id,$pract_id,$pract_name);
        return view('practice')->with('pract_name',$pract_name)->with('check_file','0')
                              ->with('student',$student)->with('sub_id',$sub_id)
                              ->with('pract_id',$pract_id)->with('option',$option)
                              ->with('num_exer',$num_exer)->with('due_date',$due_date);

    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\score;
use App\practice;
use Auth;

class studentPracticeController extends Controller
{
    public function index(Request $request){
      if(Auth::user() == null){
        return redirect('login');
      }
      $sub_id = $request->input('sub_id');
      $pract_id = $request->input('pract_id');
      $Tmp_pract_name = practice::where('pract_id',$pract_id)
                        ->where('sub_id',$sub_id)
                        ->select('send_late','pract_name')->get();
      $pract_name = $Tmp_pract_name[0]->pract_name;
      $due_date = $Tmp_pract_name[0]->send_late;
      $user_id = Auth::user()->id;
      $score = score::where('sub_id',$sub_id)->where('pract_id',$pract_id)->where('id',$user_id)
                                            ->select('score')->get();
      //echo $sub_id." ".$pract_id.' '.$user_id;

      if($score=='[]'){//check null score
        //dd("null");
        $score="";
      }
      //dd($score);
      $check_file = $sub_id."_".$pract_id."_".$user_id.".txt";
      if(file_exists($check_file)){ //check practice done---------------------------------------------------------------
          $read_question_file = fopen($sub_id."_".$pract_id.".txt","r") or die("File not found!!");
          $option = intval(fgets($read_question_file));//option
          $num_exer = intval(fgets($read_question_file));//num_exer
          $readfile = fopen($check_file,"r") or die("File not found!!");
          if($option == 1){//multiple choice
            $ch = array();
            $cnt=0;
            while(!feof($readfile)){
              $ch[$cnt]=fgets($readfile);
              $cnt++;
            }
            $tmp_allData = array();
            $cnt=0;
            while(!feof($read_question_file)) {
              $tmp_allData[$cnt]=fgets($read_question_file);
              $cnt++;
            }
            $question = array();
            $choice = array();
            $answer = array();
            $cnt=0;
            //dd($tmp_allData);
            for($i=0;$i<$num_exer;$i++){//get file to 3 array
              $question[$i] = $tmp_allData[$cnt];
              $cnt++;
              for($j=1;$j<=4;$j++){
                $choice[$i."_".$j] = $tmp_allData[$cnt];
                $cnt++;
              }
              $answer[$i]=$tmp_allData[$cnt];
              $cnt++;
            }
            fclose($readfile);
            fclose($read_question_file);
            return view('studentPractice')->with('pract_name',$pract_name)->with('ch',$ch)//ch => choice selected by student
                                  ->with('sub_id',$sub_id)->with('score',$score)
                                  ->with('pract_id',$pract_id)->with('option',$option)
                                  ->with('num_exer',$num_exer)->with('due_date',$due_date)
                                  ->with('question',$question)->with('choice',$choice);
          }//endif multiple choice
          //subjective-----------------
          $option = intval(fgets($readfile));//option
          $num_exer = intval(fgets($readfile));//num_exer
          $question = array();
          $answer = array();
          $cnt=0;
          while(!feof($readfile)){
            $question[$cnt]=fgets($readfile);
            $answer[$cnt]=fgets($readfile);
            $cnt++;
          }
          //dd($question,$answer);
          fclose($readfile);
          fclose($read_question_file);
        return view('studentPractice')->with('pract_name',$pract_name)
                              ->with('sub_id',$sub_id)->with('score',$score)
                              ->with('pract_id',$pract_id)->with('option',$option)
                              ->with('num_exer',$num_exer)->with('due_date',$due_date)
                              ->with('question',$question)->with('answer',$answer);
      }

      //readfile_Not have practice done----------------------------------------------------------------------------------
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

        //dd($question);
        fclose($readfile);
        return view('studentPractice')->with('pract_name',$pract_name)
                                      ->with('sub_id',$sub_id)->with('question',$question)
                                      ->with('pract_id',$pract_id)->with('option',$option)
                                      ->with('num_exer',$num_exer)->with('due_date',$due_date);
      }
      //multiple choice
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
      fclose($readfile);
      return view('studentPractice')->with('pract_name',$pract_name)->with('choice',$choice)
                                    ->with('sub_id',$sub_id)->with('question',$question)
                                    ->with('pract_id',$pract_id)->with('option',$option)
                                    ->with('num_exer',$num_exer)->with('due_date',$due_date);
      //dd($question,$choice,$answer);

    }

    public function store(Request $request){
      if(Auth::user() == null){
        return redirect('login');
      }
      $sub_id = $request->input('sub_id');
      $pract_id = $request->input('pract_id');
      $pract_name = $request->input('pract_name');
      $option = $request->input('option');
      $num_exer = $request->input('num_exer');
      $user_id = Auth::user()->id;
      $tmp_dueDate = practice::where('sub_id',$sub_id)->where('pract_id',$pract_id)->get();
      $due_date = $tmp_dueDate[0]->send_late;

      if($option==0){//subjective------------------------------------
        $question = array();
        $answer = array();
        for($i=1;$i<=$num_exer;$i++){
          $question[($i-1)]=$request->input('q'.$i);
          $answer[($i-1)]=$request->input('ans'.$i);
        }

        $file_name = $sub_id."_".$pract_id."_".$user_id.".txt";
        $myfile = fopen($file_name, "w") or die("Unable to open file!");
        fwrite($myfile, $option."\n"); //choice or subjective
        fwrite($myfile, $num_exer."\n"); //number of exercise
        $cnt=0;
        foreach ($question as $value) {
          //echo $value." ";
          $txt = $value."\n";
          fwrite($myfile, $txt);
          $txt = $answer[$cnt]."\n";
          fwrite($myfile, $txt);
          $cnt++;
        }
        fclose($myfile);

        return view('studentPractice')->with('pract_name',$pract_name)
                              ->with('sub_id',$sub_id)
                              ->with('pract_id',$pract_id)->with('option',$option)
                              ->with('num_exer',$num_exer)->with('due_date',$due_date)
                              ->with('question',$question)->with('answer',$answer);
      }
      //multiple choice--------------------------------

      $file_name = $sub_id."_".$pract_id."_".$user_id.".txt";
      $myfile = fopen($file_name, "w") or die("Unable to open file!");
      $ch = array();
      for($i=0;$i<$num_exer;$i++){
          $str= "c".$i;
          $ch[$i] = $request->input($str);
          fwrite($myfile,$ch[$i]."\n");
      }
      
      fclose($myfile);
      //check answer
      $file_name = $sub_id."_".$pract_id.".txt";
      $readfile = fopen($file_name,"r") or die("File not found!!");
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
      for($i=0;$i<$num_exer;$i++){//get file to 3 array
        $question[$i] = $tmp_allData[$cnt];
        $cnt++;
        for($j=1;$j<=4;$j++){
          $choice[$i."_".$j] = $tmp_allData[$cnt];
          $cnt++;
        }
        $answer[$i]=$tmp_allData[$cnt];
        $cnt++;
      }
      $scr = 0;//score
      for($i=0;$i<$num_exer;$i++){
        if(intval($ch[$i]) == intval($answer[$i])){
          $scr++;
        }
      }

      //save score to data_base

      $obj = new score();
      $obj->sub_id = $sub_id;
      $obj->pract_id = $pract_id;
      $obj->id = $user_id;
      $obj->score = $scr;
      $obj->save();
      //dd($ch,$answer);
//dd($sub_id,$pract_id,$user_id);
      fclose($readfile);
      $score = score::where('sub_id',$sub_id)->where('pract_id',$pract_id)->where('id',$user_id)
                                            ->select('score')->get();
      //dd($score[0]->score);
      return view('studentPractice')->with('pract_name',$pract_name)->with('ch',$ch)//ch => choice selected by student
                            ->with('sub_id',$sub_id)->with('score',$score)
                            ->with('pract_id',$pract_id)->with('option',$option)
                            ->with('num_exer',$num_exer)->with('due_date',$due_date)
                            ->with('question',$question)->with('choice',$choice);

    }
}

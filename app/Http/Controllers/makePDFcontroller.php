<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\subject;
use App\practice;
use App\score;
use PDF;

class makePDFcontroller extends Controller
{
  public function store(Request $request){
      $sub_id = $request->input('sub_id');
      $pract_id = $request->input('pract_id');
      $tmp_subname = subject::where('sub_id',$sub_id)->select('sub_name')->get();
      $sub_name = $tmp_subname[0]->sub_name;
      $tmp_practName = practice::where('pract_id',$pract_id)->select('pract_name')->get();
      $pract_name = $tmp_practName[0]->pract_name;
      $std_score = score::where('sub_id',$sub_id)->where('pract_id',$pract_id)
                ->join('users','users.id' , '=', 'scores.id')
                ->select('users.id','users.student_id','users.name','scores.score')->get();

      //https://www.youtube.com/watch?v=C4E9SNJiSuM
      //https://github.com/barryvdh/laravel-dompdf
      $pdf = PDF::loadView('makePDF',['std_score'=>$std_score,'sub_name'=>$sub_name,'pract_name'=>$pract_name]);
      $pdfName = $sub_name."_".$pract_name.".pdf";
      return $pdf->download($pdfName);
  }

}

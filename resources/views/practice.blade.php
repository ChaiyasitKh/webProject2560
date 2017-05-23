@extends('layouts.app')
@section('head')
<style>
/*https://stackoverflow.com/questions/12978254/twitter-bootstrap-datepicker-within-modal-window*/
.datepicker{
  z-index:1151 !important;
}
</style>
@endsection
@section('content')

<div class="container">
  <form class="form-horizontal" role="form" method="get" action="subject">
      {{ csrf_field() }}
  <div class="row">
      <div class="col-md-8 col-md-offset-2">
          <div class="panel panel-default">
              <div class="panel-heading">Practice name : {{$pract_name." | Due date : ".$due_date}}</div>
              <input type="hidden" name="pract_name" value="{{$pract_name}}">
              <div class="panel-body">
                <form class="form-horizontal" role="form">
                    {{ csrf_field() }}
                    <div class="form-group">
                      @if(isset($student_name)&&$student_name != "")
                        <div class="col-md-3">
                          <input type="hidden" name="sub_id" value="{{$sub_id}}">
                          <button type="submit" class="btn btn-danger">Back to subject</button>
                        </div>
                        <div class="col-md-3">
                          <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#Students">Students score</button>
                        </div>
                        <div class="col-md-3">
                          <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#Student_submitted">Student submitted</button>
                        </div>
                        <div class="col-md-3">
                          <input type="hidden" name="sub_id" value="{{$sub_id}}">
                          <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#changeDuedate">Change Due date</button>
                        </div>
                      @else
                        <div class="col-md-3"></div>
                        <div class="col-md-3">
                          <input type="hidden" name="sub_id" value="{{$sub_id}}">
                          <button type="submit" class="btn btn-danger">Back to subject</button>
                        </div>
                        <div class="col-md-3">
                          <input type="hidden" name="sub_id" value="{{$sub_id}}">
                          <button type="button" class="btn btn-primary" class="btn btn-primary" data-toggle="modal" data-target="#changeDuedate">Change Due date</button>
                        </div>
                      @endif
                    </div>
                </form>
              </div>
          </div>
      </div>
  </div>
</form>
  @if($check_file == '0' && !isset($option))<!-- not have file -->
  <div class="row">
      <div class="col-md-8 col-md-offset-2">
          <div class="panel panel-default">
              <div class="panel-heading">Create Exercise</div>
              <div class="panel-body">
                <form class="form-horizontal" role="form" method="post" action="practice">
                    {{ csrf_field() }}

                    <div class="form-group">
                        <label  class="col-md-4 control-label">Number of exercise!!</label>
                        <div class="col-md-6">
                          <input type="number" class="form-control" min="1" name="num_exer" value="" placeholder="Please enter number" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-3"></div>
                        <div class="col-md-3">
                          <button type="submit" class="btn btn-primary" id="multiple">Multiple choice</button>
                        </div>
                        <div class="col-md-3">
                          <button type="submit" class="btn btn-primary" id="subjective">Subjective</button>
                        </div>
                        <input type="hidden" id="option" name="option" value="">
                        <input type="hidden" name="sub_id" value="{{$sub_id}}">
                        <input type="hidden" name="pract_id" value="{{$pract_id}}">
                        <input type="hidden" name="pract_name" value="{{$pract_name}}">
                    </div>
                </form>
              </div>
          </div>
      </div>
  </div>
  @endif <!-- check_file -->
  @if($check_file == '1')<!-- have file -->
    @if($option == '1') <!-- multiple choice -->
    <form class="form-horizontal" role="form" method="get" action="practice">
    @for($i=0;$i<$num_exer;$i++)
    <div class="row">
      <div class="col-md-8 col-md-offset-2">
          <div class="panel panel-default">
              <div class="panel-heading">Number : {{($i+1)}}</div>
              <div class="panel-body">
                <div class="form-group">
                    <div class="col-md-1"></div>
                    <div class="col-md-10">
                      <textarea class="form-control" rows="3" id="comment" readonly>{{$question[$i]}}</textarea>
                      <!-- <input id="pracID" type="text" class="form-control" placeholder="Please enter choice data" name="{{$i}}" value="" required> -->
                    </div>
                </div>
                  {{ csrf_field() }}
                @for($j=1;$j<=4;$j++)
                  <div class="form-group">
                      <label  class="col-md-4 control-label">Choice : {{$j}}</label>
                      <div class="col-md-6">
                        <input id="pracID" type="text" class="form-control"  name="{{$i.'_'.$j}}" value="{{$choice[$i.'_'.$j]}}" readonly>
                      </div>
                  </div>
                @endfor
                <div class="form-group">
                    <label  class="col-md-4 control-label">Answer choice : </label>
                    <div class="col-md-6">
                      <input id="pracID" type="text" class="form-control" name="{{'ans'.$i}}" value="{{$answer[$i]}}" readonly>
                      <input type="hidden" name="sub_id" value="{{$sub_id}}">
                      <input type="hidden" name="pract_id" value="{{$pract_id}}">
                      <input type="hidden" name="pract_name" value="{{$pract_name}}">
                    </div>
                </div>
              </div>
          </div>
      </div>
    </div><!-- end row -->
    @endfor
    </form>
    @else <!-- subjective -->
    <form class="form-horizontal" role="form" method="get" action="practice">
    @for($i=0;$i<$num_exer;$i++)
    <div class="row">
      <div class="col-md-8 col-md-offset-2">
          <div class="panel panel-default">
              <div class="panel-heading">Number : {{($i+1)}}</div>
              <div class="panel-body">
                <div class="form-group">
                    <div class="col-md-1"></div>
                    <div class="col-md-10">
                      <textarea class="form-control" rows="3" id="comment" readonly>{{$question[$i]}}</textarea>
                    </div>
                </div>
                  {{ csrf_field() }}
                <div class="form-group">
                    <div class="col-md-6">
                      <input type="hidden" name="sub_id" value="{{$sub_id}}">
                      <input type="hidden" name="pract_id" value="{{$pract_id}}">
                      <input type="hidden" name="pract_name" value="{{$pract_name}}">
                    </div>
                </div>
              </div>
          </div>
      </div>
    </div><!-- end row -->
    @endfor
    </form>
    @endif <!-- multiple choice & subjective -->
  @endif <!-- check_have_file -->

  @if(isset($option) && $check_file == '0')
    @if($option == '1') <!-- multiple choice -->
      <form class="form-horizontal" role="form" method="POST" action="practice">
      @for($i=1;$i<=$num_exer;$i++)
      <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Number : {{$i}}</div>
                <div class="panel-body">
                  <div class="form-group">
                      <div class="col-md-1"></div>
                      <div class="col-md-10">
                        <textarea class="form-control" rows="3" id="comment" name="{{$i}}" value="" placeholder="Please enter question data" required></textarea>
                        <!-- <input id="pracID" type="text" class="form-control" placeholder="Please enter choice data" name="{{$i}}" value="" required> -->
                      </div>
                  </div>
                    {{ csrf_field() }}
                  @for($j=1;$j<=4;$j++)
                    <div class="form-group">
                        <label  class="col-md-4 control-label">Choice : {{$j}}</label>
                        <div class="col-md-6">
                          <input id="pracID" type="text" class="form-control" placeholder="Please enter choice data" name="{{$i.'_'.$j}}" value="" required>
                        </div>
                    </div>
                  @endfor
                  <div class="form-group">
                      <label  class="col-md-4 control-label">Answer choice : </label>
                      <div class="col-md-6">
                        <input id="pracID" type="number" min="1" max="4" class="form-control" placeholder="Please enter answer choice" name="{{'ans'.$i}}" value="" required>
                      </div>
                  </div>
                </div>
            </div>
        </div>
      </div><!-- end row -->
      @endfor
      <div class="form-group">
          <div class="col-md-9"></div>
          <div class="col-md-3">
            <input type="hidden" name="sub_id" value="{{$sub_id}}">
            <input type="hidden" name="pract_id" value="{{$pract_id}}">
            <input type="hidden" name="option" value="{{$option}}">
            <input type="hidden" name="pract_name" value="{{$pract_name}}">
            <input type="hidden" name="num_exer" value="{{$num_exer}}">
            <button type="button" class="btn btn-primary" id="submit" data-toggle="modal" data-target="#confirm">Submit</button>
          </div>
      </div>
      <!-- Modal submit confirm-->
        <div class="modal fade" id="confirm" role="dialog">
          <div class="modal-dialog modal-sm">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Confirm</h4>
              </div>
              <div class="modal-body">
                <p>หากกด "Submit" คุณจะไม่สามารถแก้ไขเอกสารได้อีก</p>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Submit</button>
              </div>
            </div>
          </div>
        </div>
      <!-- end modal donfirm -->
      </form>
    @else <!-- option != 1 (subjective) -->
    <form class="form-horizontal" role="form" method="POST" action="practice">
      {{ csrf_field() }}
    @for($i=1;$i<=$num_exer;$i++)
    <div class="row">
      <div class="col-md-8 col-md-offset-2">
          <div class="panel panel-default">
              <div class="panel-heading">Number : {{$i}}</div>
              <div class="panel-body">
                <div class="form-group">
                    <div class="col-md-1"></div>
                    <div class="col-md-10">
                      <textarea class="form-control" rows="3" id="comment" name="{{$i}}" value="" placeholder="Please enter question data" required></textarea>
                      <!-- <input id="pracID" type="text" class="form-control" placeholder="Please enter choice data" name="{{$i}}" value="" required> -->
                    </div>
                </div>
              </div> <!-- panel body -->
          </div>
      </div>
    </div><!-- end row -->
    @endfor
    <div class="form-group">
        <div class="col-md-9"></div>
        <div class="col-md-3">
          <input type="hidden" name="sub_id" value="{{$sub_id}}">
          <input type="hidden" name="pract_id" value="{{$pract_id}}">
          <input type="hidden" name="option" value="{{$option}}">
          <input type="hidden" name="pract_name" value="{{$pract_name}}">
          <input type="hidden" name="num_exer" value="{{$num_exer}}">
          <button type="button" class="btn btn-primary" id="submit" data-toggle="modal" data-target="#confirm">Submit</button>
        </div>
    </div>
    <!-- Modal submit confirm-->
      <div class="modal fade" id="confirm" role="dialog">
        <div class="modal-dialog modal-sm">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Confirm</h4>
            </div>
            <div class="modal-body">
              <p>หากกด "Submit" คุณจะไม่สามารถแก้ไขเอกสารได้อีก</p>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Submit</button>
            </div>
          </div>
        </div>
      </div>
    <!-- end modal donfirm -->
    </form>
    @endif <!-- option -->
  @endif <!-- isset(option) -->
</div> <!-- end container -->

<!-- Modal student score -->
<form class="form-horizontal" role="form" method="post" action="makePDF">{{ csrf_field() }}
<div class="modal fade" id="Students" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Student score</h4>

      </div>
        <div class="modal-body">
            <div class="row">
              @if(!isset($student)||$student=="")
                <label>&nbsp;&nbsp;&nbsp;&nbsp;ยังไม่มีคนส่งงาน หรือ ยังไม่ได้ตรวจงาน</label>
              @else
              <table class="table">
                <thead>
                  <tr>
                    <th>Student ID</th>
                    <th>Student name</th>
                    <th>Student score</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($student as $key => $val)
                    <tr>
                      <td>{{$val->student_id}}</td>
                      <td>{{$val->name}}</td>
                      <td>{{$val->score}}</td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
              @endif
            </div>
        </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        @if(isset($student)&&$student!=""&&$student!="[]")
          <button type="submit" class="btn btn-primary">Download Score</button>
          <input type="hidden" name="sub_id" value="{{$sub_id}}">
          <input type="hidden" name="pract_id" value="{{$pract_id}}">
        @endif
      </div>
    </div>
  </div>
</div> <!--end modal student-->
</form>
<!-- Modal student_submitted-->
<form class="form-horizontal" role="form" method="get" action="checkExercise">{{ csrf_field() }}
<div class="modal fade" id="Student_submitted" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Student submitted</h4>
      </div>
        <div class="modal-body">
            <div class="row">
              @if(!isset($student_name)||$student_name=="")
                <label>ยังไม่มีคนส่งงาน</label>
              @else
              <table class="table">
                <thead>
                  <tr>
                    <th>Student ID</th>
                    <th>Student name</th>
                    <th>Check</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($student_name as $key => $val)
                    <tr>
                      <td>{{$student_id[$key]}}</td>
                      <td>{{$val}}</td>
                      <td><button type="submit" class="btn btn-primary" name="std_id" value="{{$key}}" id="check">Check</button>
                      </td>
                    </tr>
                  @endforeach
                  @if(!isset($student)||$student=="")
                  @else
                   @foreach($student as $key => $val)
                    <tr>
                      <td>{{$val->student_id}}</td>
                      <td>{{$val->name}}</td>
                      <td><button type="submit" class="btn btn-danger" name="std_id" value="{{$val->id}}" id="check">Checked</button>
                      </td>
                    </tr>
                   @endforeach
                  @endif
                </tbody>
              </table>
              @endif
              <input type="hidden" name="sub_id" value="{{$sub_id}}">
              <input type="hidden" name="pract_id" value="{{$pract_id}}">
            </div>
        </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
</form>
<!-- Modal chang due date-->
<form class="form-horizontal" role="form" method="get" action="practice">{{csrf_field()}}
<div class="modal fade" id="changeDuedate" role="dialog">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Change due date</h4>
      </div>
      <div class="modal-body">
        <div class="form-group">
            <label  class="col-md-4 control-label">Due date</label>
            <div class="col-md-6">
              <input class="datepicker" type="text" name="due_date" value="" placeholder="Please enter due date" required>
            </div>
          </div>
          <div class="form-group">
            <label  class="col-md-4 control-label"></label>
            <div class='col-md-6'>
              <label  class="control-label">hr: </label>
              <!-- https://stackoverflow.com/questions/12149164/how-to-achieve-a-mini-select-style-using-bootstrap-or-straight-css -->
              <select class="btn btn-mini btn-default" name="hr" required>
                @for($i=0;$i<24;$i++)
                  @if($i<= 9)
                  <option value="{{'0'.$i}}">{{'0'.$i}}</option>
                  @else
                  <option value="{{$i}}">{{$i}}</option>
                  @endif
                @endfor
              </select>
              <label  class="control-label">min: </label>
              <select class="btn btn-mini btn-default" name="min" required>
                @for($i=0;$i<60;$i++)
                  @if($i<= 9)
                  <option value="{{'0'.$i}}">{{'0'.$i}}</option>
                  @else
                  <option value="{{$i}}">{{$i}}</option>
                  @endif
                @endfor
              </select>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <input type="hidden" name="sub_id" value="{{$sub_id}}">
        <input type="hidden" name="pract_id" value="{{$pract_id}}">
        <input type="hidden" name="ch_due_date" value="true">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Submit</button>
      </div>
    </div>
  </div>
</div> <!--end modal-->
</form>

<script>
$(document).ready(function(){
    $("#multiple").click(function(){
        $('#option').val('1');
    });
    $("#subjective").click(function(){
        $('#option').val('0');
    });
    // $("#check").click(function(){
    //   $('<input/>').attr({ type: 'text', id: 'test', name: 'test'}).appendTo('body');
    // });
    $(function(){
      $(".datepicker").datepicker();
    });
});
</script>
@endsection

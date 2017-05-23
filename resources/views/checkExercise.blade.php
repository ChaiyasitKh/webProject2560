@extends('layouts.app')

@section('content')
<div class="container">
  <form class="form-horizontal" role="form" method="get" action="practice">
      {{ csrf_field() }}
  <div class="row">
      <div class="col-md-8 col-md-offset-2">
          <div class="panel panel-default">
              <div class="panel-heading">Practice name : {{$pract_name."_".$std_name}}</div>
              <input type="hidden" name="pract_name" value="{{$pract_name}}">
              <div class="panel-body">
                <form class="form-horizontal" role="form">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <div class="col-md-1"></div>
                        <div class="col-md-3">
                          <input type="hidden" name="sub_id" value="{{$sub_id}}">
                          <input type="hidden" name="pract_id" value="{{$pract_id}}">
                          <button type="submit" class="btn btn-success">Back to practice</button>
                        </div>
                        <div class="col-md-3">
                          <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#Students">Students score</button>
                        </div>
                        <div class="col-md-3">
                          <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#Student_submitted">Student submitted</button>
                        </div>
                    </div>
                </form>
              </div>
          </div>
      </div>
  </div>
</form>
@if(!isset($score))
<form class="form-horizontal" role="form" method="post" action="checkExercise">
@for($i=0;$i<$num_exer;$i++)
<div class="row">
  <div class="col-md-8 col-md-offset-2">
      <div class="panel panel-default">
          <div class="panel-heading">Number : {{($i+1)}}</div>
          <div class="panel-body">
            <div class="form-group">
                <div class="col-md-1">Question</div>
                <div class="col-md-10">
                  <textarea class="form-control" rows="3" id="comment" readonly>{{$question[$i]}}</textarea>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-1">Answer</div>
                <div class="col-md-10">
                  <textarea class="form-control" rows="3" id="comment" readonly>{{$answer[$i]}}</textarea>
                </div>
            </div>
            <div class="form-group">
                <div class='col-md-1'><h4>Score</h4></div>
                <div class="col-md-4">
                  <input type="number"  step="0.01" class="form-control" name="{{'score_'.$i}}" placeholder="Please enter score"required>
                </div>
            </div>
              {{ csrf_field() }}
          </div>
      </div>
  </div>
</div><!-- end row -->
@endfor
<div class="form-group">
    <div class='col-md-9'></div>
    <div class="col-md-3">
      <button type="button" class="btn btn-primary" id="submit" data-toggle="modal" data-target="#confirm">Submit</button>
      <input type="hidden" name="std_id" value="{{$std_id}}">
      <input type="hidden" name="sub_id" value="{{$sub_id}}">
      <input type="hidden" name="pract_id" value="{{$pract_id}}">
      <input type="hidden" name="pract_name" value="{{$pract_name}}">
      <input type="hidden" name="num_exer" value="{{$num_exer}}">
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
</form> <!-- end post method -->
@else <!-- have score -->
<form class="form-horizontal" role="form">
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
                <div class="col-md-2"></div>
            </div>
            <div class="form-group">
                <div class="col-md-1"></div>
                <div class="col-md-10">
                  <textarea class="form-control" rows="3" id="comment" readonly>{{$answer[$i]}}</textarea>
                </div>
            </div>
            <div class="form-group">
                <div class='col-md-1'><h4>Score</h4></div>
                <div class="col-md-4">
                  <input type="number" class="form-control" value="{{$score[$i]}}" readonly>
                </div>
            </div>
          </div>
      </div>
  </div>
</div><!-- end row -->
@endfor
</form>
@endif <!--end have score -->
<!-- Modal student_submitted-->
<form class="form-horizontal" role="form" method="get" action="checkExercise">
<div class="modal fade" id="Student_submitted" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Student score</h4>
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
                    <th>Check answer?</th>
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
                  @if(isset($student) && $student!="")
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
</form> <!-- end modal student_submitted -->
<!-- Modal student-->
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
                    <th>ID</th>
                    <th>Name</th>
                    <th>Score</th>
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
</div><!-- end container -->

@endsection

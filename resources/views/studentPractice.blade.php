@extends('layouts.app')

@section('content')
<div class="container">
  <form class="form-horizontal" role="form" method="get" action="studentSubject">
      {{ csrf_field() }}
  <div class="row">
      <div class="col-md-8 col-md-offset-2">
          <div class="panel panel-default">
              <div class="panel-heading">Practice name : {{$pract_name." | Dude date : ".$due_date}}</div>
              <input type="hidden" name="pract_name" value="{{$pract_name}}">
              <div class="panel-body">
                <form class="form-horizontal" role="form">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <div class="col-md-3"></div>
                        <div class="col-md-3">
                          <input type="hidden" name="sub_id" value="{{$sub_id}}">
                          <button type="submit" class="btn btn-danger">Back to subject</button>
                        </div>
                        @if(isset($score)||isset($answer))
                        <div class="col-md-3">
                          <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#score">score</button>
                        </div>
                        @endif
                    </div>
                </form>
              </div>
          </div>
      </div>
  </div>
  <!-- Modal score-->
    <div class="modal fade" id="score" role="dialog">
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Your score</h4>
          </div>
          <div class="modal-body">
            @if(!isset($score)||$score==""||$score=="[]")
              <p>ยังไม่ได้ตรวจครับ</p>
            @else
              <p>{{$score[0]->score}}</p>
            @endif
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div><!-- end modal score -->
</form>
@if($option == '1') <!-- multiple choice -->
<form class="form-horizontal" role="form" method="post" action="studentPractice">
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
            @if(isset($ch)) <!-- have choice selected by student -->
              @for($j=1;$j<=4;$j++)
                <div class="form-group">
                    <label  class="col-md-4 control-label">Choice : {{$j}}</label>
                    <div class="radio col-md-6">
                      @if(intval($ch[$i]) == $j)
                      <label><input type="radio" checked>{{$choice[$i.'_'.$j]}}</label>
                      @else
                      <label><input type="radio" disabled>{{$choice[$i.'_'.$j]}}</label>
                      @endif
                    </div>
                </div>
              @endfor
            @else <!-- Not have choice selected by student -->
                <div class="form-group">
                    <label  class="col-md-4 control-label">Choice : {{'1'}}</label>
                    <div class="radio col-md-6">
                      <label><input type="radio" name="{{'c'.$i}}" value="{{1}}" required>{{$choice[$i.'_1']}}</label>
                    </div>
                </div>
              @for($j=2;$j<=4;$j++)
                <div class="form-group">
                    <label  class="col-md-4 control-label">Choice : {{$j}}</label>
                    <div class="radio col-md-6">
                      <label><input type="radio" name="{{'c'.$i}}" value="{{$j}}">{{$choice[$i.'_'.$j]}}</label>
                    </div>
                </div>
              @endfor
            @endif <!-- end check choice selected by student -->
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
      @if(!isset($ch))
      <button type="button" class="btn btn-primary" id="submit" data-toggle="modal" data-target="#confirm">Submit</button>
      @endif
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

</form> <!--end multiple form -->

@else <!-- subjective -->
<form class="form-horizontal" role="form" method="post" action="studentPractice">
@for($i=0;$i<$num_exer;$i++)
<div class="row">
  <div class="col-md-8 col-md-offset-2">
      <div class="panel panel-default">
          <div class="panel-heading">Number : {{($i+1)}}</div>
          <div class="panel-body">
            <div class="form-group">
                <div class="col-md-1"></div>
                <div class="col-md-10">
                  <textarea class="form-control" name="{{'q'.($i+1)}}" value="{{$question[$i]}}" rows="3" id="comment" readonly>{{$question[$i]}}</textarea>
                </div><br>
            </div>
            <label>answer : </label>
            @if(isset($answer))
            <div class="form-group">
                  <div class="col-md-1"></div>
                  <div class="col-md-10">
                    <textarea class="form-control" rows="3" id="comment" readonly>{{$answer[$i]}}</textarea>
                  </div>
            </div>
            @else
            <div class="form-group">
                  <div class="col-md-1"></div>
                  <div class="col-md-10">
                    <textarea class="form-control ans_area" rows="3" id="comment" name="{{'ans'.($i+1)}}" value="" placeholder="Please enter answer data" required></textarea>
                  </div>
            </div>
            @endif
              {{ csrf_field() }}
            <!-- <div class="form-group">
                <div class="col-md-6">
                  <input type="hidden" name="sub_id" value="{{$sub_id}}">
                  <input type="hidden" name="pract_id" value="{{$pract_id}}">
                  <input type="hidden" name="pract_name" value="{{$pract_name}}">
                </div>
            </div> -->
          </div>
      </div>
  </div>
</div><!-- end row -->
@endfor <!-- end subjective -->

<div class="form-group">
    <div class="col-md-9"></div>
    <div class="col-md-3">
      <input type="hidden" name="sub_id" value="{{$sub_id}}">
      <input type="hidden" name="pract_id" value="{{$pract_id}}">
      <input type="hidden" name="option" value="{{$option}}">
      <input type="hidden" name="pract_name" value="{{$pract_name}}">
      <input type="hidden" name="num_exer" value="{{$num_exer}}">
      @if(!isset($answer))
      <button type="button" class="btn btn-primary" id="submit_btn"  data-toggle="modal" data-target="#confirm">Submit</button>
      @endif
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
  </div><!-- end modal donfirm -->
</form><!-- end subjective form -->
@endif <!-- multiple choice & subjective -->
</div> <!-- container -->

@endsection

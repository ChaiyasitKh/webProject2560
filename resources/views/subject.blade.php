@extends('layouts.app')
<style>
/*https://stackoverflow.com/questions/12978254/twitter-bootstrap-datepicker-within-modal-window*/
.datepicker{
  z-index:1151 !important;
}
</style>
@section('content')
<div class="container">
  <div class="row">
    <form class="form-horizontal" role="form" method="get" action="teacher">
        {{ csrf_field() }}
      <div class="col-md-8 col-md-offset-2">
          <div class="panel panel-default">
              <div class="panel-heading">{{"Subject name : ".$sub_name}}</div>
              <div class="panel-body">
                <form class="form-horizontal" role="form">
                    {{ csrf_field() }}
                    <div class="form-group">
                      <div class='col-md-2'></div>
                      <div class="col-md-3">
                        <button type="submit" class="btn btn-danger">Back to Home</button>
                      </div>
                        <div class="col-md-3">
                          <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#Students">Students</button>
                        </div>
                        <div class="col-md-3">
                          <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#confirmDelete">Delete subject</button>
                        </div>
                    </div>
                </form>
              </div>
          </div>
      </div>
    </form>
  </div>
  <!-- Modal confirm delete -->
<form class="form-horizontal" role="form" method="get" action="subject">{{csrf_field()}}
<div class="modal fade" id="confirmDelete" role="dialog">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Delete subject</h4>
      </div>
      <div class="modal-body">
        <p>คุณต้องการลบรายวิชานี้หรือไม่</p>
      </div>
      <div class="modal-footer">
        <input type="hidden" name="sub_id" value="{{$subID}}">
        <input type="hidden" name="delete" value="true">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-danger" >Confirm</button>
      </div>
    </div>
  </div>
</div> <!-- end modal confirm-->
</form
  <!-- Modal create practice-->
  <div class="modal fade" id="Practice" role="dialog">
    <form class="form-horizontal" role="form" method="POST" action="subject">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">{{$sub_name}}</h4>
        </div>
        <div class="modal-body">
          <!-- <p>This is a large modal.</p> -->
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="panel panel-default">
                        <div class="panel-heading">Create practice</div>
                        <div class="panel-body">
                          {{ csrf_field() }}
                          <div class="form-group">
                              <label  class="col-md-4 control-label">Practice ID</label>
                              <div class="col-md-6">
                                <input id="pracID" type="text" class="form-control" placeholder="Please enter practice id" name="pracID" value="" required>
                                <input type="hidden" name="sub_id" value="{{$subID}}">
                                <input type="hidden" name="sub_name" value="{{$sub_name}}">
                              </div>
                          </div>
                          <div class="form-group">
                              <label  class="col-md-4 control-label">Practice Name</label>
                              <div class="col-md-6">
                                <input id="pracName" type="text" placeholder="Please enter practice name" class="form-control" name="pracName" value="" required>
                              </div>
                          </div>
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
                        </div><!-- panel body -->
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Submit</button>
        </div>
      </div>
    </div>
  </form>
  </div> <!--end modal-->
  <!-- Modal student-->
  <div class="modal fade" id="Students" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">{{$sub_name}}</h4>
        </div>
        <div class="modal-body">
          <!-- <p>This is a large modal.</p> -->
          @if(!isset($std_obj)||$std_obj=="[]")
            <label>ยังไม่มีนักศึกษาในวิชานี้</label>
          @else
          <table class="table">
            <thead>
              <tr>
                <th>Student ID</th>
                <th>Student name</th>
              </tr>
            </thead>
            <tbody>
            @foreach($std_obj as $key => $val)
              <tr>
                <td>{{$val['student_id']}}</td>
                <td>{{$val['name']}}</td>
              </tr>
            @endforeach
            </tbody>
        </table>
        @endif
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div> <!--end modal-->

  <!-- show all practice -->
    @if(isset($obj)||$obj!=null||$obj!="")
    @foreach($obj as $key => $val)
      <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Practice</div>
                <div class="panel-body">
                  <form class="form-horizontal" role="form" method="get" action="practice">
                    {{ csrf_field() }}
                      <div class="row">
                          <div class="col-md-4"></div>
                          <label  class="col-md-2">Practice ID :</label>
                          <label  class="col-md-3" >{{$val['pract_id']}}</label>
                          <input type="hidden" name="sub_id" value="{{$val['sub_id']}}">
                          <input type="hidden" name="pract_id" value="{{$val['pract_id']}}">
                      </div>
                      <div class="row">
                          <div class="col-md-4"></div>
                          <label  class="col-md-2">Name :</label>
                          <label  class="col-md-3">{{$val['pract_name']}}</label>
                      </div>
                      <div class="row">
                          <div class="col-md-4"></div>
                          <label  class="col-md-2">Due date :</label>
                          <label  class="col-md-3">{{explode(' ',$val['send_late'])[0]}}</label>
                      </div>
                      <div class="row">
                          <div class="col-md-4"></div>
                          <label  class="col-md-2">Time out: </label>
                          <label  class="col-md-3">{{explode(' ',$val['send_late'])[1]}}</label>
                      </div><br>
                      <div class="form-group">
                          <div class="col-md-8 col-md-offset-4">
                              <button type="submit" class="btn btn-success">Manage practice!</button>
                          </div>
                      </div>
                  </form>
                </div>
            </div>
        </div>
    </div> <!-- endrow -->
    @endforeach
    @endif

</div>
<button class="scrollToTop">+</button>
<script>
$(document).ready(function(){
//https://paulund.co.uk/how-to-create-an-animated-scroll-to-top-with-jquery
	//Check to see if the window is top if not then display button
  $('html, body').animate({scrollTop : 0},1);
  $('.scrollToTop').fadeIn();
	//Click event to scroll to top
	$('.scrollToTop').click(function(){
    $('#Practice').modal('show');
		//$('html, body').animate({scrollTop : 0},800);
		return false;
	});

  // https://www.youtube.com/watch?v=t8LwG3gyPmg
  $(function(){
    $(".datepicker").datepicker();
  });
});
</script>
@endsection

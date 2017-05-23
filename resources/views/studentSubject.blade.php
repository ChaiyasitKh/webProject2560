@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row">
    <form class="form-horizontal" role="form" method="get" action="student">
        {{ csrf_field() }}
      <div class="col-md-8 col-md-offset-2">
          <div class="panel panel-default">
              <div class="panel-heading">{{"Subject name : ".$sub_name}}</div>
              <div class="panel-body">
                <form class="form-horizontal" role="form">
                    {{ csrf_field() }}
                    <div class="form-group">
                      <div class='col-md-3'></div>
                      <div class="col-md-3">
                        <button type="submit" class="btn btn-danger">Back to Home</button>
                      </div>
                        <div class="col-md-3">
                          <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#Students">Students</button>
                        </div>
                    </div>
                </form>
              </div>
          </div>
      </div>
    </form>
  </div>
  @foreach($obj as $key => $val)
  <div class="row">
      <div class="col-md-8 col-md-offset-2">
          <div class="panel panel-default">
              <div class="panel-heading">Practice</div>
              <div class="panel-body">
                <form class="form-horizontal" role="form" method="get" action="studentPractice">
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
                        <label  class="col-md-2">Time out : </label>
                        <label  class="col-md-3">{{explode(' ',$val['send_late'])[1]}}</label>
                    </div><br>
                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-4">
                            <button type="submit" class="btn btn-success">go to practice!</button>
                        </div>
                    </div>
                </form>
              </div>
          </div>
      </div>
  </div> <!-- endrow -->
  @endforeach

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
          <div class="container">
            <div class="row">
                <div class="col-md-5 col-md-offset-2">
                    <div class="panel panel-default">
                        <div class="panel-heading">Student in the class</div>
                        <div class="panel-body">
                          @foreach($std_obj as $key => $val)
                          <form class="form-horizontal" role="form">
                            {{ csrf_field() }}
                              <div class="row">
                                  <label  class="col-md-6">{{$val['name']}}</label>
                              </div>
                          </form>
                          @endforeach
                        </div>
                    </div>
                </div>
            </div> <!-- endrow -->
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div> <!--end modal-->
</div> <!-- end container -->
@endsection

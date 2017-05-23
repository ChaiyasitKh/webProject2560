@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Register</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('register') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Name</label>

                            <div class="col-md-6">
                                <input id="name" type="text" placeholder="Please enter your name" class="form-control" name="name" value="{{ old('name') }}" required autofocus>

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-6">
                                <input id="email" type="email" placeholder="Please enter your e-Mail" class="form-control" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Password</label>

                            <div class="col-md-6">
                                <input id="password" type="password" placeholder="Please enter your password" class="form-control" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>
                            <div class="col-md-6">
                                <input id="password-confirm" type="password" placeholder="Please enter your password again" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
                            <label  class="col-md-4 control-label">Status</label>
                            <div class="col-md-6">
                              <select id="status" class="form-control" name="status" required> <!-- stackoverflow.com -->
                                  <option value="">select</option>
                                  <option value="Teacher">Teacher</option>
                                  <option value="Student">Student</option>
                              </select>
                            </div>
                        </div>
                        <div id="std_id" class="form-group{{ $errors->has('student_id') ? ' has-error' : '' }}">
                            <label  class="col-md-4 control-label">Student ID</label>
                            <div class="col-md-6">
                              <input type="number" class="form-control" id="input_std_id" name="student_id" placeholder="Please enter your student id" value="">
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('gender') ? ' has-error' : '' }}">
                            <label  class="col-md-4 control-label">Gender</label>
                            <div class="col-md-6">
                              <select id="gender" class="form-control" name="gender" required> <!-- stackoverflow.com -->
                                  <option value="">select</option>
                                  <option value="Male">Male</option>
                                  <option value="Female">Female</option>
                              </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Register
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
$(document).ready(function(){
  $("#std_id").hide();
  $("#status").change(function(){
      var pos = $(this).val();
      if(pos=="Student"){
        $("#std_id").show();
        $("#input_std_id").prop('required',true);
      }else{
        $("#input_std_id").prop('required',false);
        $("#input_std_id").val("");
        $("#std_id").hide();
      }
  });
});
</script>
@endsection

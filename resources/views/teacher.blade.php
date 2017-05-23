@extends('layouts.app')

@section('content')
<button class="scrollToTop">+</button>
<div class="container">
    @foreach($obj as $key => $val)
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Subject</div>
                <div class="panel-body">
                  <form class="form-horizontal" role="form" method="get" action="subject">
                    {{ csrf_field() }}
                      <div class="row">
                          <div class="col-md-3"></div>
                          <label  class="col-md-3">Subject ID :</label>
                          <label  class="col-md-3" >{{$val['sub_id']}}</label>
                          <input type="hidden" name="sub_id" value="{{$val['sub_id']}}">
                      </div>
                      <div class="row">
                          <div class="col-md-3"></div>
                          <label  class="col-md-3">Subject Name :</label>
                          <label  class="col-md-3">{{$val['sub_name']}}</label>
                          <input type="hidden" name="sub_name" value="{{$val['sub_name']}}">
                      </div><br>
                      <div class="form-group">
                          <div class="col-md-6 col-md-offset-4">
                              <button type="submit" class="btn btn-success">
                                  Go to subject!
                              </button>
                          </div>
                      </div>
                  </form>
                </div>
            </div>
        </div>
    </div> <!-- endrow -->
    @endforeach

    <!-- Modal create subject-->
    <div class="modal fade" id="createSubject" role="dialog">
      <form class="form-horizontal" role="form" method="POST" action="teacher">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Create subject</h4>
          </div>
          <div class="modal-body">
            <!-- <p>This is a large modal.</p> -->
              <div class="row">
                  <div class="col-md-8 col-md-offset-2">
                      <div class="panel panel-default">
                          <!-- <div class="panel-heading">Create subject</div> -->
                          <div class="panel-body">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label  class="col-md-4 control-label">Subject ID</label>
                                <div class="col-md-6">
                                  <input id="subID" type="text" maxlength="7" placeholder="Please enter subject id" class="form-control" name="subID" value="" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label  class="col-md-4 control-label">Subject Name</label>
                                <div class="col-md-6">
                                  <input id="subName" type="text" placeholder="Please enter subject name" class="form-control" name="subName" value="" required>
                                </div>
                            </div>
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
     </div>
     </form>
    </div> <!--end modal-->
</div>
<script>
$(document).ready(function(){
//https://paulund.co.uk/how-to-create-an-animated-scroll-to-top-with-jquery
	//Check to see if the window is top if not then display button
  $('.scrollToTop').fadeIn();
  $('html, body').animate({scrollTop : 0},1);
	// $(window).scroll(function(){
	// 	if ($(this).scrollTop() > 200) {
	// 		$('.scrollToTop').fadeIn();
	// 	} else {
	// 		$('.scrollToTop').fadeOut();
	// 	}
	// });
	//Click event to scroll to top
	$('.scrollToTop').click(function(){
    $('#createSubject').modal('show');
		//$('html, body').animate({scrollTop : 0},800);
		return false;
	});

});
</script>
@endsection

<script src="http://code.jquery.com/jquery.min.js"></script>
<script src="js/bootstrap.js"></script>
<script src="js/fxn.js"></script>
<script src="js/subApp.js"></script>
<link rel="stylesheet" type="text/css" media="screen" href="css/bootstrap.css">

<div id="sub_modal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
    <h3 id="myModalLabel">Shift Details</h3>
  </div>
  <div class="modal-body">
    <p>Do you want to take this shift?</p>
  <div class="control-group">
    <label class="control-label">Name</label>
    <div class="controls">
         <span id="sub_modal_name"></span>
    </div>
  </div>
  <div class="control-group">
    <label class="control-label">Location</label>
    <div class="controls">
         <span id="sub_modal_location"></span>
    </div>
  </div>
  <div class="control-group">
    <label class="control-label">Time</label>
    <div class="controls">
         <span id="sub_modal_shift_info"></span>
    </div>
  </div>
  <div class="control-group">
    <label class="control-label">Additional Details</label>
    <div class="controls">
         <span id="sub_modal_details"></span>
    </div>
  </div>
  <form id="taker_form">
  <div class="control-group">
    <label class="control-label">Name</label>
    <div class="controls">
      <input type="text" id="taker_name" name="taker_name" placeholder="Your Name">
    </div>
  </div>
  <div class="control-group">
    <label class="control-label">Email Address</label>
    <div class="controls">
      <input type="text" id="taker_email" name="taker_email" placeholder="Your Email Address">
    </div>
  </div>
  <input type="hidden" id="sub_modal_shift_id" name="req_id" />
  </form>

  </div>
  <div class="modal-footer">
    <form style="display:none;" id="shift_clear_form">
       <input type="hidden" name="usr_change" value="1">
       <div class="control-group">
         <label class="control-label">Enter the email address used to submit/pick up the request to clear/delete</label>
         <div class="controls">
           <input type="text" name="usr_email" id="usr_email">
         </div>
         <div class="controls">
           <a class="btn btn-warning" id="btn_clear_req">Clear Request</a>
           <a class="btn btn-danger" id="btn_del_req">Delete Request</a>
         </div>
        </div>
    </form>
    <img src="ajx/loader.gif" class="hide" id="sub_loader">
    <label id="shift_delete_success" class="label label-success hide ">Shift successfully deleted!</label>
    <label id="shift_delete_fail" class="label label-important hide ">Shift was unable to be deleted. Please refresh & try again.</label>
    <label id="shift_clear_success" class="label label-success hide ">Shift successfully cleared!</label>
    <label id="shift_edit_unauth" class="label label-important hide ">Unauthorized to edit this shift. Enter the same email in which you took/picked up the shift.</label>
    <label id="shift_clear_fail" class="label label-important hide ">Shift was unable to be cleared. Please refresh & try again.</label>
    <label id="shift_take_success" class="label label-success hide ">Shift successfully taken!</label>
    <label id="shift_take_fail" class="label label-important hide ">Shift was unable to be taken. Please refresh & try again.</label>
    <label id="shift_resub_success" class="label label-success hide ">Successfully re-submitted!</label>
    <label id="shift_resub_fail" class="label label-important hide ">Unable to be re-submitted. Please refresh & try again.</label>
    <button class="btn btn-inverse" id="req_clear_btn">Cancel/Clear Request</button>
    <button class="btn btn-inverse" id="re_submit_req_btn">Resubmit</button>
    <button id="taker_submit_btn" class="btn btn-success">Take Shift</button>
    <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true">Close</button>
    <script>
    $("#req_clear_btn").click(function(){
        $("#shift_clear_form").show();
    });
    $("#btn_clear_req").click(function(){
        $("#sub_loader").show();
        $.post('ajx/ps.php', {'clear_request':1,'req_id':$("#sub_modal_shift_id").val(),'usr_email':$("#usr_email").val()})
        .done(function(resp){
            $("#sub_loader").hide();
            if(resp.code == 1){
                showThenFade("#shift_clear_success");
                $("#shift_clear_form").find("input[type=text]").val("");
                $("#shift_clear_form").hide();
            }
            else if(resp.code == 3){
                showThenFade("#shift_edit_unauth");
            }
            else{
                showThenFade("#shift_clear_fail");
            }
        });
    });
    $("#btn_del_req").click(function(){
        $("#sub_loader").show();
        $.post('ajx/ps.php', {'delete_request':1,'req_id':$("#sub_modal_shift_id").val(),'usr_email':$("#usr_email").val()})
        .done(function(resp){
            $("#sub_loader").hide();
            if(resp.code == 1){
                showThenFade("#shift_delete_success");
                $("#shift_clear_form").find("input[type=text]").val("");
                $("#shift_clear_form").hide();
            }
            else if(resp.code == 3){
                showThenFade("#shift_edit_unauth");
            }
            else{
                showThenFade("#shift_delete_fail");
            }
        });
    });
    $("#re_submit_req_btn").click(function(){
        $("#sub_loader").show();
        $.post('ajx/ps.php', {'resubmit_request':1,'req_id':$("#sub_modal_shift_id").val()})
        .done(function(resp){
            $("#sub_loader").hide();
            if(resp.code == 1){
                showThenFade("#shift_resub_success");
                $("#taker_form").find("input[type=text], textarea").val("");
            }
            else{
                showThenFade("#shift_resub_fail");
            }
        });
    });
    $("#taker_submit_btn").click(function(){
        $("#sub_loader").show();
        $.post('ajx/ps.php', $("#taker_form").serialize())
        .done(function(resp){
            $("#sub_loader").hide();
            if(resp.code == 1){
                showThenFade("#shift_take_success");
                $("#taker_form").find("input[type=text], textarea").val("");
            }
            else{
                showThenFade("#shift_take_fail");
            }
        });
    });
    </script>
  </div>
</div>






<ul class="nav nav-tabs">
    <li class="active"><a href="#board" data-toggle="tab">Board</a></li>
    <li class=""><a href="#admin" data-toggle="tab">Admin</a></li>
</ul>
<div class="tab-content">
    <div class="tab-pane fade active in" id="board">
<form id="sub_req_form">
  <div class="control-group">
    <label class="control-label">Name</label>
    <div class="controls">
      <input type="text" id="name" name="name" placeholder="Name">
    </div>
  </div>
  <div class="control-group">
    <label class="control-label">Email Address (confirmation of shift pick-up will be sent here)</label>
    <div class="controls">
      <input type="text" id="email" name="email" placeholder="Email">
    </div>
  </div>
  <div class="control-group">
    <label class="control-label">Date</label>
    <div class="controls">
       <select id="sub_month" name="sub_month" class="inline">
       </select>
       <select id="sub_day" name="sub_day" class="inline">
       </select>
       <select id="sub_year" name="sub_year" class="inline">
       </select>
    </div>
  </div>
  <div class="control-group">
    <label class="control-label">Time</label>
    <div class="controls">
    <label class="control-label">Start</label>
       <select id="sub_start_hour" name="sub_start_hour" class="inline">
       </select>
       <select id="sub_start_min" name="sub_start_min" class="inline">
       </select>
       <select id="sub_start_tod" name="sub_start_tod" class="inline">
           <option>AM</option>
           <option>PM</option>
       </select>
    <label class="control-label">End</label>
       <select id="sub_end_hour" name="sub_end_hour" class="inline">
       </select>
       <select id="sub_end_min" name="sub_end_min" class="inline">
       </select>
       <select id="sub_end_tod" name="sub_end_tod" class="inline">
           <option>AM</option>
           <option>PM</option>
       </select>
    </div>
  </div>
  <div class="control-group">
    <label class="control-label">Location</label>
    <div class="controls">
       <select id="sub_location" name="sub_location">
       </select>
    </div>
  </div>
  <div class="control-group">
    <label class="control-label">Details (optional)</label>
    <div class="controls">
       <textarea id="sub_details" name="sub_details" cols=50 rows=5></textarea>
       <label class="label label-success hide" id="req_submit_success">Request successfully submitted!</label>
       <label class="label label-important hide" id="req_submit_fail">Error submitting request. Please try again.</label>
       <br><a class="btn btn-stanford" id="req_submit">Submit Request</a>
    </div>
  </div>
</form>

<img src="ajx/loader.gif" id="sub_app_loader">
<div id="app_area">
</div>

<script>
    //inflate select boxes
    inflateSelectMonths("#sub_month");
    inflateSelectDays("#sub_day");
    inflateSelectYears("#sub_year");
    inflateSelectLocations("#sub_location");
    inflateSelectHours("#sub_start_hour");
    inflateSelectMins("#sub_start_min");
    inflateSelectHours("#sub_end_hour");
    inflateSelectMins("#sub_end_min");
    $("#sub_app_loader").show();
    //start app
    initSubApp("#app_area");

    //on submit
    $("#req_submit").click(function() {
        $.post('ajx/ps.php', $("#sub_req_form").serialize())
        .done(function(resp){
            if(resp.code == 1){
                showThenFade("#req_submit_success");
                $("#sub_req_form").find("input[type=text], textarea").val("");
            }
            else{
                showThenFade("#req_submit_fail");
            }
        });
    });
</script>
    </div>


    <div class="tab-pane fade" id="admin">
     <div id="admin-pw-entry">
        Admin Password
        <input type="password" id="passwd-admin" />
        <a href="#" id="admin-pw-entry-btn" class="btn btn-success">Enter</a>
        <span class="label label-important hide" id="adm-pass-false">Incorrect password, please try again.</span>
      </div>
        <form id="sub_admin_form" style="display:none;">
            <h3>Add An Available Shift</h3>
            <div class="control-group">
    <label class="control-label">Date</label>
    <div class="controls">
       <select id="avail_month" name="avail_month" class="inline">
       </select>
       <select id="avail_day" name="avail_day" class="inline">
       </select>
       <select id="avail_year" name="avail_year" class="inline">
       </select>
    </div>
  </div>
  <div class="control-group">
    <label class="control-label">Time</label>
    <div class="controls">
    <label class="control-label">Start</label>
       <select id="avail_start_hour" name="avail_start_hour" class="inline">
       </select>
       <select id="avail_start_min" name="avail_start_min" class="inline">
       </select>
       <select id="avail_start_tod" name="avail_start_tod" class="inline">
           <option>AM</option>
           <option>PM</option>
       </select>
    <label class="control-label">End</label>
       <select id="avail_end_hour" name="avail_end_hour" class="inline">
       </select>
       <select id="avail_end_min" name="avail_end_min" class="inline">
       </select>
       <select id="avail_end_tod" name="avail_end_tod" class="inline">
           <option>AM</option>
           <option>PM</option>
       </select>
    </div>
  </div>
  <div class="control-group">
    <label class="control-label">Location</label>
    <div class="controls">
       <select id="avail_location" name="sub_location">
       </select>
    </div>
  </div>
<div class="control-group">
    <div class="controls">
      <span class="label label-success hide" id="ashift_add_success">Successfully added to the board!</span>
      <span class="label label-important hide" id="ashift_add_fail">Error adding to the board. Please try again.</span>
      <br><br><img src="ajx/loader.gif" class="hide" id="admin_loader"><a class="btn btn-stanford" href="#" id="ashift_add_btn">Add to Board</a>
    <script>
    $("#ashift_add_btn").click(function(){
       $("#admin_loader").show();
       $.post('ajx/ps.php',{avail_location:$("#avail_location").val(),avail_month:$("#avail_month").val(),avail_day:$("#avail_day").val(),avail_year:$("#avail_year").val(),avail_start_hour:$("#avail_start_hour").val(),avail_start_min:$("#avail_start_min").val(),avail_end_hour:$("#avail_end_hour").val(),avail_end_min:$("#avail_end_min").val()})
       .done(function(resp){
         $("#admin_loader").hide();
         if(resp.code == 1){
            showThenFade("#ashift_add_success");
            $("#name").val("");
         }
         else{
            showThenFade("#ashift_add_fail");
         }
       });
     });
    </script>
    </div>
  </div>
        </form>
    </div>
</div>
<script>
    inflateSelectMonths("#avail_month");
    inflateSelectDays("#avail_day");
    inflateSelectYears("#avail_year");
    inflateSelectLocations("#avail_location");
    inflateSelectHours("#avail_start_hour");
    inflateSelectMins("#avail_start_min");
    inflateSelectHours("#avail_end_hour");
    inflateSelectMins("#avail_end_min");
$("#passwd-admin").keypress(function( event ) {
  if ( event.which == 13 ) {
     verifyAndShowSubAdmin($("#passwd-admin").val());
  }
});
$("#admin-pw-entry-btn").click(function(){
     verifyAndShowSubAdmin($("#passwd-admin").val());
});
</script>
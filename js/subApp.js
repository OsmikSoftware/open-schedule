/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//base views from current week
var date = new Date();
var cur_day = date.getDay();
var cur_date = date.getDate();
var cur_month = date.getMonth();
var cur_year = date.getFullYear();
var int_month = cur_month+1;

function populateSubRequests(div){
    $("#sub_app_loader").show();
    $.get('ajx/fs.php?load_requests=all', function(data){
        $.each(data, function(k,v){
            var is_taken = v.is_taken;
            //fetch location name
            $.get('../subs_svc.php?location_name='+v.location_id, function(loc){
                //add name via html
                $("#location_"+id).html(loc.name);
            });
            var id = v.id;
            var start_date = getDateFromUnix(v.shift_start);
            var end_date = getDateFromUnix(v.shift_end);
            //start
            var start_month = getMonths()[start_date.getMonth()];
            var start_weekday = getWeekdays()[start_date.getDay()];
            var start_year = start_date.getFullYear();
            var start_hour = start_date.getHours();
            var formattedStartHour = returnFormattedMilHour(start_hour);
            var start_hr_parts = formattedStartHour.split(" ");
            var actual_start_hour = start_hr_parts[0].split(":")[0];
            var actual_start_minute = (start_date.getMinutes() == 0) ? start_date.getMinutes()+"0" : start_date.getMinutes();
            var actual_start_tod = start_hr_parts[1];
            //end
            var end_month = getMonths()[end_date.getMonth()];
            var end_weekday = getWeekdays()[end_date.getDay()];
            var end_year = end_date.getFullYear();
            var end_hour = end_date.getHours();
            var formattedEndHour = returnFormattedMilHour(end_hour);
            var end_hr_parts = formattedEndHour.split(" ");
            var actual_end_hour = end_hr_parts[0].split(":")[0];
            var actual_end_minute = (end_date.getMinutes() == 0) ? end_date.getMinutes()+"0" : end_date.getMinutes();
            var actual_end_tod = end_hr_parts[1];
            
            var shift_range = actual_start_hour+":"+actual_start_minute+actual_start_tod+"-"+actual_end_hour+":"+actual_end_minute+actual_end_tod;
            //data to add to cell
            var cell_data = "<a href='#sub_modal' data-toggle='modal' id='cell_id"+id+"'><label class='label text-center' id='sub_id_"+id+"'>";
            cell_data += "<span id='location_"+id+"'></span><br>";
            cell_data += shift_range;
            cell_data += "</label></a><br>";
            //adds info to cell
            //$("."+start_weekday+"."+actual_start_hour+actual_start_tod).append(cell_data);
            $("."+start_month+"."+start_date.getDate()+"."+start_weekday+"."+actual_start_hour+actual_start_tod).append(cell_data);
            $("#sub_app_loader").hide();
            $("#cell_id"+id).click(function(){
                $("#sub_modal_name").html(v.name);
                $("#sub_modal_shift_id").val(v.id);
                $("#sub_modal_location").html($("#location_"+id).html());
                $("#sub_modal_shift_info").html(start_weekday+" "+(start_date.getMonth()+1)+"/"+start_date.getDate()+", "+shift_range);
                $("#sub_modal_details").html(v.details);
            });
            //add classes to cell data we just added
            if(is_taken != 1){
                //if sub is still available, color it green
                $("#sub_id_"+id).addClass("label-success");
            }
            else{
                //if not, color it red
                $("#sub_id_"+id).addClass("label-important");
                //disables clickable sub request when sub is taken
                //$("#cell_id"+id).attr('data-toggle','');
            }
        });
    });
}
/*
 * Main initializing function for the sub request app.
 * Actions: draws the table, then calls populateSubRequests to populate the data
 */
function initSubApp(div){
    //get left-handed display hours from given source
    var hours = getStaffHours();
    var board = '<span class="pull-left"><a href="'+div+'" id="prev_week"><i class="icon-chevron-left"></i>Previous Week</a></span><span class="pull-right"><a href="'+div+'" id="next_week">Next Week<i class="icon-chevron-right"></i></a></span>';
        board +='<table class="table table-bordered">';
    var days = getWeekdays();
    for(var i=0;i<days.length; i++){
        //create weekday headers (left to right)
        board += '<th>'+days[i];
        
        //magic of what date to display
        var diff = i-cur_day;
        var d = new Date(cur_year, cur_month, (cur_date+diff));
        board += '<br>('+(d.getMonth()+1)+'/'+d.getDate()+')';
        /*if(cur_day == i){
            board +='('+int_month+'/'+cur_date+')';
        }*/
        board+='</th>';
    }
    board += '<tbody>';
    for(var i=0;i<hours.length;i++){
        //new row for each hour (top to bottom)
        board += '<tr>';
        for(var d=0;d<days.length;d++){
            //new cell for each day under the same hour (left to right)
            board += '<td class="';
            //magic of what date to display
            var diff = d-cur_day;
            var da= new Date(cur_year, cur_month, (cur_date+diff));
            board += getMonths()[da.getMonth()]+' '+da.getDate()+' ';
            board += days[d]+' '+hours[i]+'">';
            
            board+='</td>';
        }
        board += '</tr>';
    }
    board += '</tbody>'
            +'</table>';
    $(div).html(board);
    $("#prev_week").click(function(){
        //change dates & reinit
        var n_date = cur_date-7;
        date = new Date(cur_year, cur_month, n_date);
        cur_day = date.getDay();
        cur_date = date.getDate();
        cur_month = date.getMonth();
        cur_year = date.getFullYear();
        int_month = cur_month+1;
        initSubApp(div);
    });
    $("#next_week").click(function(){
        //change dates & reinit
        var n_date = cur_date+7;
        date = new Date(cur_year, cur_month, n_date);
        cur_day = date.getDay();
        cur_date = date.getDate();
        cur_month = date.getMonth();
        cur_year = date.getFullYear();
        int_month = cur_month+1;
        initSubApp(div);
    });
    populateSubRequests(div);
}
function getMonths(){
    return ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
}
function getWeekdays(){
    return ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
}
//formats 24hr format hour to 12hr equiv in 'h:m a' format
function returnFormattedMilHour(hour){
    var formattedHour = '';
    if(parseInt(hour) == 0){
        formattedHour = "12:00 AM";
    }
    if(hour > 0 && hour < 12){
        formattedHour = hour+":00 AM";
    }
    if(hour == 12){
        formattedHour = "12:00 PM";
    }
    if(hour > 12){
        formattedHour = (parseInt(hour)-12)+":00 PM";
    }
    return formattedHour;
}
function getStaffHours(){
    var hours = [];
    for(var i=5;i<=12;i++){
        if(i == 12){
            hours.push(i+"PM");
        }
        else{
            hours.push(i+"AM");
        }
    }
    for(var i=1;i<=11;i++){
        hours.push(i+"PM");
    }
    hours.push("12AM","1AM");
    return hours;
}
function inflateSelectLocations(id){
    $.get('ajx/fs.php?locations=staff', function(data){
        $.each(data, function(k,v){
           $(id).append('<option>'+v.name+'</option>'); 
        });
    });
}
function inflateSelectMonths(id){
    for(var i=0;i<getMonths().length;i++){
        $(id).append('<option>'+getMonths()[i]+'</option>');
    }
}
function inflateSelectDays(id){
    for(var i=1;i<=31;i++){
        $(id).append('<option>'+i+'</option>');
    }
}
function inflateSelectHours(id){
    for(var i=1;i<=12;i++){
        $(id).append('<option>'+i+'</option>');
    }
}
function inflateSelectMins(id){
    for(var i=0;i<=59;i++){
        if(i<10){
           i = '0'+i; 
        }
        $(id).append('<option>'+i+'</option>');
    }
}
function inflateSelectYears(id){
    for(var i=2014;i<=2015;i++){
        $(id).append('<option>'+i+'</option>');
    }
}
function drawScheduler(){
    var blocks = ["5:45AM-12:00PM","12:0PM-4:00PM","4:00PM-8:00PM","8:00PM-1:00AM"];
    var scheduler = '<table class="table table-bordered">';
    var days = getWeekdays();
    for(var i=0;i<days.length; i++){
        scheduler += '<th>'+days[i]+'</th>';
    }
    scheduler += '<tbody>';
    for(var i=0;i<blocks.length;i++){
        scheduler += '<tr>';
        for(var d=0;d<days.length;d++){
            scheduler += '<td><input type="checkbox" name="'+days[d]+'_'+blocks[i]+'" />'+blocks[i]+' <br>Preferred?<input type="checkbox" name="pref_'+days[d]+'_'+blocks[i]+'" /></td>';
        }
        scheduler += '</tr>';
    }
    scheduler += '</tbody>';
    scheduler += '</table>';
    return scheduler;
}
function verifyAndShowSubAdmin(password){
    $.post('ajx/ps.php',{admin_pw:password})
    .done(function(resp){
      if(resp.code == 1){
          $("#sub_admin_form").show();
      }
      else{
          showThenFade("#adm-pass-false");
      }
    });
}
$(document).ready(function () {
        
        if ($("#mytasks").hasClass("active")) {
            $("#grouptasks").hide();
            $("#mytasks").show();
        } else if ($("#grouptasks").hasClass("active")) {
            $("#mytasks").hide();
            $("#grouptasks").show();
        }else if ($("#tasks").hasClass("active")) {
            $("#editProfile").hide();
            $("#friends").hide();
            $("#tasks").show();
        } else if ($("#friends").hasClass("active")) {
            $("#editProfile").hide();
            $("#tasks").hide();
            $("#friends").show();
        } else if ($("#editProfile").hasClass("active")) {
            $("#friends").hide();
            $("#tasks").hide();
            $("#editProfile").show();
        }
        
    $("#nav").find("a").click(function () {
        $("#nav").find("a").removeClass("active");
        $(this).addClass("active");
        
        $active = $(this).attr("href");
        
        if($active === "#mytasks"){
            $('#grouptasks').hide();
            $('#grouptasks').removeClass("active");
            $("#mytasks").show(); 
        } else if($active === "#grouptasks") {
            
            $('#mytasks').hide();
            $('#mytasks').removeClass("active");
            $("#grouptasks").show();
        } 
        else if($active === "#tasks") {
            $('#editProfile').hide();
            $('#friends').hide();
            //$('#editProfile').removeClass("active");
            //$('#friends').removeClass("active");
            $("#tasks").show();
        } else if($active === "#editProfile") {
            $('#tasks').hide();
            $('#friends').hide();
            //$('#tasks').removeClass("active");
            //$('#friends').removeClass("active");
            $("#editProfile").show();
        } else if($active === "#friends") {
            $('#tasks').hide();
            $('#editProfile').hide();
            //$('#tasks').removeClass("active");
            //$('#editProfile').removeClass("active");
            $("#friends").show();
        }
    });
    
    document.getElementById("date").innerHTML = date();
    
    function time(){
        var d = new Date(),
        minutes = d.getMinutes().toString().length == 1 ? '0'+d.getMinutes() : d.getMinutes(),
        hours = d.getHours().toString().length == 1 ? '0'+d.getHours() : d.getHours(),
        ampm = d.getHours() >= 12 ? 'pm' : 'am';
        var time = hours+':'+minutes+ampm;
        document.getElementById("time").innerHTML = time;
    }setInterval(time, 1000);
    
    function date(){
        var d = new Date(),
        months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],
        days = ['Sun','Mon','Tue','Wed','Thu','Fri','Sat'];
        return days[d.getDay()]+' '+months[d.getMonth()]+' '+d.getDate()+' '+d.getFullYear();
    }
});


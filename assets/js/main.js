$(document).ready(function () {
        
        if ($("#mytasks").hasClass("active")) {
            $("#grouptasks").hide();
            $("#mytasks").show();
        } else if ($("#grouptasks").hasClass("active")) {
            $("#mytasks").hide();
            $("#grouptasks").show();
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
            $('#mytasks').removeClass("active")
            $("#grouptasks").show();
        }
    });
    
    $( function() {
        $( "#datepicker" ).datepicker();
    });
    
    $('#selector').wickedpicker({
          twentyFour: true,  
          
          now: "12:00",
          
          upArrow: 'wickedpicker__controls__control-up',
	  downArrow: 'wickedpicker__controls__control-down',
	  close: 'wickedpicker__close',
	  hoverState: 'hover-state',
          
          title: 'Start Time'
    });
    
    $('#selector2').wickedpicker({
        twentyFour: true,
        
        now: "12:00",
        
        upArrow: 'wickedpicker__controls__control-up',
	downArrow: 'wickedpicker__controls__control-down',
	close: 'wickedpicker__close',
	hoverState: 'hover-state',
          
        title: 'End Time'
    });

});


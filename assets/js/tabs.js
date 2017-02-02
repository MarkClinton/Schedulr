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

});

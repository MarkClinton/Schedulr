$(document).ready(function () {
        
        if ($("#tasks").hasClass("active")) {
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
        
        if($active === "#tasks"){
            $("#editProfile").hide();
            $("#friends").hide();
            $("#tasks").show();
        } else if($active === "#grouptasks") {
            
            $('#mytasks').hide();
            $('#mytasks').removeClass("active")
            $("#grouptasks").show();
        }
    });
});


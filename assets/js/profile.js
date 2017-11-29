$(document).ready(function () {
        
    $("#nav").find("a").click(function () {
        $("#nav").find("a").removeClass("active");
        $(this).addClass("active");
        
        $active = $(this).attr("href");
    });
});


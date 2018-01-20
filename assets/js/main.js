$(document).ready(function () {

    $("#nav").find("a").click(function () {
        $("#nav").find("a").removeClass("active");
        $(this).addClass("active");

        $active = $(this).attr("href");
    });

    //document.getElementById("date").innerHTML = date();

    function time() {
        var d = new Date(),
                minutes = d.getMinutes().toString().length == 1 ? '0' + d.getMinutes() : d.getMinutes(),
                hours = d.getHours().toString().length == 1 ? '0' + d.getHours() : d.getHours(),
                ampm = d.getHours() >= 12 ? 'pm' : 'am';
        var time = hours + ':' + minutes + ampm;
        //document.getElementById("time").innerHTML = time;
    }
    setInterval(time, 1000);

    function date() {
        var d = new Date(),
                months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                days = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
        return days[d.getDay()] + ' ' + months[d.getMonth()] + ' ' + d.getDate() + ' ' + d.getFullYear();
    }

    
});

function openNav() {
        document.getElementById("addSidenav").style.height = "409px";
    }

    function closeNav() {
        document.getElementById("addSidenav").style.height = "0px";
    }


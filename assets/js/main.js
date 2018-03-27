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
    document.getElementById("addSidenav").style.height = "500px";
    $('#overlay-back').fadeIn(500); 
}

function closeNav() {
    document.getElementById("addSidenav").style.height = "0px";
    $('#overlay-back').fadeOut(500); 
}

function openLogin() {
    document.getElementById("login").style.height = "300px";
    $('#overlay-back').fadeIn(700); 
}

function closeLogin() {
    document.getElementById("login").style.height = "0px";
    $('#overlay-back').fadeOut(500); 
}

function openReg() {
    document.getElementById("reg").style.height = "409px";
    $('#overlay-back').fadeIn(700); 
}

function closeReg() {
    document.getElementById("reg").style.height = "0px";
    $('#overlay-back').fadeOut(500); 
}

function pictureUpload() {
    var isShow = $("#pictureUpload").height();
    var button = $("#ppButton");

    if (isShow == 0){
        document.getElementById("pictureUpload").style.height = "120px";
        $('#ppButton').removeClass('btn-success');
        $('#ppButton').addClass('btn-danger');
        /*button.html("x");*/
        button.html("<i class='fa fa-times'>");

    } else {
        document.getElementById("pictureUpload").style.height = "0px";
        $('#ppButton').removeClass('btn-danger');
        $('#ppButton').addClass('btn-success');
        button.html("<i class='fa fa-plus'></i>");
        document.getElementById('imageField').value = "";
    }
}
 
function showAddUser() {
    document.getElementById("addSidenav").style.height = "309px";
    $('#overlay-back').fadeIn(500); 
}

function closeAddUser() {
    document.getElementById("addSidenav").style.height = "0px";
    $('#overlay-back').fadeOut(500); 
}




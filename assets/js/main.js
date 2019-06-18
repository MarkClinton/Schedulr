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


    //Wicked picker set up for create task page
    $('#selector_start_create').wickedpicker({twentyFour: true, now: "12:00", title: "Start Time", show: showPicker});
    $('#selector_end_create').wickedpicker({twentyFour: true, now: "12:00", title: "End Time", show: showPicker});

    $('#selector_start_create,#selector_end_create').focus(function(){
        $('.wickedpicker').css({'display': 'none'});
    });

    $('#selector_start_update,#selector_end_update').focus(function(){
        $('.wickedpicker').css({'display': 'none'});
    }); 
    
});

// Function needed to change titles on wickedpicker. Only solution. 

function showPicker( element ) {
    $( '.wickedpicker__title' ).contents().first().replaceWith( ( ( this.options !== undefined ) ? this.options.title : this.title ) );
}

window.onload = function(){ 
    $('#overlay-back').onclick = function(){
        var reg = $('#reg').height(); 
        var login = $('#login').height(); 
        var mappop = $('#locationAdd').height(); 
        var addUser = $('#addUser').height();
        var addFriend = $('#addFriend').height();
        var note = $('#note').height();
        var file = $('#fileUp').height();
        var pword = $('#update_password').height();
        var update = $('#updateTask').height();

        if(reg == 360){
            closeReg();
        }else if(mappop == 400){
            closeLocation();
        }else if(login == 250){
            closeLogin();
        }else if(addUser == 550){
            closeAddUser();
        }else if(addFriend == 350){
            closeNav();
        }else if(note == 250){
            closeNote();
        }else if(file == 150){
            closeFile();
        }else if(pword == 280){
            closeUpdatePassword();
        }else if(update == 500){
            closeUpdate();
        }
    }
};

function openNav() {
    document.getElementById("addFriend").style.height = "350px";
    $('#overlay-back').fadeIn(500); 
}

function closeNav() {
    document.getElementById("addFriend").style.height = "0px";
    $('#overlay-back').fadeOut(500); 
    setTimeout(function(){
        document.getElementById("searchInput").value = "";
    }, 600);

}

function openUpdate() {
    document.getElementById("updateTask").style.height = "500px";
    $('#overlay-back').fadeIn(700); 
}

function closeUpdate() {
    document.getElementById("updateTask").style.height = "0px";
    $('#overlay-back').fadeOut(700); 
}

function openLogin() {
    document.getElementById("login").style.height = "250px";
    $('#overlay-back').fadeIn(700); 
    if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
        $('#menu-collapse').trigger('click');
    };

}

function closeLogin() {
    document.getElementById("login").style.height = "0px";
    $('#overlay-back').fadeOut(500); 
}

function openReg() {
    document.getElementById('home').scrollIntoView({ behavior: 'smooth', block: 'start', inline: 'nearest' });
    document.getElementById("reg").style.height = "360px";
    $('#overlay-back').fadeIn(700); 
    if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
        $('#menu-collapse').trigger('click');
    };
}

function closeReg() {
    document.getElementById("reg").style.height = "0px";
    $('#overlay-back').fadeOut(500); 
}
 
function showAddUser() {
    document.getElementById("addUser").style.height = "550px";
    $('#overlay-back').fadeIn(500); 
}

function closeAddUser() {
    document.getElementById("addUser").style.height = "0px";
    $('#overlay-back').fadeOut(500); 
}

function showNote() {
    document.getElementById("note").style.height = "250px";
    $('#overlay-back').fadeIn(500); 
}

function closeNote() {
    document.getElementById("note").style.height = "0px";
    $('#overlay-back').fadeOut(500); 
    setTimeout(function(){
        document.getElementById("noteTextArea").value = "";
    }, 600);
}

function showLocation() {
    initMap();
    document.getElementById("locationAdd").style.height = "400px";
    $('#overlay-back').fadeIn(500); 

}

function closeLocation() {
    document.getElementById("locationAdd").style.height = "0px";
    $('#overlay-back').fadeOut(500); 
}

function showFile() {
    document.getElementById("fileUp").style.height = "150px";
    $('#overlay-back').fadeIn(500); 
}

function closeFile() {
    document.getElementById("fileUp").style.height = "0px";
    $('#overlay-back').fadeOut(500); 
    setTimeout(function(){
        $('#upload-file-task').html("");
    }, 600);
}

function showUpdatePassword() {
    document.getElementById("update_password").style.height = "280px";
    $('#overlay-back').fadeIn(500); 
}

function closeUpdatePassword() {
    document.getElementById("update_password").style.height = "0px";
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
        setTimeout(function(){
            $('#upload-file-info').html("");
        }, 600);
    }
}







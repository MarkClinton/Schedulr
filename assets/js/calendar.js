$(document).ready(function() {

    $('#calendar').fullCalendar({
            header: { 
            	right: 'month,agendaWeek,agendaDay,listDay' ,
            	center: 'title',
    			left: 'prev,next'
            }, 

events: function(start, end, timezone, callback) {
        $.ajax({
            url: 'displayTasks',
            type: 'POST',
            dataType: 'json',
            data: {
                // our hypothetical feed requires UNIX timestamps
                start: start.unix(),
                end: end.unix()
            },
            success: function(response) {
            	//var task = JSON.parse(response);
            	console.log(JSON.stringify(response));
            	console.log(response[0].TASK_NAME);
                var events = [];
                    events.push({
                        title: response[0].TASK_NAME,
                        start: response[0].TASK_DATE 
                    });

                callback(events);
            }
        });
    }

    })

});
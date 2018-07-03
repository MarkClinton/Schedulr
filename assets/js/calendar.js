$(document).ready(function() {

    $('#calendar').fullCalendar({
            header: { 
            	right: 'month,agendaWeek,agendaDay' ,
            	center: 'title',
    			left: 'prev,next'
            }, 

	eventSources: [{
		events: function(start, end, timezone, callback) {
        $.ajax({
            url: 'displayUpcomingTasks',
            type: 'POST',
            dataType: 'json',
            data: {
                // our hypothetical feed requires UNIX timestamps
                start: start.unix(),
                end: end.unix()
            },
            success: function(response) {
                var events = [];

                for (var i in response.tasks){
                	var dateTimeStart = response.tasks[i].task_date + " " + response.tasks[i].start_time;
                	var dateTimeEnd = response.tasks[i].task_date + " " + response.tasks[i].end_time;
                	events.push({
                		id:    response.tasks[i].id,
  						title: response.tasks[i].name,
                        start: dateTimeStart,
                        end:   dateTimeEnd,
                        description: response.tasks[i].info,
                        type: response.tasks[i].type
  					});
                }
                callback(events);
            }
        });
    }
	}],
    eventRender: function(event, element) {

        console.dir(event.id);
    	var start = convertTimestamp(event.start);
    	var end   = convertTimestamp(event.end);

        if(event.type == 1){
                element.css('background-color', '#D48D95');
            }else if(event.type == 2){
                element.css('background-color', '#56BCD8');
            }else if(event.type == 3){
                element.css('background-color', '#68D5BD');
            }else{
                element.css('background-color', '#FBD76C');
            }

        var contentInfo = '<h4>'+ event.title +'</h4>' + 
				'<p>'+ event.description + '</p><br />';
        element.qtip({
        	position: {
				my: 'bottom center',
				at: 'top center'
			},
			show: {
            	solo: true
            },
			hide: {
                fixed: true,
                delay: 500
            },
        	style: 'qtip-blue',
            content: contentInfo
        });
    },
    eventClick: function(event){
        window.location.href = "tasks/task?id=" + event.id;
    }

    })

});

    function convertTimestamp(timestamp) {
	  	var d = new Date(timestamp),	// Convert the passed timestamp to milliseconds
			yyyy = d.getFullYear(),
			mm = ('0' + (d.getMonth() + 1)).slice(-2),	// Months are zero based. Add leading 0.
			dd = ('0' + d.getDate()).slice(-2),			// Add leading 0.
			hh = d.getHours(),
			h = hh,
			min = ('0' + d.getMinutes()).slice(-2),		// Add leading 0.
			ampm = 'AM',
			time;
				
		if (hh > 12) {
			h = hh - 12;
			ampm = 'PM';
		} else if (hh === 12) {
			h = 12;
			ampm = 'PM';
		} else if (hh == 0) {
			h = 12;
		}
		
		// ie: 2013-02-18, 8:35 AM	
		time = yyyy + '-' + mm + '-' + dd + ', ' + h + ':' + min + ' ' + ampm;
			
		return time;
	}

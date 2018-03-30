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
                for (var i in response){
                	var dateTimeStart = response[i].TASK_DATE + " " + response[i].START_TIME;
                	var dateTimeEnd = response[i].TASK_DATE + " " + response[i].END_TIME;
                	events.push({
                		id:    response[i].TASK_ID,
  						title: response[i].TASK_NAME,
                        start: dateTimeStart,
                        end:   dateTimeEnd,
                        description: response[i].TASK_INFO
  					});
                }
                callback(events);
            }
        });
    }
	}],
    eventRender: function(event, element) {
    	var start = convertTimestamp(event.start);
    	var end   = convertTimestamp(event.end);

        var contentInfo = '<h3>'+ event.title +'</h3>' + 
				'<p><b>Start: </b> '+ start +'<br />' + 
				'<b>End: </b> ' + end + '<br />' +
				event.description + '</p><br />';
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

$(document).ready(function() {
	var tooltip = $('<div/>').qtip({
		id: 'fullcalendar',
		prerender: true,
		content: {
			text: ' ',
			title: {
				button: true
			}
		},
		position: {
			my: 'bottom center',
			at: 'top center',
			target: 'mouse',
			viewport: $('#fullcalendar'),
			adjust: {
				mouse: false,
				scroll: false
			}
		},
		show: false,
		hide: false,
		style: 'qtip-light'
	}).qtip('api');

    $('#calendar').fullCalendar({
            header: { 
            	right: 'month,agendaWeek,agendaDay' ,
            	center: 'title',
    			left: 'prev,next'
            }, 

    eventClick: function(data, event, view) {
			var content = '<h3>'+data.title+'</h3>' + 
				'<p><b>Start:</b> '+data.start+'<br />' + 
				data.description + '</p>';

			tooltip.set({
				'content.text': content
			})
			.reposition(event).show(event);
		},
        dayClick: function() { tooltip.hide() },
		eventResizeStart: function() { tooltip.hide() },
		eventDragStart: function() { tooltip.hide() },
		viewDisplay: function() { tooltip.hide() },

	eventSources: [{
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
                var events = [];
                for (var i in response){
                	var dateTime = response[i].TASK_DATE + " " + response[i].START_TIME;
                	events.push({
                		id:    response[i].TASK_ID,
  						title: response[i].TASK_NAME,
                        start: dateTime,
                        description: response[i].TASK_INFO
  					});
                }
                callback(events);
            }
        });
    }
	}],
    eventRender: function(event, element) {
        var contentInfo = '<h3>'+event.title+'</h3>' + 
				'<p><b>Start:</b> '+event.start+'<br />' + 
				event.description + '</p>';
        element.qtip({

            content: contentInfo
        });
    }

    })

});
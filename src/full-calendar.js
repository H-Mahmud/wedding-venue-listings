jQuery(document).ready(function () {
    jQuery('.datetimepicker').datepicker({
        timepicker: false,
        language: 'en',
        range: true,
        multipleDates: true,
        multipleDatesSeparator: " - ",
        minDate: new Date(new Date().setDate(new Date().getDate() + 1))
    });
    jQuery("#add-event").submit(function () {
        alert("Submitted");
        var values = {};
        $.each($('#add-event').serializeArray(), function (i, field) {
            values[field.name] = field.value;
        });
        console.log(
            values
        );
    });




});



/*
(function () {
    'use strict';
    jQuery(function () {
        jQuery('#calendar').fullCalendar({
            themeSystem: 'standard',
            businessHours: false,
            defaultView: 'month',
            // event dragging & resizing
            editable: true,
            // header
            header: {
                left: 'title',
                // center: 'month,agendaWeek,agendaDay',
                right: 'today prev,next'
            },
            events: [{
                title: 'Barber',
                description: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras eu pellentesque nibh. In nisl nulla, convallis ac nulla eget, pellentesque pellentesque magna.',
                start: '2024-12-29',
                end: '2024-12-30',
            },
            {
                title: 'Flight Paris',
                description: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras eu pellentesque nibh. In nisl nulla, convallis ac nulla eget, pellentesque pellentesque magna.',
                start: '2024-12-28',
                end: '2024-12-29',
            }
            ],
            eventRender: function (event, element) {

            },
            dayClick: function (info) {
                // jQuery('#modal-view-event-add').modal();

                console.log(info);

                var currentDate = new Date();
                currentDate.setHours(0, 0, 0, 0); // Reset the time to midnight for a date-only comparison

                // Compare the clicked date with the current date
                if (info.date > currentDate) {
                    // Open the modal if the clicked date is in the future
                    jQuery('#modal-view-event-add').modal();
                } else {
                    // Optionally show an alert if the clicked date is today or in the past
                    alert("You cannot select a past date or today.");
                }
            },
            eventClick: function (event, jsEvent, view) {
                alert('clicked');
                jQuery('.event-title').html(event.title);
                jQuery('.event-body').html(event.description);
                jQuery('.eventUrl').attr('href', event.url);
                jQuery('#modal-view-event').modal();
            },
        })
    });

})(jQuery);

*/

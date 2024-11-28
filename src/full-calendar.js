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
                start: '2024-11-29',
                end: '2024-11-30',
            },
            {
                title: 'Flight Paris',
                description: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras eu pellentesque nibh. In nisl nulla, convallis ac nulla eget, pellentesque pellentesque magna.',
                start: '2024-11-28',
                end: '2024-11-29',
            }
            ],
            eventRender: function (event, element) {

            },
            dayClick: function () {
                jQuery('#modal-view-event-add').modal();
            },
            eventClick: function (event, jsEvent, view) {
                jQuery('.event-title').html(event.title);
                jQuery('.event-body').html(event.description);
                jQuery('.eventUrl').attr('href', event.url);
                jQuery('#modal-view-event').modal();
            },
        })
    });

})(jQuery);

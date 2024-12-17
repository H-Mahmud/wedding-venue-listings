jQuery(document).ready(function($){
    
        var calendarEl = document.getElementById('booking-calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',

            themeSystem: 'standard',
            businessHours: false,
            editable: false,
            headerToolbar: {
                left: 'title',
                right: 'prev,next today',
                center: 'AddEventButton'
                // right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
            },

            customButtons: {
                AddEventButton: {
                    text: 'Add Booking Event',
                    click: function() {
                        jQuery('#modal-add-booking').attr('aria-hidden', 'false').fadeIn();
                        jQuery('#modal-add-booking').focus();

                    }
                }
            },

            dateClick: function(info) {
                var currentDate = new Date();
                currentDate.setHours(0, 0, 0, 0);

                if (info.date > currentDate) {
                    // jQuery('input[name="edate"]').val(new Date(info.date).toISOString().split('T')[0]);
                    jQuery('#modal-view-event-add').modal();
                } else {
                    alert("You cannot select a past date or today.");
                }
            },
            events: [{
                    title: 'Barber',
                    location: 'Lorem ipsum dolor sit amet',
                    start: "2024-12-05T10:00:00",
                    end: "2024-12-05T12:00:00",
                },
                {
                    title: 'Flight Paris',
                    location: 'Lorem ipsum',
                    start: "2024-12-15T10:00:00",
                    end: "2024-12-15T12:00:00",
                }
            ],
            eventContent: function(arg) {
                var event = arg.event;
                var location = event.extendedProps.location ? '<div class="fc-location">' + event.extendedProps.location + '</div>' : '';
                return {
                    html: '<div class="fc-title text-black">' + event.title + '</div>' + location
                };
            },
            eventClick: function(info) {
                const date = new Date(info.event.start);

                jQuery('#modal-view-event .event-title span').html(info.event.title);
                jQuery('#modal-view-event .event-body span').html(info.event.location);
                jQuery('#modal-view-event .event-date span').html(`${date.getDate()}/${date.getMonth() + 1}/${date.getFullYear()}`);

                jQuery('#modal-view-event').addClass('flex');
                jQuery('#modal-view-event').removeClass('hidden');
            },
        });
        calendar.render();


    jQuery(document).ready(function() {
        jQuery('.datetimepicker').datepicker({
            timepicker: false,
            language: 'en',
            range: true,
            multipleDates: true,
            multipleDatesSeparator: " - ",
            minDate: new Date(new Date().setDate(new Date().getDate() + 1))
        });
        // jQuery("#add-event").submit(function () {
        //     alert("Submitted");
        //     var values = {};
        //     $.each($('#add-event').serializeArray(), function (i, field) {
        //         values[field.name] = field.value;
        //     });
        //     console.log(
        //         values
        //     );
        // });
    });
})

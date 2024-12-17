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

        events: function (fetchInfo, successCallback, failureCallback) {
            jQuery.ajax({
                url:  WVL_DATA.ajax_url,
                type: 'GET',
                dataType: 'json',
                data: {
                    action: 'wvl_booked_dates',
                    start_date: fetchInfo.startStr,
                    end_date: fetchInfo.endStr,
                    nonce: WVL_DATA.ajax_nonce
                },
                success: function (response) {
                    if (Array.isArray(response)) {
                        successCallback(response);
                    } else {
                        failureCallback();
                    }
                },
                error: function (xhr, status, error) {
                    console.error('AJAX Error:', status, error);
                    failureCallback();
                }
            });
            
        },
        eventContent: function(arg) {
            var event = arg.event;
            var location = event.extendedProps.location ? '<div style="color: black; font-size: 12px; font-weight: semibold; padding: 3px;">' + event.extendedProps.location_name + '</div>' : '';
            return {
                html: '<div style="color: black; font-size: 16px; font-weight: semibold; padding: 3px;">' + event.title + '</div>' + location
            };
        },
        eventClick: function(info) {
            // const date = new Date(info.event.start);
        },
    });
    calendar.render();


  


    
    $('#modal-add-booking form').on('submit', function (e) {
        e.preventDefault();

        $.ajax({
            url: WVL_DATA.ajax_url,
            type: 'POST',
            data: jQuery(this).serialize() + '&action=wvl_add_new_booking' + '&nonce=' + WVL_DATA.ajax_nonce,
            success: function (response) {

                    var newEvent = {
                        location: response.location,
                        date: response.date,
                        title: response.title
                    };
                    
                    calendar.addEvent(newEvent);
                    alert('Event added successfully!');
                    jQuery('#modal-add-booking').fadeOut();
                    jQuery('#modal-add-booking form')[0].reset(); 
                
            },
            error: function () {
                alert('Error while adding the event.');
            }
        });
    });

    jQuery(document).ready(function() {
        jQuery('.datetimepicker').datepicker({
            timepicker: false,
            language: 'en',
            range: false,
            multipleDates: false,
            multipleDatesSeparator: " - ",
            minDate: new Date(new Date().setDate(new Date().getDate() + 1))
        });
    });
})

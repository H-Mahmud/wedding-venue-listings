<div class=" mb-14">
    <fieldset class="p-5 rounded-xl border-gray-200">
        <legend class="mb-2"><?php _e('Booking Availability', 'wedding-venue-listings'); ?></legend>

        <div class="card">
            <div class="card-body p-0">
                <div id="calendar"></div>
            </div>
        </div>

    </fieldset>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',

            themeSystem: 'standard',
            businessHours: false,
            editable: false,
            headerToolbar: {
                left: 'title',
                right: 'prev,next today',
                // right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
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
                    "start": "2024-12-05T10:00:00",
                    "end": "2024-12-05T12:00:00",
                },
                {
                    title: 'Flight Paris',
                    location: 'Lorem ipsum',
                    "start": "2024-12-15T10:00:00",
                    "end": "2024-12-15T12:00:00",
                }
            ],
            eventContent: function(arg) {
                var event = arg.event;
                var location = event.extendedProps.location ? '<div class="fc-location">' + event.extendedProps.location + '</div>' : '';
                return {
                    html: '<div class="fc-title text-black">' + event.title + '</div>' + location
                };
            }
        });
        calendar.render();
    });
</script>

<div id="modal-view-event" class="modal modal-top fade calendar-modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <h4 class="modal-title"><span class="event-icon"></span><span class="event-title"></span></h4>
                <div class="event-body"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div id="modal-view-event-add" class="modal modal-top fade calendar-modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="add-event">
                <div class="modal-body">
                    <h4>Add Booking Detail</h4>
                    <div class="form-group">
                        <label>Title</label>
                        <input type="text" class="form-control" name="ename">
                    </div>
                    <div class="form-group">
                        <label>Booked Date</label>
                        <input type='text' class="datetimepicker form-control" name="edate">
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <textarea class="form-control" name="edesc"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>


<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/air-datepicker/2.2.3/css/datepicker.css">

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/air-datepicker/2.2.3/js/datepicker.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/air-datepicker/2.2.3/js/i18n/datepicker.en.js"></script>

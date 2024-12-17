jQuery(document).ready(function ($) {
  var calendarEl = document.getElementById("booking-calendar");
  var calendar = new FullCalendar.Calendar(calendarEl, {
    initialView: "dayGridMonth",
    themeSystem: "standard",
    businessHours: false,
    editable: false,
    headerToolbar: {
      left: "title",
      right: "prev,next today",
    },

    dateClick: function (info) {
      var currentDate = new Date();
      currentDate.setHours(0, 0, 0, 0);

      var selectedDate = new Date(info.date);

      if (selectedDate > currentDate) {
        var selectedDateStr = selectedDate
          .toLocaleDateString("en-GB", {
            day: "2-digit",
            month: "2-digit",
            year: "numeric",
          })
          .replace(/\//g, "-");

        $('#modal-add-booking input[name="date"]').val(selectedDateStr);
        $("#modal-add-booking").attr("aria-hidden", "false").fadeIn().focus();
      } else {
        alert("You cannot select a past date or today.");
      }
    },

    events: function (fetchInfo, successCallback, failureCallback) {
      jQuery.ajax({
        url: WVL_DATA.ajax_url,
        type: "GET",
        dataType: "json",
        data: {
          action: "wvl_booked_dates",
          start_date: fetchInfo.startStr,
          end_date: fetchInfo.endStr,
          nonce: WVL_DATA.ajax_nonce,
        },
        success: function (response) {
          if (Array.isArray(response)) {
            successCallback(response);
          } else {
            failureCallback();
          }
        },
        error: function (xhr, status, error) {
          console.error("AJAX Error:", status, error);
          failureCallback();
        },
      });
    },
    eventContent: function (arg) {
      var event = arg.event;
      // var location = event.extendedProps.location
      //   ? '<div style="color: black; font-size: 12px; font-weight: semibold; padding: 3px;">' +
      //     event.extendedProps.location_name +
      //     "</div>"
      //   : "";
      return {
        html:
          '<div style="color: black; font-size: 16px; font-weight: semibold; padding: 6px;">' +
          event.title +
          "</div>",
      };
    },
    eventClick: function (info) {
      // const date = new Date(info.event.start);
      $("#modal-show-booking-details #booking-title").html(info.event.title);
      $("#modal-show-booking-details #booking-location").html(
        info.event.extendedProps.location,
      );
      $("#modal-show-booking-details #booking-date").html(
        info.event.start.toLocaleDateString(),
      );
      $("#modal-show-booking-details #date").val(
        info.event.start.toLocaleDateString(),
      );

      $("#modal-show-booking-details").attr("aria-hidden", "false").fadeIn();
    },
  });
  calendar.render();

  $("#modal-add-booking form").on("submit", function (e) {
    e.preventDefault();

    $.ajax({
      url: WVL_DATA.ajax_url,
      type: "POST",
      data:
        jQuery(this).serialize() +
        "&action=wvl_add_new_booking" +
        "&nonce=" +
        WVL_DATA.ajax_nonce,
      success: function (response) {
        if (response.success) {
          var newEvent = {
            location: response.data.location,
            date: response.data.date,
            title: response.data.title,
          };
          calendar.addEvent(newEvent);
          jQuery("#modal-add-booking").fadeOut();
          jQuery("#modal-add-booking form")[0].reset();
        } else {
          alert(response.data.message);
        }
      },
      error: function () {
        alert("Error while adding the event.");
      },
    });
  });
});

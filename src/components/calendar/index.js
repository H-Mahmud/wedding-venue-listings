import "./calendar.scss";

jQuery(document).ready(function ($) {
  const monthYear = $("#month-year");
  const calendarDates = $("#calendar-dates");
  const today = new Date();
  let currentDate = new Date();

  function renderCalendar(date) {
    const year = date.getFullYear();
    const month = date.getMonth();

    // Set the month and year in the header
    const monthNames = [
      "January",
      "February",
      "March",
      "April",
      "May",
      "June",
      "July",
      "August",
      "September",
      "October",
      "November",
      "December",
    ];
    monthYear.text(`${monthNames[month]} ${year}`);

    // Get the first and last days of the month
    const firstDay = new Date(year, month, 1).getDay();
    const lastDate = new Date(year, month + 1, 0).getDate();

    // Clear the previous dates
    calendarDates.empty();

    // Add empty slots for days before the first day of the month
    for (let i = 0; i < firstDay; i++) {
      calendarDates.append("<span></span>");
    }

    const params = new URLSearchParams(window.location.search);
    const selectedDate = params.get("booking-date");

    // Add the dates of the current month
    for (let i = 1; i <= lastDate; i++) {
      let dateSpan;
      if (isTodayOrEarlier(i, month, year)) {
        dateSpan = $("<span></span>").text(i);
        dateSpan.addClass("disabled");
      } else {
        const params = new URLSearchParams(window.location.search);
        params.delete("booking-date");

        params.append("booking-date", `${year}-${month + 1}-${i}`);
        const newUrl = `${window.location.pathname}?${params.toString()}`;

        dateSpan = $("<a></a>").text(i);
        dateSpan.attr("href", newUrl);
      }
      if (selectedDate === `${year}-${month + 1}-${i}`) {
        dateSpan.addClass("selected");
      }

      if (
        i === today.getDate() &&
        month === today.getMonth() &&
        year === today.getFullYear()
      ) {
        dateSpan.addClass("today");
      }

      calendarDates.append(dateSpan);
    }
  }

  const isTodayOrEarlier = (date, month, year) => {
    const today = new Date();
    const inputDate = new Date(year, month, date);

    return inputDate <= today;
  };

  // Add event listeners for navigation
  $("#prev-month").on("click", function () {
    currentDate.setMonth(currentDate.getMonth() - 1);
    renderCalendar(currentDate);
  });

  $("#next-month").on("click", function () {
    currentDate.setMonth(currentDate.getMonth() + 1);
    renderCalendar(currentDate);
  });

  // Initial render
  renderCalendar(currentDate);
});

document.addEventListener("DOMContentLoaded", function () {
  const calendar = document.getElementById("booking-calendar");
  if (!calendar) return;
  const selectedDatesInput = document.getElementById("selected-dates");
  if (!selectedDatesInput) return;

  const today = new Date();
  let currentYear = today.getFullYear();
  let currentMonth = today.getMonth();
  let selectedDates = new Set();

  const minDate = new Date(
    today.getFullYear(),
    today.getMonth(),
    today.getDate() + 1,
  ); // Minimum date is tomorrow
  const maxDate = new Date(
    today.getFullYear() + 1,
    today.getMonth(),
    today.getDate() - 1,
  ); // Maximum date is the same day next year

  // Helper: Format date to YYYY-MM-DD
  function formatDate(date) {
    const year = date.getFullYear();
    const month = String(date.getMonth() + 1).padStart(2, "0");
    const day = String(date.getDate()).padStart(2, "0");
    return `${year}-${month}-${day}`;
  }

  // Parse existing input dates on page load
  function loadDefaultDates() {
    const inputDates = selectedDatesInput.value.split(",").map((d) => d.trim());
    inputDates.forEach((date) => {
      if (date) selectedDates.add(date);
    });
  }

  function renderCalendar(year, month) {
    calendar.innerHTML = "";

    // Header
    const header = document.createElement("div");
    header.className = "calendar-header";

    const prevButton = document.createElement("span");
    prevButton.className = "fa fa-chevron-left arrow";
    prevButton.addEventListener("click", () => changeMonth(-1));

    const nextButton = document.createElement("span");
    nextButton.className = "fa fa-chevron-right arrow";
    nextButton.addEventListener("click", () => changeMonth(1));

    const monthYearLabel = document.createElement("span");
    const monthNames = [
      "January",
      "February",
      "March",
      "April",
      "May",
      "June",
      "July",
      "August",
      "September",
      "October",
      "November",
      "December",
    ];
    monthYearLabel.textContent = `${monthNames[month]} ${year}`;

    header.appendChild(prevButton);
    header.appendChild(monthYearLabel);
    header.appendChild(nextButton);
    calendar.appendChild(header);

    // Days of the week
    const daysOfWeek = ["S", "M", "T", "W", "T", "F", "S"];
    daysOfWeek.forEach((day) => {
      const dayElement = document.createElement("div");
      dayElement.className = "calendar-day";
      dayElement.textContent = day;
      calendar.appendChild(dayElement);
    });

    // Dates
    const firstDayOfMonth = new Date(year, month, 1).getDay();
    const daysInMonth = new Date(year, month + 1, 0).getDate();

    // Empty spaces for the first week
    for (let i = 0; i < firstDayOfMonth; i++) {
      const emptyCell = document.createElement("div");
      emptyCell.className = "calendar-date disabled";
      calendar.appendChild(emptyCell);
    }

    // Dates of the month
    for (let day = 1; day <= daysInMonth; day++) {
      const date = new Date(year, month, day);
      const dateString = formatDate(date);

      const dateElement = document.createElement("div");
      dateElement.className = "calendar-date";
      dateElement.textContent = day;

      if (date < minDate || date > maxDate) {
        dateElement.classList.add("disabled");
      } else if (selectedDates.has(dateString)) {
        dateElement.classList.add("selected");
      }

      dateElement.addEventListener("click", () =>
        toggleDate(dateString, dateElement),
      );
      calendar.appendChild(dateElement);
    }
  }

  function toggleDate(dateString, element) {
    if (selectedDates.has(dateString)) {
      selectedDates.delete(dateString);
      element.classList.remove("selected");
    } else {
      selectedDates.add(dateString);
      element.classList.add("selected");
    }

    selectedDatesInput.value = Array.from(selectedDates).sort().join(", ");
  }

  function changeMonth(offset) {
    currentMonth += offset;
    if (currentMonth < 0) {
      currentMonth = 11;
      currentYear--;
    } else if (currentMonth > 11) {
      currentMonth = 0;
      currentYear++;
    }

    renderCalendar(currentYear, currentMonth);
  }

  loadDefaultDates();
  renderCalendar(currentYear, currentMonth);
});

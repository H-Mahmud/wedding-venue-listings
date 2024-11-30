import './calendar.css';

jQuery(document).ready(function ($) {
    const monthYear = $('#month-year');
    const calendarDates = $('#calendar-dates');
    const today = new Date();
    let currentDate = new Date();

    function renderCalendar(date) {
        const year = date.getFullYear();
        const month = date.getMonth();

        // Set the month and year in the header
        const monthNames = [
            'January', 'February', 'March', 'April', 'May', 'June',
            'July', 'August', 'September', 'October', 'November', 'December'
        ];
        monthYear.text(`${monthNames[month]} ${year}`);

        // Get the first and last days of the month
        const firstDay = new Date(year, month, 1).getDay();
        const lastDate = new Date(year, month + 1, 0).getDate();

        // Clear the previous dates
        calendarDates.empty();

        // Add empty slots for days before the first day of the month
        for (let i = 0; i < firstDay; i++) {
            calendarDates.append('<span></span>');
        }

        // Add the dates of the current month
        for (let i = 1; i <= lastDate; i++) {
            const dateSpan = $('<span></span>').text(i);

            // Highlight today's date
            if (
                i === today.getDate() &&
                month === today.getMonth() &&
                year === today.getFullYear()
            ) {
                dateSpan.addClass('today');
            }

            calendarDates.append(dateSpan);
        }
    }

    // Add event listeners for navigation
    $('#prev-month').on('click', function () {
        currentDate.setMonth(currentDate.getMonth() - 1);
        renderCalendar(currentDate);
    });

    $('#next-month').on('click', function () {
        currentDate.setMonth(currentDate.getMonth() + 1);
        renderCalendar(currentDate);
    });

    // Initial render
    renderCalendar(currentDate);
});

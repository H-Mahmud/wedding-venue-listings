import './calendar.css';

const monthYear = document.getElementById('month-year');
const calendarDates = document.getElementById('calendar-dates');
const prevMonthButton = document.getElementById('prev-month');
const nextMonthButton = document.getElementById('next-month');

let currentDate = new Date();

function renderCalendar(date) {
    const year = date.getFullYear();
    const month = date.getMonth();

    // Set the month and year in the header
    const monthNames = [
        'January', 'February', 'March', 'April', 'May', 'June',
        'July', 'August', 'September', 'October', 'November', 'December'
    ];
    monthYear.textContent = `${monthNames[month]} ${year}`;

    // Get the first and last days of the month
    const firstDay = new Date(year, month, 1).getDay();
    const lastDate = new Date(year, month + 1, 0).getDate();

    // Clear the previous dates
    calendarDates.innerHTML = '';

    // Add empty slots for days before the first day of the month
    for (let i = 0; i < firstDay; i++) {
        const emptySlot = document.createElement('span');
        calendarDates.appendChild(emptySlot);
    }

    // Add the dates of the current month
    const today = new Date();
    for (let i = 1; i <= lastDate; i++) {
        const dateSpan = document.createElement('span');
        dateSpan.textContent = i;

        // Highlight today's date
        if (
            i === today.getDate() &&
            month === today.getMonth() &&
            year === today.getFullYear()
        ) {
            dateSpan.classList.add('today');
        }

        calendarDates.appendChild(dateSpan);
    }
}

// Add event listeners for navigation
prevMonthButton.addEventListener('click', () => {
    currentDate.setMonth(currentDate.getMonth() - 1);
    renderCalendar(currentDate);
});

nextMonthButton.addEventListener('click', () => {
    currentDate.setMonth(currentDate.getMonth() + 1);
    renderCalendar(currentDate);
});

// Initial render
renderCalendar(currentDate);

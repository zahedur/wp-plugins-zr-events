;(function($) {

})(jQuery);

document.addEventListener('DOMContentLoaded', function() {
    const monthYear = document.getElementById('zr-events-monthYear');
    const daysContainer = document.querySelector('.zr-events-days');
    const prevMonthBtn = document.getElementById('zr-events-prevMonth');
    const nextMonthBtn = document.getElementById('zr-events-nextMonth');

    let currentDate = new Date();

    renderCalendar(currentDate);

    prevMonthBtn.addEventListener('click', () => {
        currentDate = new Date(currentDate.getFullYear(), currentDate.getMonth() - 1, 1);
        renderCalendar(currentDate);
    });

    nextMonthBtn.addEventListener('click', () => {
        currentDate = new Date(currentDate.getFullYear(), currentDate.getMonth() + 1, 1);
        renderCalendar(currentDate);
    });

    function renderCalendar(date) {
        monthYear.textContent = `${date.toLocaleString('default', { month: 'long' })} ${date.getFullYear()}`;

        // Clear existing days
        daysContainer.innerHTML = '';

        const firstDayOfMonth = new Date(date.getFullYear(), date.getMonth(), 1);
        const lastDayOfMonth = new Date(date.getFullYear(), date.getMonth() + 1, 0);
        const daysInMonth = lastDayOfMonth.getDate();

        // Add empty cells for days before the first day of the month
        for (let i = 0; i < firstDayOfMonth.getDay(); i++) {
            const emptyDay = document.createElement('div');
            emptyDay.classList.add('zr-events-day', 'zr-events-empty');
            daysContainer.appendChild(emptyDay);
        }

        // Add days of the month
        for (let i = 1; i <= daysInMonth; i++) {
            const day = document.createElement('div');
            day.classList.add('zr-events-day');


            // Check if the current date corresponds to an event date
            const eventDate = new Date(date.getFullYear(), date.getMonth(), i);
            const eventsOnDate = zrEventData.filter(event => {
                const eventDateObj = new Date(event.date);
                return eventDateObj.toDateString() === eventDate.toDateString();
            });

            console.log(eventsOnDate);
            console.log(eventDate.toDateString());

            if (eventsOnDate.length > 0) {
                day.classList.add('zr-events-event-date');



                // event date text
                const eventDateText = document.createElement('span');
                eventDateText.classList.add('zr-events-event-date-text');
                eventDateText.textContent =  i;
                day.appendChild(eventDateText)

                // events on this date box
                const eventsOnThisDateBox = document.createElement('div');
                eventsOnThisDateBox.classList.add('zr-events-on-this-date-box');

                // each event on this date
                eventsOnDate.forEach(event => {
                    const eventLink = document.createElement('a');
                    eventLink.setAttribute('href', event.event_url);
                    eventLink.textContent = event.event_title;
                    eventsOnThisDateBox.appendChild(eventLink);
                });

                day.appendChild(eventsOnThisDateBox)


            }else {
                day.textContent = i;
            }

            daysContainer.appendChild(day);
        }
    }
});

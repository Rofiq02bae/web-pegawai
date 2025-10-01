import { Calendar } from '@fullcalendar/core'
import dayGridPlugin from '@fullcalendar/daygrid'
import interactionPlugin from '@fullcalendar/interaction'

document.addEventListener('DOMContentLoaded', function () {
    let calendarEl = document.getElementById('calendar')

    if (calendarEl) {
        let events = JSON.parse(calendarEl.getAttribute('data-events') || '[]')

        let calendar = new Calendar(calendarEl, {
            plugins: [dayGridPlugin, interactionPlugin],
            initialView: 'dayGridMonth',
            events: events,
            selectable: true,
            editable: false,
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,dayGridWeek'
            },
        })

        calendar.render()
    }
})

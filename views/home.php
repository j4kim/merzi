<?php $this->layout('layout'); ?>

<div id="calendar"></div>

<script src="https://cdn.jsdelivr.net/npm/dayjs@1/dayjs.min.js"></script>

<script type="module">
    import {
        Calendar
    } from "https://cdn.skypack.dev/@fullcalendar/core@6.1.17";
    import locale from "https://cdn.skypack.dev/@fullcalendar/core@6.1.17/locales/fr-ch";
    import dayGridPlugin from "https://cdn.skypack.dev/@fullcalendar/daygrid@6.1.17";
    import listPlugin from "https://cdn.skypack.dev/@fullcalendar/list@6.1.17";
    import multiMonthPlugin from "https://cdn.skypack.dev/@fullcalendar/multimonth@6.1.17";

    document.addEventListener("DOMContentLoaded", async function() {
        const calendarEl = document.getElementById("calendar");
        const calendar = new Calendar(calendarEl, {
            plugins: [listPlugin, dayGridPlugin, multiMonthPlugin],
            locale,
            headerToolbar: {
                left: "prev,next today",
                center: "title",
                right: "dayGridMonth,listYear,multiMonthYear",
            },
            initialView: 'listYear',
            buttonText: {
                list: 'Liste'
            }
        });
        calendar.render();

        const response = await fetch("/api/calendars");
        const calendars = await response.json();
        calendars.forEach((cal) => {
            cal.freeDates = new Set();
            cal.events.forEach(event => {
                const start = dayjs(event.start);
                const end = dayjs(event.end);
                let d = start;
                while (end.diff(d, 'day')) {
                    cal.freeDates.add(d.format('YYYYMMDD'));
                    d = d.add(1, 'day');
                }
            });
            console.log("free dates for", cal.id, cal.freeDates);
        });
        let commonDates = new Set(calendars[0].freeDates);
        for (let index = 1; index < calendars.length; index++) {
            commonDates = commonDates.intersection(calendars[index].freeDates);
        }
        const sortedDates = Array.from(commonDates).toSorted((x, y) => x - y);
        console.log("common dates", sortedDates);
        let d = dayjs(sortedDates[0]);
        const last = dayjs(sortedDates[sortedDates.length - 1]);
        const events = [];
        let event = null;
        while (last.diff(d, 'day') > -2) {
            if (commonDates.has(d.format('YYYYMMDD'))) {
                if (!event) {
                    event = {
                        start: d.toDate(),
                        allDay: true,
                        title: "Dispo",
                    };
                }
            } else if (event) {
                event.end = d.toDate();
                events.push(event);
                event = null;
            }
            d = d.add(1, 'day');
        }
        calendar.addEventSource({
            events
        });
    });
</script>
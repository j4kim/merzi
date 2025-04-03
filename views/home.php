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
            calendar.addEventSource(cal);
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
            console.log(cal.freeDates);
        });
        let commonDates = new Set(calendars[0].freeDates);
        for (let index = 1; index < calendars.length; index++) {
            commonDates = commonDates.intersection(calendars[index].freeDates);
        }
        console.log(commonDates);
    });
</script>
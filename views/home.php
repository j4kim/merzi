<?php $this->layout('layout'); ?>

<div id="calendar"></div>

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
        const eventSources = await response.json();
        eventSources.forEach((src) => calendar.addEventSource(src));
    });
</script>
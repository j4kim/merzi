<?php $this->layout('layout'); ?>

<div id="calendar"></div>

<script type="module">
    import {
        Calendar
    } from "https://cdn.skypack.dev/@fullcalendar/core@6.1.17";
    import dayGridPlugin from "https://cdn.skypack.dev/@fullcalendar/daygrid@6.1.17";
    import timeGridPlugin from "https://cdn.skypack.dev/@fullcalendar/timegrid@6.1.17";
    import listPlugin from "https://cdn.skypack.dev/@fullcalendar/list@6.1.17";
    import multiMonthPlugin from "https://cdn.skypack.dev/@fullcalendar/multimonth@6.1.17";

    document.addEventListener("DOMContentLoaded", function() {
        const calendarEl = document.getElementById("calendar");
        const calendar = new Calendar(calendarEl, {
            plugins: [dayGridPlugin, timeGridPlugin, listPlugin, multiMonthPlugin],
            headerToolbar: {
                left: "prev,next today",
                center: "title",
                right: "dayGridMonth,timeGridWeek,timeGridDay,listWeek,multiMonthYear",
            },
        });
        calendar.render();
    });
</script>
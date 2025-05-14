<?php $this->layout('layout'); ?>

<div id="calendar" class="loading"></div>

<?php $base = J4kim\Merzi\Config::base(); ?>

<div class="mt-2 flex justify-between">
    <a href="<?= $base ?>settings" class="hover:opacity-50">⚙ Réglages</a>
    <a href="<?= $base ?>fresh" class="hover:opacity-50">🔄 Rafraichir</a>
</div>

<style>
    .loading .fc-toolbar-title {
        color: transparent;
        background-image: url(https://media.tenor.com/yfaFcsYBgqMAAAAi/loading-gif.gif);
        background-size: 30px;
        background-repeat: no-repeat;
        background-position: center;
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/dayjs@1/dayjs.min.js"></script>

<script type="module">
    import {
        Calendar
    } from "https://cdn.skypack.dev/@fullcalendar/core@6.1.17";
    import locale from "https://cdn.skypack.dev/@fullcalendar/core@6.1.17/locales/fr-ch";
    import dayGridPlugin from "https://cdn.skypack.dev/@fullcalendar/daygrid@6.1.17";
    import listPlugin from "https://cdn.skypack.dev/@fullcalendar/list@6.1.17";
    import multiMonthPlugin from "https://cdn.skypack.dev/@fullcalendar/multimonth@6.1.17";

    const colors = [
        "#55cc99",
        "#cc9955",
        "#9955cc",
        "#5599cc",
        "#99cc55",
        "#cc5599",
    ];

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
            },
            height: '95dvh',
        });
        calendar.render();

        var response, json

        try {
            response = await fetch("<?= $base ?>api/calendars");
            if (!response.ok) {
                throw new Error(`Response status: ${response.status}`);
            }
            json = await response.json();
        } catch (error) {
            return console.error("Fetching calendars failed.", error.message);
        } finally {
            calendarEl.classList.remove('loading');
        }

        const {
            calendars,
            showIndividual,
            showCommon
        } = json


        calendars.forEach((cal, index) => {
            if (showIndividual) {
                cal.color = colors[index % colors.length]
                calendar.addEventSource(cal);
            }
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

        if (showCommon) {
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
        }
    });
</script>
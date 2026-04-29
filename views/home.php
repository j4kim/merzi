<?php $this->layout('layout'); ?>

<div id="calendar" class="loading"></div>

<div class="mt-2 flex justify-between">
    <a href="<?= J4kim\Merzi\Config::base() ?>settings" class="hover:opacity-50">⚙ Réglages</a>
</div>

<?php $this->start('scripts') ?>
    <style>
        .loading .fc-toolbar-title {
            color: transparent;
            background-image: url(https://media.tenor.com/yfaFcsYBgqMAAAAi/loading-gif.gif);
            background-size: 30px;
            background-repeat: no-repeat;
            background-position: center;
        }
    </style>

    <script src="lib//dayjs.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@7.0.0-rc.2/all.global.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@7.0.0-rc.2/themes/monarch/global.js"></script>

    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@7.0.0-rc.2/skeleton.css' rel='stylesheet' />
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@7.0.0-rc.2/themes/monarch/theme.css' rel='stylesheet' />
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@7.0.0-rc.2/themes/monarch/palettes/purple.css' rel='stylesheet' />

    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@7.0.0-rc.2/locales/fr-ch.global.js'></script>

    <script>
        __BASE__ = "<?= J4kim\Merzi\Config::base() ?>";
    </script>

    <script type="module" src="home.js"></script>
<?php $this->stop() ?>
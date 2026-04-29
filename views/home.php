<?php $this->layout('layout'); ?>

<div id="calendar" class="loading"></div>

<?php $base = J4kim\Merzi\Config::base(); ?>

<div class="mt-2 flex justify-between">
    <a href="<?= $base ?>settings" class="hover:opacity-50">⚙ Réglages</a>
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

<script src="lib//dayjs.min.js"></script>
<script src='lib/fullcalendar/index.global.min.js'></script>
<script src='lib/fullcalendar/fr-ch.global.min.js'></script>
<script>
    __BASE__ = "<?= $base ?>";
</script>
<script type="module" src="home.js"></script>
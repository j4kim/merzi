<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>merzi</title>
    <script type="importmap">
        {
            "imports": {
                "@fullcalendar/core": "https://cdn.skypack.dev/@fullcalendar/core@6.1.17",
                "@fullcalendar/daygrid": "https://cdn.skypack.dev/@fullcalendar/daygrid@6.1.17",
                "@fullcalendar/timegrid": "https://cdn.skypack.dev/@fullcalendar/timegrid@6.1.17",
                "@fullcalendar/list": "https://cdn.skypack.dev/@fullcalendar/list@6.1.17",
                "@fullcalendar/multimonth": "https://cdn.skypack.dev/@fullcalendar/multimonth@6.1.17"
            }
        }
    </script>
    <script type="module" src="app.js"></script>
    <link rel="stylesheet" href="output.css" />
</head>

<body>
    <main>
        <?= $this->section('content') ?>
    </main>
</body>

</html>
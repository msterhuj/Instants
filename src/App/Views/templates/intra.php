<?php
use Core\Controller\Controller;
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>{{ TITLE }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php if (isset($_COOKIE['THEME']) && $_COOKIE['THEME'] == "dark")
        echo '<link rel="stylesheet" href="https://bootswatch.com/5/darkly/bootstrap.min.css">';
    else
        echo '<link rel="stylesheet" href="https://bootswatch.com/5/flatly/bootstrap.min.css">';
    ?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
    {{ CSS }}
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <a class="navbar-brand" href="<?php echo Controller::getUrl("home") ?>">Instants</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbar">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" href="<?php echo Controller::getUrl("home") ?>">Retouner au post</a>
            </li>
        </ul>
    </div>
</nav>

{{ SYSTEM_CONTENT }}

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
{{ JS }}
</body>
</html>
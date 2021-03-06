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

    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-lg-4"></div>
            <div class="col-sm-12 col-lg-4">{{ SYSTEM_CONTENT }}</div>
        </div>
        <div class="col-sm-12 col-lg-4"></div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    {{ JS }}
    </body>
</html>
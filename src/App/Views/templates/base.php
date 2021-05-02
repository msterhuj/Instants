<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <title>{{ TITLE }}</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <?php if (isset($_COOKIE['THEME']) && $_COOKIE['THEME'] == "dark")
            echo '<link rel="stylesheet" href="https://bootswatch.com/4/darkly/bootstrap.min.css">';
        else
            echo '<link rel="stylesheet" href="https://bootswatch.com/4/flatly/bootstrap.min.css">';
        ?>

    </head>
    <body>
    {{ SYSTEM_CONTENT }}
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/js/theme.js"></script>
    </body>
</html>
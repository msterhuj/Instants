<?php
use Core\Controller\Controller;
use App\Models\User;
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

        <div class="container-fluid">
            <div class="row">
                <!-- Search post -->
                <div class="find col-sm-3">
                    <div class="position-relative">
                        <div class="position-absolute top-0 start-0">
                            <form>
                                <div class="input-group mb-3">
                                    <input class="form-control" list="datalistOptions" id="dataList" placeholder="Type to search...">
                                    <datalist id="datalistOptions">
                                        <option value="$wellcome">
                                        <option value="Gabin">
                                    </datalist>
                                    <button class="btn btn-outline-secondary" type="submit">
                                        <i class="bi-search"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Scroll infinitely -->
                {{ SYSTEM_CONTENT }}

                <!-- Profile -->
                <div class="profile col-sm-3">
                    <div class="position-relative">
                        <div class="position-absolute top-0 end-0">

                            <a onclick="switchTheme()"><i id="theme-icon" class=""></i></a>

                            <?php if (Controller::isGuest()) { ?>
                                <!-- Is not logged -->
                                <a class="btn btn-outline-info" href="<?php echo Controller::getUrl("login") ?>">Login</a>
                                <a class="btn btn-info" href="<?php echo Controller::getUrl("signup") ?>">Signup</a>
                            <?php } else {
                                $user = User::getFromSession();
                                ?>
                                <!-- Is logged -->
                                <div class="dropdown text-end">
                                    <a href="#" class="d-block link-dark text-decoration-none dropdown-toggle" id="dropdownUser" data-bs-toggle="dropdown" aria-expanded="false">
                                        <img src="<?php echo $user->getPicture() ?>" alt="mdo" width="32" height="32" class="rounded-circle">
                                    </a>
                                    <ul class="dropdown-menu text-small" aria-labelledby="dropdownUser">
                                        <li><a class="dropdown-item" href="<?php echo Controller::getUrl("profile", User::getFromSession()->getUsername()) ?>">Profile</a></li>
                                        <li><a class="dropdown-item" href="<?php echo Controller::getUrl("settings") ?>">Settings</a></li>
                                        <?php if ($user->hasRole("ADMIN")) { ?>
                                            <li><hr class="dropdown-divider"></li>
                                            <li><a class="dropdown-item" href="<?php echo Controller::getUrl("admin") ?>">Admin</a></li>
                                        <?php } ?>
                                        <li><hr class="dropdown-divider"></li>
                                        <li><a class="dropdown-item" href="<?php echo Controller::getUrl("logout") ?>">Sign out</a></li>
                                    </ul>
                                </div>
                            <?php } ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
        {{ JS }}
    </body>
</html>
<?php use Core\Controller\Controller; ?>
<div class="text-center">
    <div class="card bg-light shadow border-0">
        <div class="card-body">
            <h2>Instants</h2>
            <h3>All now !</h3>
            <hr class="my-4">
            <h4>Please sign up</h4>

            <?php if (isset($_SESSION["ERROR"])) { ?>
                <div class="text-center text-muted mb-4">
                    <div class="alert alert-danger">
                        <ul>
                            <?php foreach ($_SESSION["ERROR"] as $value) {
                                echo '<li>'. $value;
                            } ?>
                        </ul>
                    </div>
                </div>
            <?php } ?>

            <form method="post" action="/settings/">
                <label for="username" class="control-label">Username</label>
                <div class="input-group mb-3">
                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                    <input class="form-control" id="username" name="username" type="text">
                </div>

                <label for="email" class="control-label">Email</label>
                <div class="input-group mb-3">
                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                    <input class="form-control" id="email" name="email" type="email">
                </div>

                <label for="pass" class="control-label">Password</label>
                <div class="input-group mb-3">
                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                    <input class="form-control" id="pass" name="pass" type="password">
                </div>

                <label for="vpass" class="control-label">Password</label>
                <div class="input-group mb-3">
                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                    <input class="form-control" id="vpass" name="vpass" type="password">
                </div>

                <input name="csrf" value="{{ CSRF }}" hidden>
                <button class="btn btn-primary" type="submit">Register !</button>
                <br>
                <a href="<?php echo Controller::getUrl("login") ?>" class="btn btn-link">Or register</a>
            </form>
            <p class="lead">By Instants.dev Teams</p>
        </div>
    </div>
</div>
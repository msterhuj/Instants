<div class="container">
    <div class="row">
        <div class="col"></div>
        <div class="col">
            <div class="text-center">
            <div class="card bg-light shadow border-0" style="width: 20rem;">
                <div class="card-body">
                    <h2>Instants</h2>
                    <h3>All now !</h3>
                    <hr class="my-4">
                    <h4>Please sign in</h4>

                    <?php if (isset($_SESSION["ERROR"])) {?>
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

                    <form method="post" action="/login">
                        <label for="username" class="control-label">Username</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                            <input class="form-control" id="username" name="username" type="text">
                        </div>
                        <label for="pass" class="control-label">Password</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text"><i class="fas fa-lock"></i></span>
                            <input class="form-control" id="pass" name="pass" type="password">
                        </div>
                        <input name="csrf" value="{{ CSRF }}" hidden>
                        <button class="btn btn-primary" type="submit">Login</button>
                    </form>
                    <p class="lead">By Instants.dev Teams</p>
                </div>
            </div>
        </div>
        </div>
        <div class="col"></div>
    </div>
</div>
<link rel="stylesheet" href="/css/auth.css">
<div class="container">
    <div class="row justify-content-center">
        <div class="text-center login-box">
            <div class="card bg-light shadow border-0">
                <div class="card-body">
                    <h2>Instants</h2>
                    <h3>All now !</h3>
                    <hr class="my-4">
                    <h4>Please sign in</h4>

                    <div class="text-center text-muted mb-4">
                        <div class="alert alert-danger">
                            <p>add error here if is set</p>
                        </div>
                    </div>

                    <form method="post" action="/login">

                        <div class="form-group">
                            <label for="username" class="control-label">Username</label>
                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                                    </div>
                                    <input class="form-control" id="username" name="username" type="text">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="pass" class="control-label">Password</label>
                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                    </div>
                                    <input class="form-control" id="pass" name="pass" type="password">
                                </div>
                            </div>
                        </div>

                        <input name="csrf" value="{{ CSRF }}" hidden>
                        <button class="btn btn-primary" type="submit">Login</button>
                    </form>
                    <p class="lead">By Instants.dev Teams</p>
                </div>
            </div>
        </div>
    </div>
</div>
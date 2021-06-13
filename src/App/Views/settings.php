<?php $user = \App\Models\User::getFromSession() ?>
<div class="container">
    <div class="card shadow">
        <form method="post" action="/settings">
            <label for="username" class="control-label">Username</label>
            <div class="input-group mb-3">
                <span class="input-group-text"><i class="fas fa-user"></i></span>
                <input class="form-control" id="username" name="username" type="text" value="<?php echo $user->getUsername() ?>">
            </div>

            <label for="email" class="control-label">Email</label>
            <div class="input-group mb-3">
                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                <input class="form-control" id="email" name="email" type="email" value="<?php echo $user->getEmail() ?>">
            </div>

            <label for="desc" class="control-label">Description</label>
            <div class="input-group mb-3">
                <span class="input-group-text"><i class="fas fa-book"></i></span>
                <input class="form-control" id="desc" name="desc" type="text" value="<?php echo $user->getDescription() ?>">
            </div>

            <input name="csrf" value="{{ CSRF }}" hidden>
            <button class="btn btn-primary" type="submit">Update !</button>
        </form>
    </div>
</div>
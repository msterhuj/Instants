<?php use App\Models\User; use Core\Controller\Controller; ?>
<div class="container-lg">
    <div class="card shadow">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">Username</th>
                    <th scope="col">Email</th>
                    <th scope="col">Activated</th>
                    <th scope="col">Role</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach (User::getAll() as $user)  { ?>
                    <tr>
                        <td>
                            <img src="<?php echo $user->getPicture() ?>" alt="mdo" width="32" height="32" class="rounded-circle">
                            <a href="<?php echo Controller::getUrl("profile", $user->getUsername()) ?>"><?php echo $user->getUsername() ?></a>
                        </td>
                        <td><?php echo $user->getEmail() ?></td>
                        <td>
                            <?php echo ($user->emailValidated()) ? '<span class="badge bg-success">Yes</span>' : '<span class="badge bg-warning">No</span>' ?>
                        </td>
                        <td>
                            <?php
                                if (in_array('USER', $user->getRoles())) echo '<span class="badge bg-primary text-light">User</span>';
                                if (in_array('ADMIN', $user->getRoles())) echo '<span class="badge bg-warning">Admin</span>';
                                if (in_array('BANNED', $user->getRoles())) echo '<span class="badge bg-danger">Banned</span>';
                            ?>
                        </td>
                        <td>
                            <form method="post" action="<?php echo $user->getId(); ?>">
                                <input type="text" name="csrf" value="{{ CSRF }}" hidden>
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
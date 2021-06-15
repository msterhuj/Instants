<?php use App\Models\Report; use Core\Controller\Controller; ?>
<div class="container-lg">
    <div class="card shadow">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">Username</th>
                    <th scope="col">Content</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    foreach (Report::getAll() as $report)  {
                        $user = \App\Models\User::loadBy("id", $report->getAuthorId());
                        $post = \App\Models\Post::loadBy("id", $report->getPost());
                ?>
                    <tr>
                        <td>
                            <img src="<?php echo $user->getPicture() ?>" alt="mdo" width="32" height="32" class="rounded-circle">
                            <a href="<?php echo Controller::getUrl("profile", $user->getUsername()) ?>"><?php echo $user->getUsername() ?></a>
                        </td>
                        <td><?php echo $post->getContent() ?></td>
                        <td>
                            <a class="btn btn-primary" href="<?php echo Controller::getUrl("admin_user_delete", $user->getId()) ?>">Delete</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
<div class="posts col-sm-6">
    <div class="card">
        <a href="<?php echo Core\Controller\Controller::getUrl("profile") ?>{{ USER }}" class="d-block link-dark">
            <img src="{{ PICTURE }}" alt="mdo" width="64" height="64" class="rounded-circle">
            {{ USER }}
        </a>
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="post-tab" data-bs-toggle="tab" data-bs-target="#post" type="button" role="tab" aria-controls="post" aria-selected="true">Post</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="reply-tab" data-bs-toggle="tab" data-bs-target="#reply" type="button" role="tab" aria-controls="reply" aria-selected="false">Reply</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="like-tab" data-bs-toggle="tab" data-bs-target="#like" type="button" role="tab" aria-controls="like" aria-selected="false">Like</button>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="post" role="tabpanel" aria-labelledby="post-tab">
                <!-- post created by this user -->
                {{ POST }}
            </div>
            <div class="tab-pane fade show active" id="reply" role="tabpanel" aria-labelledby="reply-tab">
                <!-- post created by this user -->
                {{ REPLY }}
            </div>
            <div class="tab-pane fade" id="like" role="tabpanel" aria-labelledby="like-tab">
                <!-- post liked by this fuking user -->
                {{ LIKE }}
            </div>
        </div>
    </div>
</div>
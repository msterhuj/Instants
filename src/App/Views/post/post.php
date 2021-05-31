<div class="card">
    <div class="card-header">
        <a href="<?php echo Core\Controller\Controller::getUrl("profile") ?>{{ AUTHOR }}" class="d-block link-dark">
            <img src="{{ PICTURE }}" alt="mdo" width="32" height="32" class="rounded-circle">
            {{ AUTHOR }}
        </a>

    </div>
    <div class="card-body">
        <p class="card-text">{{ CONTENT }}</p>
    </div>
    <div class="card-footer">
        <a><i class="fas fa-heart"></i></a>
    </div>
</div>
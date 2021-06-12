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
        <div class="container">
            <div class="row">
                <div class="col-xs-2 col-sm-1">
                    <a><i class="fas fa-heart"></i></a>
                </div>
                <div class="col-xs-10 col-sm-11">
                    <div class="input-group mb-3">
                        <textarea id="post-data-reply-{{ ID }}" class="form-control" aria-label="With textarea"></textarea>
                        <button class="btn btn-outline-secondary" onclick="newReply({{ ID }})">
                            <i class="far fa-paper-plane"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="row">
                {{ REPLY }}
            </div>
        </div>
    </div>
</div>
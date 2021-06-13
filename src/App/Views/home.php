<div class="posts col-sm-6">
    <?php use Core\Controller\Controller;

    if (!Controller::isGuest()) { ?>
        <div class="new-post">
            <div class="card">
                <div class="input-group mb-3">
                    <textarea id="post-data" class="form-control" aria-label="With textarea"></textarea>
                    <button class="btn btn-outline-secondary" onclick="newPost()">
                        <i class="far fa-paper-plane"></i>
                    </button>
                </div>
            </div>
        </div>
    <?php } ?>
    <div id="post" class="posts-list"></div>
    <button class="btn btn-primary" onclick="getNextPost()">
        <i class="fas fa-search"></i>Actualiser
    </button>
</div>
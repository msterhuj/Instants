<?php use Core\Router\Route; ?>
<div class="container">
    <div class="row">
        <div class="col-sm-4 col-md-3"></div>
        <div class="col-sm-8 col-md-9">
            <div class="card shadow" style="height: 80vh">
                <div class="card-header">
                    <a href="<?php echo Core\Controller\Controller::getUrl("profile") ?>{{ AUTHOR }}" class="d-block link-dark">
                        <img src="{{ PICTURE }}" alt="mdo" width="32" height="32" class="rounded-circle">
                        <input id="author" value="{{ AUTHOR }}" hidden>
                        {{ AUTHOR }}
                    </a>
                </div>
                <div id="message_list" class="card-body" style="overflow-y: scroll; height:400px;"></div>
                <div class="card-footer">
                    <div class="input-group mb-3">
                        <input hidden id="msgid" value="<?php echo Route::getRouteParam() ?>">
                        <input id="msgdata" type="text" class="form-control">
                        <button class="btn btn-outline-secondary" onclick="sendMSGAJAX(<?php echo Route::getRouteParam() ?>)">
                            <i class="far fa-paper-plane"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
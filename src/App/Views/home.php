<div class="container-fluid">
    <div class="row">
        <!-- Search post -->
        <div class="find col-sm-3">
            <form>
                <div class="mb-3">
                    <label for="dataList" class="form-label">Search</label>
                    <input class="form-control" list="datalistOptions" id="dataList" placeholder="Type to search...">
                    <datalist id="datalistOptions">
                        <option value="$wellcome">
                        <option value="Gabin">
                    </datalist>
                    <button type="submit"><i class="bi-search"></i></button>
                </div>
            </form>
        </div>
        <!-- Scroll infinitely -->
        <div class="posts col-sm-6"></div>
        <!-- Profile -->
        <div class="profile col-sm-3"></div>
    </div>
</div>
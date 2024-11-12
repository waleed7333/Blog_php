
<!-- v_blog/app/views/admin/overview.php -->

<!-- Overview -->
<div class="container mt-5">
    <h3 class="text-center mb-4 text-secondary">Overview</h3>
    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card bg-info text-white text-center">
                <div class="card-body">
                    <h4 class="card-title">Total Users</h4>
                    <p class="display-5"><?= $user_count ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card bg-success text-white text-center">
                <div class="card-body">
                    <h4 class="card-title">Total Posts</h4>
                    <p class="display-5"><?= $post_count ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card bg-warning text-white text-center">
                <div class="card-body">
                    <h4 class="card-title">Total Comments</h4>
                    <p class="display-5"><?= $comment_count ?></p>
                </div>
            </div>
        </div>
    </div>
</div>

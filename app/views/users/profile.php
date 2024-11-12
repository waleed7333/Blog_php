<?php
include '../app/views/layout/header.php';
include '../app/views/layout/navbar.php';
?>

<div class="container py-5">
    <!-- Profile Header -->
    <div class="card shadow-lg border-0 mb-4">
        <div class="card-body p-4">
            <div class="row align-items-center">
                <div class="col-lg-3 text-center">
                    <div class="position-relative d-inline-block mb-3">
                        <img src="<?php echo htmlspecialchars(($base_url . '/public/Icons/' . $user['profile_picture'])?? 'default-avatar.png'); ?>"
                            alt="Profile Picture"
                            class="rounded-circle img-thumbnail shadow-sm"
                            style="width: 200px; height: 200px; object-fit: cover;">
                        <?php if ($user['is_admin']): ?>
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                Admin
                                <span class="visually-hidden">Admin User</span>
                            </span>
                        <?php endif; ?>
                    </div>

                    <?php if ($isCurrentUser): ?>
                        <div class="d-grid gap-2">
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editProfileModal">
                                <i class="bi bi-pencil-square"></i> Edit Profile
                            </button>
                            <button class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#changePasswordModal">
                                <i class="bi bi-key"></i> Change Password
                            </button>
                        </div>
                    <?php elseif ($_SESSION['is_admin'] && !$isCurrentUser): ?>
                        <div class="d-grid gap-2">
                            <?php if ($user['is_admin']): ?>
                                <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#downgradeToUserModal">
                                    <i class="bi bi-arrow-down-circle"></i> Downgrade to User
                                </button>
                            <?php else: ?>
                                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#upgradeToAdminModal">
                                    <i class="bi bi-arrow-up-circle"></i> Upgrade to Admin
                                </button>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="col-lg-9">
                    <h2 class="display-6 fw-bold mb-3"><?php echo htmlspecialchars($user['username']); ?></h2>
                    <div class="d-flex flex-column gap-2 text-muted">
                        <p class="mb-1">
                            <i class="bi bi-envelope-fill me-2"></i>
                            <?php echo htmlspecialchars($user['email']); ?>
                        </p>
                        <p class="mb-1">
                            <i class="bi bi-calendar-check-fill me-2"></i>
                            Member since: <?php echo date('F d, Y', strtotime($user['created_at'])); ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm text-center h-100">
                <div class="card-body">
                    <i class="bi bi-file-text display-4 text-primary mb-2"></i>
                    <h3 class="display-5 fw-bold text-primary"><?php echo $postsCount; ?></h3>
                    <p class="text-muted mb-0">Posts</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm text-center h-100">
                <div class="card-body">
                    <i class="bi bi-chat-dots display-4 text-success mb-2"></i>
                    <h3 class="display-5 fw-bold text-success"><?php echo $commentsCount; ?></h3>
                    <p class="text-muted mb-0">Comments</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm text-center h-100">
                <div class="card-body">
                    <i class="bi bi-heart display-4 text-danger mb-2"></i>
                    <h3 class="display-5 fw-bold text-danger"><?php echo $likesCount ?? 0; ?></h3>
                    <p class="text-muted mb-0">Likes</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Posts -->
    <div class="card shadow-sm border-0">
        <div class="card-header bg-transparent border-0">
            <h3 class="mb-0">Recent Posts</h3>
        </div>
        <div class="card-body">
            <div class="row g-4">
                <?php foreach ($latest_posts as $post): ?>
                    <div class="col-md-6">
                        <div class="card h-100 border-0 shadow-sm">
                            <?php if (!empty($post['image'])): ?>
                                <img src="<?php echo htmlspecialchars($base_url . '/public/images/' . $post['image']); ?>" 
                                     class="card-img-top" 
                                     alt="Post Image"
                                     style="height: 200px; object-fit: cover;">
                            <?php endif; ?>
                            <div class="card-body">
                                <h5 class="card-title fw-bold mb-3">
                                    <?php echo htmlspecialchars($post['title']); ?>
                                </h5>
                                <p class="card-text text-muted">
                                    <?php echo htmlspecialchars(substr($post['content'], 0, 150)) . '...'; ?>
                                </p>
                            </div>
                            <div class="card-footer bg-transparent border-0">
                                <div class="d-flex justify-content-between align-items-center">
                                    <small class="text-muted">
                                        <i class="bi bi-calendar me-1"></i>
                                        <?php echo date('M d, Y', strtotime($post['created_at'])); ?>
                                    </small>
                                    <a href="./posts/show/<?php echo $post['id']; ?>" 
                                       class="btn btn-outline-primary btn-sm">
                                        Read More
                                        <i class="bi bi-arrow-right ms-1"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<!-- Modals -->
<!-- Edit Profile Modal -->
<div class="modal fade" id="editProfileModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">Edit Profile</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="editProfileForm" action="./profile/<?php echo $user['id']; ?>" method="POST" enctype="multipart/form-data">
                    <div class="text-center mb-4">
                        <img src="<?php echo !empty($user['profile_picture']) ? htmlspecialchars($user['profile_picture']) : 'default-profile.png'; ?>" 
                             alt="Profile Picture" 
                             class="rounded-circle img-thumbnail mb-3"
                             style="width: 120px; height: 120px; object-fit: cover;">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-person"></i></span>
                            <input type="text" class="form-control" name="username" 
                                   value="<?php echo htmlspecialchars($user['username']); ?>">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                            <input type="email" class="form-control" name="email" 
                                   value="<?php echo htmlspecialchars($user['email']); ?>">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">New Profile Picture</label>
                        <input type="file" class="form-control" name="profile_picture">
                    </div>
                </form>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" form="editProfileForm" class="btn btn-primary">Save Changes</button>
            </div>
        </div>
    </div>
</div>

<!-- Change Password Modal -->
<div class="modal fade" id="changePasswordModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">Change Password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="changePasswordForm" action="./changePassword/<?php echo $user['id']; ?>" method="POST">
                    <div class="mb-3">
                        <label class="form-label">Current Password</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-lock"></i></span>
                            <input type="password" class="form-control" name="current_password" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">New Password</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-key"></i></span>
                            <input type="password" class="form-control" name="new_password" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Confirm New Password</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-key-fill"></i></span>
                            <input type="password" class="form-control" name="confirm_password" required>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" form="changePasswordForm" class="btn btn-primary">Change Password</button>
            </div>
        </div>
    </div>
</div>

<!-- Admin Modals -->
<!-- Upgrade to Admin Modal -->
<div class="modal fade" id="upgradeToAdminModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">Upgrade to Admin</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-4">
                    <i class="bi bi-arrow-up-circle display-1 text-success"></i>
                </div>
                <p class="text-center">
                    Are you sure you want to upgrade <strong><?php echo htmlspecialchars($user['username']); ?></strong> to admin?
                </p>
                <p class="text-center text-muted">
                    Email: <?php echo htmlspecialchars($user['email']); ?>
                </p>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                <a href="./upgradeAdmin/<?php echo $user['id']; ?>" class="btn btn-success">Confirm Upgrade</a>
            </div>
        </div>
    </div>
</div>

<!-- Downgrade to User Modal -->
<div class="modal fade" id="downgradeToUserModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0">
            <div class="modal-header bg-warning">
                <h5 class="modal-title">Downgrade to User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-4">
                    <i class="bi bi-arrow-down-circle display-1 text-warning"></i>
                </div>
                <p class="text-center">
                    Are you sure you want to downgrade <strong><?php echo htmlspecialchars($user['username']); ?></strong> to a regular user?
                </p>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                <a href="./downgradeAdmin/<?php echo $user['id']; ?>" class="btn btn-warning">Confirm Downgrade</a>
            </div>
        </div>
    </div>
</div>

<?php
include '../app/views/layout/footer.php';
?>
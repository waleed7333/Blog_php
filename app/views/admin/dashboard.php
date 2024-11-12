<?php 
// v_blog/app/views/admin/dashboard.php  2
?>

<?php
require_once "../app/views/layout/header.php"; 
require_once "../app/views/layout/navbar.php"; 
?>

    <div class="container mt-5">
        <h1 class="text-center">Admin Dashboard</h1>

        <!-- Tabs Navigation -->
        <ul class="nav nav-tabs mt-4" id="adminTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="dashboard-tab" data-bs-toggle="tab" data-bs-target="#dashboard" type="button" role="tab" aria-controls="dashboard" aria-selected="true">Overview</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="manageUsers-tab" data-bs-toggle="tab" data-bs-target="#manageUsers" type="button" role="tab" aria-controls="manageUsers" aria-selected="false">Manage Users</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="managePosts-tab" data-bs-toggle="tab" data-bs-target="#managePosts" type="button" role="tab" aria-controls="managePosts" aria-selected="false">Manage Posts</button>
            </li>
        </ul>

        <!-- Tab Contents -->
        <div class="tab-content mt-3" id="adminTabsContent">
            <div class="tab-pane fade show active" id="dashboard" role="tabpanel" aria-labelledby="dashboard-tab">
                <?php include_once __DIR__ . '/overview.php'; ?>
            </div>
            <div class="tab-pane fade" id="manageUsers" role="tabpanel" aria-labelledby="manageUsers-tab">
                <?php include_once __DIR__ . '/manage-users.php'; ?>
            </div>
            <div class="tab-pane fade" id="managePosts" role="tabpanel" aria-labelledby="managePosts-tab">
                <?php include_once __DIR__ . '/manage_posts.php'; ?>
            </div>
        </div>
    </div>



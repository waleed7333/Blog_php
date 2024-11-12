<?php
// v_blog/app/views/layout/navbar.php
?>
<?php
// v_blog/app/views/layout/navbar.php
include_once __DIR__ . '/header.php';
$defaultProfileIcon = $base_url . '/public/Icons/person_icon.png';
?>

<!-- Navbar Section -->
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm" style="border-bottom: 2px solid #e1e5e9;">
    <div class="container">
        <a class="navbar-brand fw-bold" href="./" style="color: #2c3e50; font-family: 'Poppins', sans-serif;">
            <i class="bi bi-pen"></i> Waleed Blog
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <!-- Left Links -->
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link" href="./" style="color: #34495e;">Home</a>
                </li>
                <li class="nav-item dropdown">
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Posts
                        </a>
                        <ul class="dropdown-menu shadow" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="./posts">All Posts</a></li>
                            <li><a class="dropdown-item" href="./posts/create">Create Post</a></li>
                        </ul>
                    <?php endif; ?>
                </li>
            </ul>

            <!-- Search Bar -->
            <form class="d-flex mx-3" action="./search" method="get">
                <div class="input-group">
                    <input class="form-control" type="search" placeholder="Search" aria-label="Search" name="query" style="border-radius: 8px 0 0 8px; border: 1px solid #ced4da;">
                    <button class="btn btn-outline-primary" type="submit" style="border-radius: 0 8px 8px 0;"><i class="bi bi-search"></i></button>
                </div>
            </form>

            <!-- User Section -->
            <ul class="navbar-nav">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li class="nav-item d-flex align-items-center">
                        <img src="<?= htmlspecialchars($_SESSION['profile_picture'] ?? $defaultProfileIcon); ?>" alt="Profile" class="rounded-circle shadow-sm" width="32" height="32" style="border: 1px solid #ddd; margin-right: 10px;">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="color: #34495e;"><?= htmlspecialchars($_SESSION['username']); ?></a>
                        <ul class="dropdown-menu dropdown-menu-end shadow-sm" aria-labelledby="userDropdown" style="border-radius: 12px;">
                            <li><a class="dropdown-item" href="./profile/<?= $_SESSION['user_id'] ?>">Profile</a></li>
                            <?php if ($_SESSION['is_admin']): ?>
                                <li><a class="dropdown-item" href="./admin/dashboard">Admin Dashboard</a></li>
                            <?php endif; ?>
                            <li><a class="dropdown-item text-danger" href="./logout"><i class="bi bi-box-arrow-right me-2"></i>Logout</a></li>
                        </ul>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="btn btn-outline-primary rounded-pill" href="./login" style="margin-right: 10px;"><i class="bi bi-box-arrow-in-right me-1"></i> Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-primary rounded-pill" href="./register">Register</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<?php

include_once __DIR__ . '/alertMessages.php';

?>

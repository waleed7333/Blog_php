<?php
// v_blog/app/views/home.php
?>
<?php
include_once __DIR__ . '/../views/layout/header.php';
include_once __DIR__ . '/../views/layout/navbar.php';

$base_url = "http://localhost/v_blog";
?>


<main class="main-content">
    <!-- Hero Section -->
    <section class="hero vh-100 d-flex align-items-center justify-content-center text-white position-relative" style="background: url('<?= $base_url ?>/public/images/hero-bg.jpg') no-repeat center center/cover;">
        <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark opacity-50"></div>
        <div class="container text-center position-relative z-index-1">
            <h1 class="display-1 fw-bold text-uppercase">Welcome to My Stylish Blog</h1>
            <p class="lead fs-3 mb-4">Join us and explore captivating stories, latest articles, and in-depth insights into various topics. Stay informed and entertained!</p>
            <a href="#latest-posts" class="btn btn-primary btn-lg rounded-pill px-5 py-3">Explore Articles</a>
        </div>
    </section>

    <!-- Latest Posts Section -->
    <section id="latest-posts" class="latest-posts py-5 bg-light">
        <div class="container">
            <h2 class="text-center mb-5 display-4 fw-bold">Latest Articles</h2>
            <div class="row g-4">
                <?php if (!empty($latest_posts)): ?>
                    <?php foreach ($latest_posts as $post): ?>
                        <div class="col-lg-4 col-md-6">
                            <a href="./posts/show/<?= htmlspecialchars($post['id']) ?>" class="text-decoration-none">
                                <div class="card shadow-sm border-0 h-100">
                                    <?php if (!empty($post['image'])): ?>
                                        <img src="<?= htmlspecialchars($base_url . '/public/images/' . $post['image']) ?>" alt="<?= htmlspecialchars($post['title']) ?>" class="card-img-top" style="height: 200px; object-fit: cover;">
                                    <?php else: ?>
                                        <img src="<?= $base_url ?>/public/images/default.png" alt="Default Image" class="card-img-top" style="height: 200px; object-fit: cover;">
                                    <?php endif; ?>
                                    <div class="card-body">
                                        <h3 class="card-title text-dark"><?= htmlspecialchars($post['title']) ?></h3>
                                        <p class="card-text text-muted small">By <?= htmlspecialchars($post['username']) ?> in <?= htmlspecialchars($post['category_name']) ?></p>
                                        <p class="text-secondary"><?= htmlspecialchars(substr($post['content'], 0, 100)) ?>...</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-center lead">No posts available at the moment. Check back later!</p>
                <?php endif; ?>
            </div>
        </div>
    </section>
</main>

<?php include_once __DIR__ . '/../views/layout/footer.php'; ?>

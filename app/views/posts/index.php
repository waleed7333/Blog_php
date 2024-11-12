<?php
// v_blog/app/views/posts/index.php
include_once __DIR__ . '/../layout/header.php';
include_once __DIR__ . '/../layout/navbar.php';

?>


<div class="container mt-5">
    <h1 class="mb-5 text-center display-4" style="font-family: 'Poppins', sans-serif; font-weight: bold; color: #333;">Discover Incredible Stories</h1>

    <!-- Filter and Sort Bar -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="filters">
            <button class="btn btn-outline-primary mx-1">All</button>
            <button class="btn btn-outline-primary mx-1">Tech</button>
            <button class="btn btn-outline-primary mx-1">Lifestyle</button>
            <button class="btn btn-outline-primary mx-1">Business</button>
            <!-- Add more categories dynamically -->
        </div>
        <div class="sort-options">
            <select class="form-select">
                <option value="recent">Most Recent</option>
                <option value="popular">Most Popular</option>
                <option value="commented">Most Commented</option>
            </select>
        </div>
    </div>

    <?php if (!empty($posts)): ?>
        <div class="row g-4">
            <?php foreach ($posts as $post): ?>
                <div class="col-md-6 mb-4">
                    <div class="card post-card shadow-lg border-0 h-100" style="border-radius: 20px; overflow: hidden; transition: transform 0.4s ease-in-out;">
                        <!-- Image Section with Hover Zoom -->
                        <?php if (!empty($post['image'])): ?>
                            <div class="img-hover-zoom">
                                <img src="<?= htmlspecialchars($base_url . '/public/images/' . $post['image']) ?>" class="card-img-top" alt="<?= htmlspecialchars($post['title']) ?>" style="height: 250px; object-fit: cover; transition: transform 0.4s ease;">
                            </div>
                        <?php else: ?>
                            <div class="img-hover-zoom">
                                <img src="<?= $base_url ?>/public/images/default.png" class="card-img-top" alt="Default Image" style="height: 250px; object-fit: cover; transition: transform 0.4s ease;">
                            </div>
                        <?php endif; ?>

                        <!-- Post Details -->
                        <div class="card-body" style="position: relative; padding: 20px; background-color: #f8f9fa;">
                            <!-- Post Title with Hover Effect -->
                            <a href="./posts/show/<?= $post['id']; ?>" style="text-decoration: none;">
                                <h2 class="card-title text-center" style="font-family: 'Poppins', sans-serif; font-weight: bold; color: #007bff;"><?= htmlspecialchars($post['title']); ?></h2>
                            </a>

                            <!-- Post Excerpt -->
                            <p class="card-text text-muted text-center"><?= nl2br(htmlspecialchars(substr($post['content'], 0, 180))); ?>...</p>

                            <!-- Category Badge -->
                            <div class="category-badge text-center mt-2">
                                <span class="badge bg-info"><?= htmlspecialchars($post['category_name']) ?></span>
                            </div>

                            <!-- Author and Post Stats -->
                            <div class="post-meta text-center mt-3">
                                <span class="text-muted">By <?= htmlspecialchars($post['username']) ?> | <?= htmlspecialchars($post['created_at']) ?></span>
                                <div class="d-flex justify-content-center mt-2">
                                    <span class="mx-2"><i class="fas fa-eye"></i> 1.2K Views</span>
                                    <span class="mx-2"><i class="fas fa-comments"></i> 8 Comments</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Hover Effect -->
                <script>
                    document.querySelectorAll('.card-img-top').forEach(function(img) {
                        img.addEventListener('mouseover', function() {
                            img.style.transform = 'scale(1.05)';
                        });
                        img.addEventListener('mouseout', function() {
                            img.style.transform = 'scale(1)';
                        });
                    });
                </script>

            <?php endforeach; ?>
        </div>

        <!-- Infinite Scroll Loader -->
        <div class="text-center mt-5">
            <button class="btn btn-primary" id="load-more" style="border-radius: 25px;">Load More</button>
        </div>

        <script>
            let loadMoreBtn = document.getElementById('load-more');
            loadMoreBtn.addEventListener('click', function() {
                loadMoreBtn.innerHTML = 'Loading...';
                setTimeout(function() {
                    loadMoreBtn.innerHTML = 'Load More';
                }, 2000);
            });

        </script>

    <?php else: ?>
        <p class="text-center lead" style="color: #555; font-family: 'Poppins', sans-serif;">No posts available at the moment. Check back later!</p>
    <?php endif; ?>
</div>

<?php include_once __DIR__ . '/../layout/footer.php'; ?>
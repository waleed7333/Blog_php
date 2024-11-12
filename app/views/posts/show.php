<?php
// v_blog/app/views/posts/show.php
include_once __DIR__ . '/../layout/header.php';
include_once __DIR__ . '/../layout/navbar.php';
?>

<div class="container post-content mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <!-- Post Card -->
            <article class="card shadow-lg border-0 rounded-3" style="overflow: hidden; background: #ffffff;">
                <!-- Post Image -->
                <div class="text-center">
                    <?php if ($post['image']): ?>
                        <img src="<?= htmlspecialchars($base_url . '/public/images/' . $post['image']) ?>" alt="Image of <?= htmlspecialchars($post['title']) ?>" class="img-fluid rounded-top" style="height: 400px; object-fit: cover;">
                    <?php else: ?>
                        <img src="<?= $base_url ?>/public/images/default.png" class="img-fluid rounded-top" alt="Default Image" style="width: 100%; height: auto;">
                    <?php endif; ?>
                </div>

                <!-- Post Content -->
                <div class="card-body text-center" style="padding: 40px;">
                    <h1 class="card-title display-4 mb-4" style="font-family: 'Poppins', sans-serif; color: #2c3e50;"><?= htmlspecialchars($post['title']) ?></h1>

                    <!-- Author Info with Avatar -->
                    <div class="d-flex align-items-center justify-content-center mb-3">
                        <img src="<?= $base_url ?>/public/images/default-avatar.png" class="rounded-circle me-2" alt="Author Avatar" style="width: 40px; height: 40px;">
                        <p class="post-meta text-muted" style="font-size: 14px;">
                            <strong>Author: </strong><b><?= htmlspecialchars($post['username']) ?></b> |
                            <strong>Category: </strong><?= htmlspecialchars($post['category_name']) ?> |
                            <strong>Created at: </strong><?= htmlspecialchars($post['created_at']) ?>
                            <?php if (!empty($post['updated_at'])): ?> |
                                <strong>Last updated: </strong><?= htmlspecialchars($post['updated_at']) ?>
                            <?php endif; ?>
                        </p>
                    </div>

                    <hr class="my-4" style="border-top: 1px solid #e0e0e0;">
                    <div class="post-content text-left" style="font-size: 18px; line-height: 1.7; color: #34495e;">
                        <p><?= nl2br(htmlspecialchars($post['content'])) ?></p>
                    </div>

                    <!-- Social Sharing Buttons -->
                    <div class="mt-4 text-center">
                        <span>Share this post:</span>
                        <div class="d-flex justify-content-center mt-2">
                            <a href="https://facebook.com/sharer/sharer.php?u=<?= urlencode($base_url . '/posts/show/' . $post['id']) ?>" target="_blank" class="btn btn-primary btn-sm mx-1" title="Share on Facebook">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="https://twitter.com/intent/tweet?url=<?= urlencode($base_url . '/posts/show/' . $post['id']) ?>" target="_blank" class="btn btn-info btn-sm mx-1" title="Share on Twitter">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a href="https://www.linkedin.com/shareArticle?mini=true&url=<?= urlencode($base_url . '/posts/show/' . $post['id']) ?>" target="_blank" class="btn btn-linkedin btn-sm mx-1" title="Share on LinkedIn">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                            <a href="https://wa.me/?text=<?= urlencode($base_url . '/posts/show/' . $post['id']) ?>" target="_blank" class="btn btn-success btn-sm mx-1" title="Share on WhatsApp">
                                <i class="fab fa-whatsapp"></i>
                            </a>
                            <a href="https://pinterest.com/pin/create/button/?url=<?= urlencode($base_url . '/posts/show/' . $post['id']) ?>&media=<?= urlencode($base_url . '/public/images/' . $post['image']) ?>&description=<?= urlencode($post['title']) ?>" target="_blank" class="btn btn-danger btn-sm mx-1" title="Share on Pinterest">
                                <i class="fab fa-pinterest"></i>
                            </a>
                            <a href="https://telegram.me/share/url?url=<?= urlencode($base_url . '/posts/show/' . $post['id']) ?>&text=<?= urlencode($post['title']) ?>" target="_blank" class="btn btn-info btn-sm mx-1" title="Share on Telegram">
                                <i class="fab fa-telegram-plane"></i>
                            </a>
                            <a href="https://www.reddit.com/submit?url=<?= urlencode($base_url . '/posts/show/' . $post['id']) ?>&title=<?= urlencode($post['title']) ?>" target="_blank" class="btn btn-danger btn-sm mx-1" title="Share on Reddit">
                                <i class="fab fa-reddit-alien"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Edit/Delete Buttons -->
                <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $post['user_id']): ?>
                    <div class="card-footer d-flex justify-content-center" style="background-color: transparent;">
                        <!-- Edit Button  -->
                        <button type="button" onclick="location.href='./posts/update/<?= $post['id'] ?>'" class="btn btn-warning mx-2 shadow-sm" style="border-radius: 30px; padding: 10px 20px;">
                            <i class="fas fa-edit"></i> Edit
                        </button>
                        <!-- Delete Button  -->
                        <button type="button" data-bs-toggle="modal" data-bs-target="#deleteConfirmationModal" class="btn btn-danger mx-2 shadow-sm" style="border-radius: 30px; padding: 10px 20px;">
                            <i class="fas fa-trash-alt"></i> Delete
                        </button>
                    </div>
                <?php endif; ?>
            </article>


            <!-- Comment Section -->
            <div class="comments-section mt-5">
                <h2 class="text-center mb-4" style="font-family: 'Poppins', sans-serif; font-weight: bold; color: #34495e;">Comments</h2>

                <!-- Display Comments -->
                <?php if (!empty($comments)): ?>
                    <?php foreach ($comments as $comment): ?>
                        <div class="d-flex mb-3 p-3 shadow-sm" style="background-color: #ffffff; border-radius: 12px;">
                            <!-- User Avatar -->
                            <img src="<?= $base_url ?>/public/images/default-avatar.png" alt="User Avatar" class="rounded-circle me-3 shadow-sm" style="width: 45px; height: 45px; border: 2px solid #ddd;">

                            <div class="w-100">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong style="color: #050505; font-size: 1rem;"><?= htmlspecialchars($comment['username']) ?></strong>
                                        <span class="text-muted ms-2" style="font-size: 0.875rem;"><?= date('F j, Y, g:i a', strtotime($comment['created_at'])) ?></span>
                                    </div>

                                    <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] === $comment['user_id']): ?>
                                        <!-- Dropdown for Edit/Delete -->
                                        <div class="dropdown">
                                            <button class="btn btn-link text-muted p-0" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="fas fa-ellipsis-h"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end shadow-sm" style="border-radius: 8px;">
                                                <li>
                                                    <button class="dropdown-item" data-bs-toggle="collapse" data-bs-target="#editCommentForm<?= $comment['id'] ?>" aria-expanded="false" aria-controls="editCommentForm<?= $comment['id'] ?>">
                                                        <i class="fas fa-edit me-2"></i> Edit
                                                    </button>
                                                </li>
                                                <li>
                                                    <form action="./comments/delete" method="post" onsubmit="return confirm('Are you sure you want to delete this comment?');">
                                                        <input type="hidden" name="comment_id" value="<?= $comment['id'] ?>">
                                                        <button type="submit" class="dropdown-item text-danger">
                                                            <i class="fas fa-trash-alt me-2"></i> Delete
                                                        </button>
                                                    </form>
                                                </li>
                                            </ul>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <p class="text-dark mt-1 mb-1" style="font-size: 0.9375rem;"><?= htmlspecialchars($comment['content']) ?></p>

                                <!-- Like and Reply Options -->
                                <div class="d-flex">
                                    <button class="btn btn-link text-muted p-0 me-3 like-btn" style="font-size: 0.875rem;">
                                        <i class="far fa-thumbs-up me-1"></i> Like
                                    </button>
                                    <button class="btn btn-link text-muted p-0 reply-btn" style="font-size: 0.875rem;">
                                        <i class="far fa-comment-dots me-1"></i> Reply
                                    </button>
                                </div>

                                <!-- Edit Comment Form (Hidden by Default) -->
                                <div id="editCommentForm<?= $comment['id'] ?>" class="collapse mt-2">
                                    <form action="./comments/edit" method="post" class="p-2 shadow-sm" style="background-color: #f0f2f5; border-radius: 8px;">
                                        <input type="hidden" name="comment_id" value="<?= $comment['id'] ?>">
                                        <textarea name="content" class="form-control mb-2" rows="2" required style="border-radius: 10px;"><?= htmlspecialchars($comment['content']) ?></textarea>
                                        <button type="submit" class="btn btn-primary btn-sm shadow">Update</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-center text-muted">No comments yet. Be the first to comment!</p>
                <?php endif; ?>
            </div>

            <!-- Add a Comment Form -->
            <div class="add-comment mt-5">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <div class="d-flex align-items-center mb-4">
                        <form action="./comments/create" method="post" class="flex-grow-1">
                            <input type="hidden" name="post_id" value="<?= $post['id'] ?>">

                            <div class="input-group" style="position: relative;">
                                <textarea name="content" class="form-control" rows="1" placeholder="Write a comment..." required style="border-radius: 12px; background-color: #f0f2f5; padding: 0.75rem;"></textarea>
                                <button type="submit" class="btn" style="border-radius: 50%; position: absolute; bottom: 5px; right: 5px; z-index: 999;box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);">
                                    <i class="bi bi-send" style="font-size: 24px;color:darkblue"></i>
                                </button>
                            </div>
                        </form>
                    </div>

                <?php else: ?>
                    <p class="text-center mt-4">
                        <a href="./login" class="btn btn-primary shadow-sm" style="border-radius: 20px; padding: 0.5rem 1.5rem;">
                            <i class="fas fa-sign-in-alt"></i> Login to add a comment.
                        </a>
                    </p>
                <?php endif; ?>
            </div>


        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteConfirmationModal" tabindex="-1" aria-labelledby="deleteConfirmationLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content shadow-lg border-0">
                <!-- Header -->
                <div class="modal-header bg-danger text-white py-3" style="border-top-left-radius: 20px; border-top-right-radius: 20px;">
                    <h5 class="modal-title w-100 text-center fw-bold" id="deleteConfirmationLabel">Confirm Deletion</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <!-- Body -->
                <div class="modal-body text-center py-5">
                    <i class="fas fa-exclamation-circle text-danger mb-4" style="font-size: 100px;"></i>
                    <h4 class="fw-bold mb-3">Are you sure you want to delete this post?</h4>
                    <p class="text-muted mb-4">This action cannot be undone.</p>
                </div>
                <!-- Footer -->
                <div class="modal-footer justify-content-center py-4">
                    <!-- Cancel Button -->
                    <button type="button" class="btn btn-secondary btn-lg px-5 shadow-sm" data-bs-dismiss="modal" style="border-radius: 50px;">
                        <i class="fas fa-times me-2"></i> Cancel
                    </button>
                    <!-- Form for deletion -->
                    <form action="./posts/delete/<?= $post['id'] ?>" method="POST" class="d-inline" id="deletePostForm">
                        <input type="hidden" name="_method" value="DELETE">
                        <button type="submit" class="btn btn-danger btn-lg px-5 mx-3 shadow-sm" style="border-radius: 50px;">
                            <i class="fas fa-trash-alt me-2"></i> Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include_once __DIR__ . '/../layout/footer.php'; ?>




<script>
    // Optional: Smooth scrolling for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            document.querySelector(this.getAttribute('href')).scrollIntoView({
                behavior: 'smooth'
            });
        });
    });

</script>
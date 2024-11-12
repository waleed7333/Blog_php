<?php
//  v_blog/app/views/admin/manage_posts.php 
?>

<!-- Manage Posts -->
<div class="container mt-5">
    <h3 class="text-center mb-4 text-secondary">Manage Posts</h3>
    <table class="table table-hover shadow-sm rounded bg-white">
        <thead class="table-dark text-white">
            <tr>
                <th>Title</th>
                <th>Author</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($posts as $post): ?>
                <tr>
                    <td><?= htmlspecialchars($post['title']) ?></td>
                    <td><?= htmlspecialchars($post['author']) ?></td>
                    <td><?= date('Y-m-d', strtotime($post['created_at'])) ?></td>
                    <td>
                        <a href="./edit_post.php?id=<?= $post['id'] ?>" class="btn btn-outline-primary btn-sm">Edit</a>
                        <form action="./delete_post.php" method="post" class="d-inline">
                            <input type="hidden" name="post_id" value="<?= $post['id'] ?>">
                            <button type="submit" class="btn btn-outline-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>


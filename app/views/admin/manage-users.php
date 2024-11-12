<?php
// v_blog/app/views/admin/manage-users.php  2
?>

<!-- Manage Users -->
<div class="container mt-5">
    <h3 class="text-center mb-4 text-secondary">Manage Users</h3>
    <table class="table table-hover shadow-sm rounded bg-white">
        <thead class="table-primary">
            <tr>
                <th>Username</th>
                <th>Email</th>
                <th>Role</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($users)): ?>
                <tr>
                    <td colspan="4" class="text-center">No users found.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?= htmlspecialchars($user['username']) ?></td>
                        <td><?= htmlspecialchars($user['email']) ?></td>
                        <td><?= $user['is_admin'] ? 'Admin' : 'User' ?></td>
                        <td>
                            <a href="./profile/<?= $user['id'] ?>" class="btn btn-outline-primary btn-sm">Edit</a>
                            <form action="./" method="post" class="d-inline">
                                <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                                <button type="submit" class="btn btn-outline-danger btn-sm">Block</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

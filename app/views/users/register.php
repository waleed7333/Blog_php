<?php
// v_blog/app/views/users/register.php
?>

<?php
include '../app/views/layout/header.php';
include '../app/views/layout/navbar.php';

if (isset($message) && $message != "") {
    echo '<div class="alert alert-info text-center">' . htmlspecialchars($message) . '</div>';
}
?>

<div class="container d-flex align-items-center justify-content-center" style="height: 100vh;">
    <div class="card shadow" style="width: 400px;">
        <div class="card-body">
            <h2 class="text-center mb-4">Register</h2>
            <form action="./register" method="post" class="register-form">
                <div class="form-group mb-3">
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username" class="form-control" required>
                </div>
                <div class="form-group mb-3">
                    <label for="email">Email Address</label>
                    <input type="email" name="email" id="email" class="form-control" required>
                </div>
                <div class="form-group mb-4">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Register</button>
            </form>
            <p class="text-center mt-3">Already have an account? <a href="./login">Login</a></p>
        </div>
    </div>
</div>

<?php include '../app/views/layout/footer.php'; ?>

<?php
// v_blog/app/views/users/login.php
?>

<?php
include '../app/views/layout/header.php';
include '../app/views/layout/navbar.php';

if (isset($error) && $error != "") {
    echo '<div class="alert alert-danger text-center">' . htmlspecialchars($error) . '</div>';
}
?>

<div class="container d-flex align-items-center justify-content-center" style="height: 100vh;">
    <div class="card shadow" style="width: 400px;">
        <div class="card-body">
            <h2 class="text-center mb-4">Login</h2>
            <form action="./login" method="post" class="login-form">
                <div class="form-group mb-3">
                    <label for="email">Email Address</label>
                    <input type="email" name="email" id="email" class="form-control" required>
                </div>
                <div class="form-group mb-4">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Login</button>
            </form>
            <p class="text-center mt-3">Don't have an account? <a href="./register">Register now</a></p>
        </div>
    </div>
</div>

<?php include '../app/views/layout/footer.php'; ?>

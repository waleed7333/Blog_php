<?php 
// v_blog/app/views/layout/footer.php  2
?>
<?php 
include_once __DIR__ . '/../layout/header.php';
?>
<footer class="bg-dark text-light pt-5 pb-4">
    <div class="container">
        <div class="row">
            <!-- Links Section -->
            <div class="col-lg-3 col-md-6 mb-4">
                <h5 class="text-uppercase mb-4">Quick Links</h5>
                <ul class="list-unstyled">
                    <li><a href="/about" class="text-light text-decoration-none d-block py-1">About Us</a></li>
                    <li><a href="/terms" class="text-light text-decoration-none d-block py-1">Terms of Service</a></li>
                    <li><a href="/privacy" class="text-light text-decoration-none d-block py-1">Privacy Policy</a></li>
                    <li><a href="contact" class="text-light text-decoration-none d-block py-1">Contact Us</a></li>
                </ul>
            </div>

            <!-- Social Media Section -->
            <div class="col-lg-3 col-md-6 mb-4 text-center">
                <h5 class="text-uppercase mb-4">Follow Us</h5>
                <div class="d-flex justify-content-center">
                    <a href="https://facebook.com" class="text-light me-3"><i class="fab fa-facebook fa-2x"></i></a>
                    <a href="https://twitter.com" class="text-light me-3"><i class="fab fa-twitter fa-2x"></i></a>
                    <a href="https://instagram.com" class="text-light me-3"><i class="fab fa-instagram fa-2x"></i></a>
                    <a href="https://linkedin.com" class="text-light"><i class="fab fa-linkedin fa-2x"></i></a>
                </div>
            </div>

            <!-- Newsletter Section -->
            <div class="col-lg-6 mb-4">
                <h5 class="text-uppercase mb-4">Subscribe to our Newsletter</h5>
                <form action="./subscribe" method="POST" class="input-group">
                    <input type="email" name="email" class="form-control" placeholder="Enter your email" required>
                    <button type="submit" class="btn btn-primary">Subscribe</button>
                </form>
                <p class="small text-muted mt-2">Stay updated with our latest articles and news.</p>
            </div>
        </div>

        <hr class="bg-light">

        <div class="row">
            <!-- Copyright -->
            <div class="col-md-6 text-center text-md-start mb-2 mb-md-0">
                <p class="mb-0">© v_blog 2024. All Rights Reserved.</p>
            </div>

            <!-- Slogan -->
            <div class="col-md-6 text-center text-md-end">
                <p class="mb-0">Connect with us and stay inspired!</p>
            </div>
        </div>
    </div>
</footer>




<script>
    
</script>
</body>
</html>
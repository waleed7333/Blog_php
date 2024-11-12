<?php 
// v_blog/app/views/posts/create.php
?>

<?php 
require_once "../app/views/layout/header.php"; 
require_once "../app/views/layout/navbar.php"; 
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg">
                <div class="card-header bg-primary text-white">
                    <h4>Create New Post</h4>
                </div>
                <div class="card-body">
                    <form id="createPostForm" action="" method="POST" enctype="multipart/form-data" onsubmit="return validateForm()">
                        <!-- Title -->
                        <div class="form-group mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" class="form-control" id="title" name="title" placeholder="Enter post title" required>
                            <div id="titleError" class="invalid-feedback">Please enter a title for the post.</div>
                        </div>

                        <!-- Category -->
                        <div class="form-group mb-3">
                            <label for="category" class="form-label">Category</label>
                            <select class="form-select" id="category" name="category_id" onchange="toggleNewCategoryInput(this)" required>
                                <option value="" selected disabled>Choose a category</option>
                                <?php foreach($categories as $category): ?>
                                    <option value="<?php echo $category['id']; ?>"><?php echo htmlspecialchars($category['name']); ?></option>
                                <?php endforeach; ?>
                                <option value="new">Add New Category</option>
                            </select>
                            <div id="categoryError" class="invalid-feedback">Please select a category.</div>
                        </div>

                        <!-- Input for New Category (Hidden by default) -->
                        <div class="form-group mb-3" id="newCategoryDiv" style="display: none;">
                            <label for="new_category" class="form-label">New Category</label>
                            <input type="text" class="form-control" id="new_category" name="new_category" placeholder="Enter new category">
                        </div>

                        <!-- Content -->
                        <div class="form-group mb-3">
                            <label for="content" class="form-label">Content</label>
                            <textarea class="form-control" id="content" name="content" rows="5" placeholder="Write your post content here" required></textarea>
                            <div id="contentError" class="invalid-feedback">Please enter content for the post.</div>
                        </div>

                        <!-- Image -->
                        <div class="form-group mb-3">
                            <label for="image" class="form-label">Upload Image</label>
                            <input type="file" class="form-control" id="image" name="image">
                        </div>

                        <!-- Submit Button -->
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-success">Create Post</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap Modal for Success Message -->
<?php if (isset($showModal) && $showModal): ?>
<div class="modal fade show" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-modal="true" style="display: block;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="successModalLabel">Post Created Successfully</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Your post has been created successfully! What would you like to do next?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="createAnotherPost">Create Another Post</button>
                <button type="button" class="btn btn-secondary" id="goToHome">Go to Home</button>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<?php require_once "../app/views/layout/footer.php"; ?>


<!-- ================================================== -->

<!-- Include the JavaScript -->
<!--  -->
    <script>
        //JS for Creating a New Category
        function toggleNewCategoryInput(select) {
            var newCategoryDiv = document.getElementById('newCategoryDiv');
            if (select.value === 'new') {
            newCategoryDiv.style.display = 'block'; // Show new category input
            newCategoryDiv.querySelector('input').required = true; // Add required attribute
            } else {
            newCategoryDiv.style.display = 'none'; // Hide new category input
            newCategoryDiv.querySelector('input').required = false; // Remove required attribute
            }
        }
        
        // Handling modal actions
        document.getElementById('createAnotherPost').addEventListener('click', function() {
            window.location.href = './posts/create';
        });
        document.getElementById('goToHome').addEventListener('click', function() {
            window.location.href = './';
        });
    </script>

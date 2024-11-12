<?php
// v_blog/app/views/posts/update.php

include_once __DIR__ . '/../layout/header.php';
include_once __DIR__ . '/../layout/navbar.php';



$base_url = "http://localhost/v_blog";
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-primary text-white py-3 shadow-sm">
                    <h4 class="mb-0 d-flex align-items-center">
                        <i class="fas fa-edit me-2"></i> Edit Post
                    </h4>
                </div>
                <div class="card-body">
                    <form action="./posts/update/<?= $post['id'] ?>" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                        <!-- Title Field -->
                        <div class="form-group mb-3">
                            <label for="title" class="form-label">Post Title</label>
                            <input type="text" name="title" id="title" class="form-control shadow-sm" value="<?= htmlspecialchars($post['title']); ?>" required>
                            <div class="invalid-feedback">Please enter the post title.</div>
                        </div>

                        <!-- Content Field -->
                        <div class="form-group mb-3">
                            <label for="content" class="form-label">Post Content</label>
                            <textarea name="content" id="content" class="form-control shadow-sm" rows="8" required><?= htmlspecialchars($post['content']); ?></textarea>
                            <div class="invalid-feedback">Please enter the post content.</div>
                        </div>

                        <!-- Image Upload Field with Preview -->
                        <div class="form-group mb-4">
                            <label for="image" class="form-label">Post Image</label>
                            <input type="file" name="image" id="image" class="form-control shadow-sm" accept="image/*" onchange="previewImage(event)">
                            <div class="mt-3 text-center">
                                <img id="image-preview" src="<?= htmlspecialchars($base_url . '/public/images/' . $post['image']); ?>" alt="Post Image" class="img-fluid rounded shadow-sm" style="max-width: 100%; height: auto; border: 1px solid #ddd;">
                            </div>
                        </div>

                        <!-- Category Select with New Category Option -->
                        <div class="form-group mb-3">
                            <label for="category" class="form-label">Category</label>
                            <select class="form-select shadow-sm" id="category" name="category_id" onchange="toggleNewCategoryInput(this)" required>
                                <option value="" disabled>Select a category</option>
                                <?php foreach ($categories as $category): ?>
                                    <option value="<?= $category['id']; ?>" <?= ($category['id'] == $post['category_id']) ? 'selected' : ''; ?>>
                                        <?= htmlspecialchars($category['name']); ?>
                                    </option>
                                <?php endforeach; ?>
                                <option value="new">Add New Category</option>
                            </select>
                        </div>

                        <!-- Input for New Category (Hidden by default) -->
                        <div class="form-group mb-3" id="newCategoryDiv" style="display: none;">
                            <label for="new_category" class="form-label">New Category</label>
                            <input type="text" class="form-control shadow-sm" id="new_category" name="new_category" placeholder="Enter new category">
                            <div class="invalid-feedback">Please enter a new category.</div>
                        </div>

                        <!-- Submit and Cancel Buttons -->
                        <div class="d-flex justify-content-end gap-2">
                            <button type="submit" class="btn btn-success shadow-sm px-4">Save Changes</button>
                            <a href="./posts" class="btn btn-secondary shadow-sm px-4">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Function to preview uploaded image
    function previewImage(event) {
        const reader = new FileReader();
        reader.onload = function() {
            const output = document.getElementById('image-preview');
            output.src = reader.result;
        };
        reader.readAsDataURL(event.target.files[0]);
    }

    // Toggle new category input field based on the selection
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

    // Bootstrap form validation
    (function() {
        'use strict'
        const forms = document.querySelectorAll('.needs-validation')
        Array.prototype.slice.call(forms).forEach(function(form) {
            form.addEventListener('submit', function(event) {
                if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                }
                form.classList.add('was-validated')
            }, false)
        })
    })()
</script>

<?php include_once __DIR__ . '/../layout/footer.php'; ?>
<?php
// v_blog/app/controllers/CommentController.php

require_once __DIR__ . '/../models/Comment.php';
require_once __DIR__ . '/../models/Post.php';

class CommentController
{
    private $db;
    private $commentModel;
    private $post;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->commentModel = new Comment($this->db);
        $this->post = new Post($this->db);
    }

    // Load comments for a specific post
 public function loadComments_Controller($post_id) {
    // إعداد الرابط الأساسي
    $base_url = "http://localhost/v_blog/public";

    // الحصول على التعليقات
    $comments = $this->commentModel->getByPostId_Model($post_id);

    // تخزين التعليقات في الجلسة
    if (!isset($_SESSION['comments'])) {
        $_SESSION['comments'] = [];
    }
    $_SESSION['comments'][$post_id] = $comments;

    // التوجيه إلى صفحة العرض الخاصة بالمنشور
    // header("Location: " . $base_url . "/posts/show/" . $post_id);
    exit();
}

    // Create a new comment
    public function createComment_Controller()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user_id'])) {
            $postId = $_POST['post_id'];
            $content = $_POST['content'];
            $userId = $_SESSION['user_id'];

            // Set comment properties
            $this->commentModel->post_id = $postId;
            $this->commentModel->user_id = $userId;
            $this->commentModel->content = $content;

            if ($this->commentModel->createComment_Model()) {
                // Redirect back to the post after adding a comment
                header('Location: ' . $_SERVER['HTTP_REFERER']);
                exit();
            } else {
                echo "Error adding the comment.";
            }
        } else {
            header('Location: /login');
            exit();
        }
    }

    // Edit an existing comment
    public function editComment_Controller()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user_id'])) {
            $content = $_POST['content'];
            $userId = $_SESSION['user_id'];
            $commentId = $_POST['comment_id'];

            // Update the comment
            if ($this->commentModel->updateComment_Model($commentId, $content, $userId)) {
                header('Location: ' . $_SERVER['HTTP_REFERER']);
                exit();
            } else {
                echo "Error updating the comment.";
            }
        }
        require_once __DIR__ . '/../views/posts/show.php';
    }

    // Delete a comment
    public function deleteComment_Controller()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user_id'])) {
            $commentId = $_POST['comment_id'];
            $userId = $_SESSION['user_id'];

            if ($this->commentModel->deleteComment_Model($commentId, $userId)) {
                header('Location: ' . $_SERVER['HTTP_REFERER']);
                exit();
            } else {
                echo "Error deleting the comment.";
            }
        }
    }

    
}
?>

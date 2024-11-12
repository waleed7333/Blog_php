<?php 
// v_blog/app/controllers/AdminController.php
?>
<?php
require_once __DIR__ . '/../models/Comment.php';
require_once __DIR__ . '/../models/Post.php';
require_once __DIR__ . '/../models/User.php';

class AdminController {
    private $db;
    private $commentModel;
    private $post;
    private $user;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->commentModel = new Comment($this->db);
        $this->post = new Post($this->db);
        $this->user = new User($this->db);
    }
    public function dashboard() {
        

        $user_count = $this->user->getUserCount();
        $post_count =$this->post ->getPostCountForAllUsers();
        $comment_count = $this->commentModel->getCommentCount();
        
        $users = $this->user->getAllUsers();
        $posts = $this->post->getAllPosts();
        include_once __DIR__ . '/../views/admin/dashboard.php';
    }

    public function manageUsers() {
        
        $users = $this->user->getAllUsers();
        
        include_once __DIR__ . '/../views/admin/dashboard.php';
    }

    public function managePosts() {
        $stmt = $this->post->getAllPosts();
        $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
        include_once __DIR__ . '/../views/admin/dashboard.php';
    }
}

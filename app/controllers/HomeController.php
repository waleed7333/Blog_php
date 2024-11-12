<?php
// v_blog/app/controllers/HomeController.php  2
?>

<?php
require_once __DIR__ . '/../models/Post.php';

class HomeController {
    private $db;
    private $post;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->post = new Post($this->db);
    }

    public function index() {
        $latest_posts = $this->post->getLatestPosts(6);
        require_once __DIR__ . '/../views/home.php';
    }
}

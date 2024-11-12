<?php
// v_blog/app/controllers/UserController.php
?>

<?php
require_once __DIR__ . "/../models/User.php";

class UserController
{
    private $db;
    private $user;
    private $post;
    private $comment;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->user = new User($this->db);
        $this->post = new Post($this->db);
        $this->comment = new Comment($this->db);
    }

    public function login()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $email = $_POST['email'];
            $password = $_POST['password'];

            $loginResult = $this->user->login($email, $password);
            if (is_array($loginResult)) {
                $_SESSION['user_id'] = $loginResult['id'];
                $_SESSION['username'] = $loginResult['username'];
                $_SESSION['is_admin'] = $loginResult['is_admin'];

                if ($loginResult['is_admin']) {
                    header("Location: ./admin/dashboard");
                } else {
                    header("Location: ./");
                }
                exit();
            } else {
                $_SESSION['error'] = "Invalid email or password.";
            }
        }
        require_once "../app/views/users/login.php";
    }

    public function register()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $this->user->username = $_POST['username'];
            $this->user->email = $_POST['email'];
            $this->user->password = $_POST['password'];

            if ($this->user->create()) {
                $_SESSION['success'] = "User created successfully. You can now login.";
                header("Location: ./login");
                exit();
            } else {
                $_SESSION['error'] = "Failed to create user.";
            }
        }
        require_once "../app/views/users/register.php";
    }

    public function profile($id)
    {
        $base_url = "http://localhost/v_blog/public";
        $currentUserId = $_SESSION['user_id'];
        $isCurrentUser = ($currentUserId === $id);
        $user = $this->user->getUserById($id);
        // view profile

        $latest_posts = $this->post->getLatestPostsForUser($id, 6);
        $postsCount = $this->post->getPostsCountForUser($id);
        $commentsCount = $this->comment->getCommentsCountForUser_Model($id);


        // update profile
        if ($isCurrentUser && $_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->user->id = $currentUserId;
            $this->user->username = $_POST['username'];
            $this->user->email = $_POST['email'];
            $this->user->profile_picture = $this->uploadProfileImage();

            if ($this->user->updateProfile()) {
                $_SESSION['success'] = "Profile updated successfully!";
                header("Location:" . $base_url . "/profile/" . $id);
                exit;
            } else {
                $_SESSION['error'] = "Failed to update profile.";
            }
            // header("Location:" . $base_url . "/profile/" . $id);

        }
        require_once "../app/views/users/profile.php";
    }

    private function uploadProfileImage()
    {
        if (!empty($_FILES['profile_picture']['name'])) {
            $imageName = $_FILES['profile_picture']['name'];
            $targetDir = __DIR__ . '/../../public/uploads/';
            move_uploaded_file($_FILES['profile_picture']['tmp_name'], $targetDir . $imageName);
            return $imageName;
        }
        return null;
    }

    public function updatePassword($user_id)
{
    $base_url = "http://localhost/v_blog/public";
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['user_id'])) {
        $current_password = $_POST['current_password'];
        $new_password = $_POST['new_password'];
        $confirm_password = $_POST['confirm_password'];
        if ($new_password === $confirm_password) {
            $user_data = $this->user->getuserById($user_id);
            if (password_verify($current_password, $user_data['password'])) {
                $this->user->password = password_hash($new_password, PASSWORD_DEFAULT);
                $this->user->id = $user_id;
                if ($this->user->updatePassword()) {
                    $_SESSION['success'] = "Password changed successfully!";
                } else {
                    $_SESSION['error'] = "Failed to change password.";
                }
            } else {
                $_SESSION['error'] = "Current password is incorrect.";
            }
        } else {
            $_SESSION['error'] = "New password and confirmation do not match.";
        }
    }
    header("Location:" . $base_url . "/profile/" . $user_id);
}



    public function changeAdminStatus($id, $status)
    {
        $base_url = "http://localhost/v_blog/public";
        if (!$_SESSION['is_admin']) {
            $_SESSION['error'] = "You don't have the permissions for this action.";
            header("Location:" . $base_url . "/profile/" . $id);
            exit;
        }

        if ($this->user->updateAdminStatus($id, $status)) {
            $_SESSION['success'] = $status ? "User promoted to admin successfully." 
            : "Admin privileges removed successfully.";
        } else {
            $_SESSION['error'] = "Failed to change user status.";
        }
        header("Location:" . $base_url . "/profile/" . $id);
    }

    public function upgradeAdmin($id)
    {
        $this->changeAdminStatus($id, true);
    }

    public function downgradeAdmin($id)
    {
        $this->changeAdminStatus($id, false);
    }
}

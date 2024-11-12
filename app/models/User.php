<?php
// v_blog/app/models/User.php  2 
?>

<?php
class User
{
    private $conn;
    private $table = "users";

    public $id;
    public $username;
    public $email;
    public $password;
    public $profile_picture;
    public $is_admin;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function create()
{
    $query = "INSERT INTO " . $this->table . " 
            SET username=:username, email=:email, 
                password=:password";

    $stmt = $this->conn->prepare($query);
    $this->password = password_hash($this->password, PASSWORD_BCRYPT); // تشفير كلمة المرور هنا لمرة واحدة فقط
    $stmt->bindParam(":username", $this->username);
    $stmt->bindParam(":email", $this->email);
    $stmt->bindParam(":password", $this->password);

    try {
        if ($stmt->execute()) {
            return true; // Successful creation
        }
    } catch (PDOException $e) {
        if ($e->getCode() == 23000) { // Duplicate entry
            return "Username or email already exists.";
        }
        return "An error occurred. Please try again.";
    }
    return false; // Generic failure
}


    public function login($email, $password)
    {
        $query = "SELECT * FROM " . $this->table . " WHERE email = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$email]);

        if ($user = $stmt->fetch(PDO::FETCH_ASSOC)) {
            if (password_verify($password, $user['password'])) {
                return $user; // Successful login
            } else {
                return "Incorrect password.";
            }
        }
        return "Email not found.";
    }

    public function getuserById($id)
    {
        $query = "SELECT * FROM " . $this->table . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateProfile()
    {
        $query = "UPDATE " . $this->table . " 
            SET username = :username, email = :email, profile_picture = :profile_picture 
            WHERE id = :id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":username", $this->username);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":profile_picture", $this->profile_picture);
        $stmt->bindParam(":id", $this->id);

        return $stmt->execute();
    }

    public function updatePassword()
{
    $query = "UPDATE " . $this->table . " 
        SET password = :password 
        WHERE id = :id";

    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(":password", $this->password);
    $stmt->bindParam(":id", $this->id);

    return $stmt->execute();
}


    public function updateAdminStatus($id, $isAdmin)
    {
        $sql = "UPDATE users SET is_admin = :is_admin WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':is_admin', $isAdmin ? 1 : 0, PDO::PARAM_INT);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }


    // DASHBOARD


    // دالة لإحصاء عدد المستخدمين
    public function getUserCount()
    {
        $query = "SELECT COUNT(*) AS count FROM users";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'];
    }

    // دالة لاسترجاع جميع المستخدمين
    public function getAllUsers()
    {
        $query = "SELECT id, username, email, profile_picture, is_admin, created_at FROM users";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // دالة لتعطيل حساب المستخدم
    public function deactivateUser($userId)
    {
        $query = "UPDATE users SET is_active = 0 WHERE id = :userId";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        return $stmt->execute();
    }
}

<?php
// v_blog/app/models/Post.php  2
?>

<?php

class Post
{
    private $conn;
    private $table = "posts";

    public $id;
    public $user_id;
    public $category_id;
    public $title;
    public $content;
    public $image;
    public $created_at;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // إنشاء بوست جديد
    public function create()
    {
        $query = "INSERT INTO " . $this->table . " 
                (title, content, user_id, category_id, image, created_at) 
                VALUES (:title, :content, :user_id, :category_id, :image, NOW())";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":title", $this->title);
        $stmt->bindParam(":content", $this->content);
        $stmt->bindParam(":user_id", $this->user_id);
        $stmt->bindParam(":category_id", $this->category_id);
        $stmt->bindParam(":image", $this->image);

        try {
            return $stmt->execute();
        } catch (PDOException $e) {
            // التحقق من وجود أخطاء قاعدة البيانات مثل القيد الأجنبي
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    // قراءة كل البوستات
    public function read()
    {
        $query = "SELECT p.*, u.username, c.name as category_name 
                FROM " . $this->table . " p
                LEFT JOIN users u ON p.user_id = u.id
                LEFT JOIN categories c ON p.category_id = c.id
                ORDER BY p.created_at DESC";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }

    // استرداد بوست محدد عبر الـID
    public function getPostByPostId($id)
    {
        $query = "SELECT p.*, u.username, c.name as category_name 
                FROM " . $this->table . " p
                LEFT JOIN users u ON p.user_id = u.id
                LEFT JOIN categories c ON p.category_id = c.id
                WHERE p.id = :id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // استرجاع المقالات الخاصة بالمستخدم
    public function getPostsByUserId() {
        $query = "SELECT * FROM posts WHERE user_id = :user_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $this->id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // دالة للحصول على عدد المقالات الخاصة بالمستخدم
    public function getPostsCountForUser($user_id) {
    $query = "SELECT COUNT(*) as count FROM posts WHERE user_id = :user_id";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['count'];
}

    // تحديث البوست
    public function updatePost()
    {
        $query = "UPDATE " . $this->table . " 
                SET title = :title, content = :content, 
                    category_id = :category_id, image = :image 
                WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":title", $this->title);
        $stmt->bindParam(":content", $this->content);
        $stmt->bindParam(":category_id", $this->category_id);
        $stmt->bindParam(":image", $this->image);
        $stmt->bindParam(":id", $this->id);

        return $stmt->execute();
    }

    // return latest posts for all users
    public function getLatestPosts($limit)
    {
        $query = "SELECT p.*, u.username, c.name as category_name 
                FROM " . $this->table . " p
                LEFT JOIN users u ON p.user_id = u.id
                LEFT JOIN categories c ON p.category_id = c.id
                ORDER BY p.created_at DESC
                LIMIT :limit";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":limit", $limit, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // return latest posts for a specific user
    public function getLatestPostsForUser($userId, $limit = 6)
{
    $sql = "SELECT p.*, u.username, c.name as category_name 
            FROM posts p
            LEFT JOIN users u ON p.user_id = u.id
            LEFT JOIN categories c ON p.category_id = c.id
            WHERE p.user_id = :user_id
            ORDER BY p.created_at DESC
            LIMIT :limit";

    $stmt = $this->conn->prepare($sql);
    $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
    $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}



    public function delete()
    {
        $sql = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $this->id);
        return $stmt->execute(); 
    }




    // دالة لاسترجاع جميع المقالات
    public function getAllPosts() {
        $query = "SELECT p.id, p.title, u.username AS author, p.created_at, p.updated_at, p.image 
                  FROM posts p
                  JOIN users u ON p.user_id = u.id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    //  دالة لإحصاء عدد المقالات لجميع المستخدمين
    public function getPostCountForAllUsers() {
        $query = "SELECT COUNT(*) AS count FROM posts";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'];
    }

    // دالة لاستخراج تواريخ المقالات للرسم البياني
    public function getPostLabels() {
        $query = "SELECT DATE(created_at) AS post_date FROM posts GROUP BY post_date ORDER BY post_date";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return array_column($stmt->fetchAll(PDO::FETCH_ASSOC), 'post_date');
    }

    // دالة لاستخراج بيانات المقالات للرسم البياني
    public function getPostData() {
        $query = "SELECT DATE(created_at) AS post_date, COUNT(*) AS post_count 
                  FROM posts 
                  GROUP BY post_date 
                  ORDER BY post_date";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return array_column($stmt->fetchAll(PDO::FETCH_ASSOC), 'post_count');
    }
    
}



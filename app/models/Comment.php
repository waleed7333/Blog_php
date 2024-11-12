<?php
// v_blog/app/models/Comment.php

class Comment
{
    private $conn;
    private $table = "comments";

    public $id;
    public $post_id;
    public $user_id;
    public $content;
    public $created_at;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Create a new comment
    public function createComment_Model()
    {
        $query = "INSERT INTO " . $this->table . " 
                    (post_id, user_id, content, created_at) 
                    VALUES (:post_id, :user_id, :content, NOW())";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":post_id", $this->post_id);
        $stmt->bindParam(":user_id", $this->user_id);
        $stmt->bindParam(":content", $this->content);

        return $stmt->execute();
    }

    // Retrieve comments by post ID
    public function getByPostId_Model($post_id)
{
    $query = "SELECT c.*, u.username 
                FROM " . $this->table . " c
                LEFT JOIN users u ON c.user_id = u.id
                WHERE c.post_id = :post_id
                ORDER BY c.created_at DESC";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(":post_id", $post_id);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// استرجاع التعليقات الخاصة بالمستخدم
    public function getCommentsByUserId_Model() {
        $query = "SELECT * FROM comments WHERE user_id = :user_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $this->id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // دالة للحصول على عدد التعليقات الخاصة بالمستخدم
    public function getCommentsCountForUser_Model($user_id) {
    $query = "SELECT COUNT(*) as count FROM comments WHERE user_id = :user_id";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['count'];
}

    // Update an existing comment
    public function updateComment_Model($comment_id, $content, $user_id)
    {
        $query = "UPDATE " . $this->table . " 
                    SET content = :content 
                    WHERE id = :comment_id AND user_id = :user_id";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":content", $content);
        $stmt->bindParam(":comment_id", $comment_id);
    $stmt->bindParam(":user_id", $user_id);

        return $stmt->execute();
    }

    // Delete a comment
    public function deleteComment_Model($comment_id, $user_id)
    {
        $query = "DELETE FROM " . $this->table . " 
                    WHERE id = :comment_id AND user_id = :user_id";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":comment_id", $comment_id);
        $stmt->bindParam(":user_id", $user_id);

        return $stmt->execute();
    }

    // DASHBIARD

    // دالة لإحصاء عدد التعليقات
    public function getCommentCount() {
        $query = "SELECT COUNT(*) AS count FROM comments";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'];
    }

    // دالة لاستخراج تواريخ التعليقات للرسم البياني
    public function getCommentLabels() {
        $query = "SELECT DATE(created_at) AS comment_date FROM comments GROUP BY comment_date ORDER BY comment_date";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return array_column($stmt->fetchAll(PDO::FETCH_ASSOC), 'comment_date');
    }

    // دالة لاستخراج بيانات التعليقات للرسم البياني
    public function getCommentData() {
        $query = "SELECT DATE(created_at) AS comment_date, COUNT(*) AS comment_count 
                    FROM comments 
                    GROUP BY comment_date 
                    ORDER BY comment_date";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return array_column($stmt->fetchAll(PDO::FETCH_ASSOC), 'comment_count');
    }

}
?>

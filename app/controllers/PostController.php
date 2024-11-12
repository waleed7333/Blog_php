    <?php
    // v_blog/app/controllers/PostController.php  2
    ?>

    <?php
    require_once __DIR__ . '/../models/Post.php';
    require_once __DIR__ . '/../models/Comment.php';

    class PostController
    {
        private $db;
        private $post;
        private $commentModel;
        public function __construct()
        {
            $database = new Database();
            $this->db = $database->getConnection();
            $this->post = new Post($this->db);
            $this->commentModel = new Comment($this->db);
        }

        public function index()
        {
            $stmt = $this->post->read();
            $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

            require_once __DIR__ . '/../views/posts/index.php';
        }

        public function show($id)
        {
            $post = $this->post->getPostByPostId($id);
            if ($post) {
                $comments = $this->commentModel->getByPostId_Model($id);
                require_once __DIR__ . '/../views/posts/show.php';
            } else {
                require_once __DIR__ . '/../views/errors/404.php';
            }
        }


        public function create()
        {
            $categories = $this->getCategories(); // استرجاع الفئات من قاعدة البيانات

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $categoryId = $this->handleCategorySelection();

                // إعداد القيم قبل الإنشاء
                $this->post->title = $_POST['title'];
                $this->post->content = $_POST['content'];
                $this->post->user_id = $_SESSION['user_id']; // من الجلسة الحالية
                $this->post->category_id = $categoryId; // استخدم $categoryId المحدثة
                $this->post->image = $this->uploadImage(); // رفع الصورة إذا كانت موجودة

                // محاولة إنشاء البوست الجديد
                if ($this->post->create()) {
                    $showModal = true;
                    require_once __DIR__ . '/../views/posts/create.php';
                    exit();
                } else {
                    echo "Error creating post";
                }
            }

            // عرض النموذج مع الفئات
            require_once __DIR__ . "/../views/posts/create.php";
        }



        public function update($id)
        {
            $post = $this->post->getPostByPostId($id);
            $categories = $this->getCategories();
            $base_url = "http://localhost/v_blog/public";
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $this->post->id = $id;
                $this->post->title = $_POST['title'];
                $this->post->content = $_POST['content'];
                $this->post->category_id = $_POST['category_id'];
                $this->post->image = $this->uploadImage();

                if ($this->post->updatePost()) {
                    $_SESSION['success'] = 'Post updated successfully!';
                    header("Location: " . $base_url . "/posts/show/" . $id);
                    exit();
                } else {
                    echo "Error updating post";
                }
            }

            require_once __DIR__ . '/../views/posts/update.php';
        }

        public function destroy($id)
        {
            $base_url = "http://localhost/v_blog/public";
            if ($this->post->getPostByPostId($id)) {
                $this->post->id = $id;
                if ($this->post->delete()) {
                    $_SESSION['success'] = 'Post deleted successfully!';
                } else {
                    $_SESSION['error'] = 'Error deleting post. Please try again.';
                }
                header("Location: " . $base_url . "/posts");
                exit;
            } else {
                $_SESSION['error'] = 'Post not found.';
                header("Location: " . $base_url . "/posts");
                exit;
            }
        }

        private function getCategories()
        {
            $stmt = $this->db->query("SELECT * FROM categories");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        private function uploadImage()
        {
            if (!empty($_FILES['image']['name'])) {
                $imageName = $_FILES['image']['name'];
                $targetDir = __DIR__ . '/../../public/images/';
                move_uploaded_file($_FILES['image']['tmp_name'], $targetDir . $imageName);
                return $imageName;
            }
            return null;
        }

        private function handleCategorySelection()
        {
            if (!empty($_POST['new_category'])) {
                $newCategory = $_POST['new_category'];
                $stmt = $this->db->prepare("SELECT id FROM categories WHERE name = :name LIMIT 1");
                $stmt->bindParam(':name', $newCategory);
                $stmt->execute();
                $existingCategory = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($existingCategory) {
                    return $existingCategory['id'];
                } else {
                    $stmt = $this->db->prepare("INSERT INTO categories (name) VALUES (:name)");
                    $stmt->bindParam(':name', $newCategory);
                    if ($stmt->execute()) {
                        return $this->db->lastInsertId();
                    } else {
                        echo "Error adding new category";
                        return null;
                    }
                }
            } else {
                return $_POST['category_id'];
            }
        }
    }

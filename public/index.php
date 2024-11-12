<?php
// v_blog/public/index.php

session_start();

require_once "../config/database.php";
require_once "../app/models/User.php";
require_once "../app/models/Post.php";
require_once "../app/models/Comment.php";
require_once "../app/controllers/HomeController.php";
require_once "../app/controllers/UserController.php";
require_once "../app/controllers/PostController.php";
require_once "../app/controllers/CommentController.php";
require_once "../app/controllers/AdminController.php";

// معالجة الراوتر البسيط
$base_folder = '/v_blog/public';
$request = str_replace($base_folder, '', $_SERVER['REQUEST_URI']);
$request = strtok($request, '?');
$request = trim($request, '/');

if (empty($request)) {
    $request = 'home';
}

switch ($request) {
    case 'home':
        $controller = new HomeController();
        $controller->index();
        break;

    case 'login':
        $controller = new UserController();
        $controller->login();
        break;

    case 'register':
        $controller = new UserController();
        $controller->register();
        break;

    case (preg_match('/^profile\/\d+$/', $request) ? true : false):
        $id = (int) substr($request, 8);
        $controller = new UserController();
        $controller->profile($id);
        break;

    // case (preg_match('/^updateProfile\/\d+$/', $request) ? true : false):
    //     $id = (int) substr($request, 14);
    //     $controller = new UserController();
    //     $controller->profile($id);
    //     break;

    case (preg_match('/^upgradeAdmin\/\d+$/', $request) ? true : false):
        $id = (int) substr($request, 13);
        $controller = new UserController();
        $controller->upgradeAdmin($id);
        break;

    case (preg_match('/^downgradeAdmin\/\d+$/', $request) ? true : false):
        $id = (int) substr($request, 15);
        $controller = new UserController();
        $controller->downgradeAdmin($id);
        break;

    case (preg_match('/^changePassword\/\d+$/', $request) ? true : false):
        $id = (int) substr($request, 15);
        $controller = new UserController();
        $controller->updatePassword($id);
        break;

    case 'logout':
        session_destroy();
        header("Location: ./");
        break;

    case 'posts':
        $controller = new PostController();
        $controller->index();
        break;

        // router.php

    case (preg_match('/^posts\/show\/\d+$/', $request) ? true : false):
        $id = (int) substr($request, 11);
        $controller = new PostController();
        $controller->show($id);
        break;


    case 'posts/create':
        $controller = new PostController();
        $controller->create();
        break;

    case (preg_match('/^posts\/update\/\d+$/', $request) ? true : false):
        $id = (int) substr($request, 13);
        $controller = new PostController();
        $controller->update($id);
        break;

    case (preg_match('/^posts\/delete\/\d+$/', $request) ? true : false):
        $id = (int) substr($request, 13);
        $controller = new PostController();
        $controller->destroy($id);
        break;

        // Routes for Comments
    case 'comments/create':
        $controller = new CommentController();
        $controller->createComment_Controller();
        break;

    case'comments/edit':
        $controller = new CommentController();
        $controller->editComment_Controller($comment_id);
        break;

    // case (preg_match('/^comments\/edit\/\d+$/', $request) ? true : false):
    //     $comment_id = (int) substr($request, 14);
    //     $controller = new CommentController();
    //     $controller->editComment_Controller($comment_id);
    //     break;

    case 'comments/delete':
        $controller = new CommentController();
        $controller->deleteComment_Controller();
        break;

    // case (preg_match('/^comments\/delete\/\d+$/', $request) ? true : false):
    //     $comment_id = (int) substr($request, 1);
    //     $controller = new CommentController();
    //     $controller->deleteComment_Controller($comment_id);
    //     break;

    case 'admin/dashboard':
        $controller = new AdminController();
        $controller->dashboard();
        break;

    // case 'admin/manage_users':
    //     $controller = new AdminController();
    //     $controller->manageUsers();
    //     break;

    // case 'admin/manage_posts':
    //     $controller = new AdminController();
    //     $controller->managePosts();
    //     break;

    default:
        header("HTTP/1.0 404 Not Found");
        require_once "../app/views/errors/404.php";
        break;
}

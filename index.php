<?php

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

use App\Application;
use App\Config;
use App\Controllers\AdminController;
use App\Controllers\HomeController;
use App\Controllers\LoginController;
use App\Controllers\StaticPageController;
use App\Controllers\ProfileController;
use App\Controllers\RequestController;
use App\Controllers\AdminUserController;
use App\Controllers\AdminPostController;
use App\Controllers\AdminSubscrController;
use App\Controllers\AdminCommentController;
use App\Controllers\AdminPageController;
use App\Router;
use App\Session;

require_once __DIR__ . '/bootstrap.php';
//обновление кук на каждой странице
if (!empty(Session::getCookie('email'))) {
    Session::setCookie('email', Session::getCookie('email'));
}

$router = new Router();
//главная страница
$router->get('', [HomeController::class, 'index']);
//запрос для постраничной навигации
$router->get('?page=*', [HomeController::class, 'page']);
//статичная страница
$router->get('about', [StaticPageController::class, 'about']);
//роутинг для страницы отписки
$router->get('unsubscribe', [StaticPageController::class, 'unsubscribe']);
//статичные страницы по id
$router->get('static/pages/*', [StaticPageController::class, 'pageById']);
//статичные страницы по slug
$router->get('static/%', [StaticPageController::class, 'pageBySlug']);
//детальная страница статьи
$router->get('posts/*', [HomeController::class, 'post']);
//переход в авторизацию
$router->get('auth', [LoginController::class, 'authorization']);
$router->post('auth', [LoginController::class, 'authorization']);
//переход в регистрацию
$router->get('reg', [LoginController::class, 'registration']);
$router->post('reg', [LoginController::class, 'registration']);
//разлогирование пользователя
$router->get('logout', [Session::class, 'logout']);
//личный кабинет
$router->get('lk', [ProfileController::class, 'changeProfile']);
$router->post('lk', [ProfileController::class, 'changeProfile']);
//запрос на контроллер Request
$router->post('request', [RequestController::class, 'subscription']);
$router->post('request/comment', [RequestController::class, 'comment']);
$router->post('request/moderationComment', [RequestController::class, 'moderation']);
$router->post('request/unsubscribe', [RequestController::class, 'unsubscribe']);

//роутинг для интерфейса управления
$router->get('admin/users', [AdminController::class, 'usersManagement']);
//запрос для постраничной навигации в пользователях
$router->get('admin/users?page=*&count=*', [AdminController::class, 'usersManagement']);

$router->get('admin/posts', [AdminController::class, 'postsManagement']);
//запрос для постраничной навигации в статьях
$router->get('admin/posts?page=*&count=*', [AdminController::class, 'postsManagement']);

$router->get('admin/subscriptions', [AdminController::class, 'subscriptionsManagement']);
//запрос для постраничной навигации у подписчиков
$router->get('admin/subscriptions?pageNoAuth=*&countNoAuth=*&pageAuth=*&countAuth=*', [AdminController::class, 'subscriptionsManagement']);

$router->get('admin/comments', [AdminController::class, 'commentsManagement']);
//запрос для постраничной навигации в комментариях
$router->get('admin/comments?page=*&count=*', [AdminController::class, 'commentsManagement']);

$router->get('admin/pages', [AdminController::class, 'pagesManagement']);
//запрос для постраничной навигации на списке страниц
$router->get('admin/pages?page=*&count=*', [AdminController::class, 'pagesManagement']);

$router->get('admin/settings', [AdminController::class, 'settingsManagement']);
$router->post('admin/settings', [AdminController::class, 'settingsManagement']);

//роутинг изменения пользователя из админки
$router->get('admin/users/*', [AdminUserController::class, 'changeUser']);
$router->post('admin/users/*', [AdminUserController::class, 'changeUser']);
//удаление пользователя из базы данных с помощью админки
$router->post('admin/userDelete', [AdminUserController::class, 'deleteUser']);
//роутинг для статей из панели администратора
$router->get('admin/posts/*', [AdminPostController::class, 'changePost']);
$router->post('admin/posts/*', [AdminPostController::class, 'changePost']);
$router->get('admin/add/post', [AdminPostController::class, 'addPost']);
$router->post('admin/add/post', [AdminPostController::class, 'addPost']);
$router->post('admin/postDelete', [AdminPostController::class, 'deletePost']);
//роутинг для управления подпиской из панели администратора
$router->post('admin/subscrDeleteNoAuth', [AdminSubscrController::class, 'deleteSubscrNoAuth']);
$router->post('admin/subscrDeleteAuth', [AdminSubscrController::class, 'deleteSubscrAuth']);
//роутинг для управления комментариями из панели администратора
$router->get('admin/comments/*', [AdminCommentController::class, 'changeComment']);
$router->post('admin/comments/*', [AdminCommentController::class, 'changeComment']);
$router->post('admin/commentDelete', [AdminCommentController::class, 'deleteComment']);
//роутинг для управления статическими страницами из панели администратора
$router->get('admin/add/page', [AdminPageController::class, 'addPage']);
$router->post('admin/add/page', [AdminPageController::class, 'addPage']);
$router->get('admin/pages/*', [AdminPageController::class, 'changePage']);
$router->post('admin/pages/*', [AdminPageController::class, 'changePage']);
$router->post('admin/pageDelete', [AdminPageController::class, 'deletePage']);

$application = new Application($router);

$application->run($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);

<?php
require '../vendor/autoload.php';

if (isset($_GET['page']) && $_GET['page'] === '1') {
    $url = explode('?', $_SERVER['REQUEST_URI'])[0];
    unset($_GET['page']);
    $query = http_build_query($_GET);
    $url = $url . (empty($query) ? '' : '?' . $query);
    header('Location: ' . $url);
    http_response_code(301);
    exit();
}

$app = new App\App(true);

$router = new App\Router(dirname(__DIR__) . '/views', $app);
$router
    ->get('/', 'post/index', 'home')
    ->get('/blog/[*:slug]-[i:id]', 'post/show', 'post')
    ->get('/blog/category', 'category/show', 'category')
    ->run();

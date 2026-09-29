<?php

session_set_cookie_params(['httponly' => true, 'samesite' => 'Lax']);
session_start();

require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/app/Services/ProductService.php';
require_once __DIR__ . '/app/Services/UserService.php';

$action = $_GET['action'] ?? '';

if ($action === '') {
    header('Location: pages/index.html');
    exit;
}

function sendJson($data, $status = 200)
{
    http_response_code($status);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    exit;
}

function postValue($key)
{
    if (isset($_POST[$key]) && is_string($_POST[$key])) {
        return $_POST[$key];
    }
    return '';
}

$db = getConnection();
$productService = new ProductService($db);
$userService = new UserService($db);
$isPost = $_SERVER['REQUEST_METHOD'] === 'POST';

if ($action === 'products') {
    sendJson($productService->getAll());
}

if ($action === 'product') {
    $product = $productService->getById((int) ($_GET['id'] ?? 0));

    if (!$product) {
        sendJson(['error' => 'Produsul nu a fost găsit.'], 404);
    }

    sendJson($product);
}

if ($action === 'register' && $isPost) {
    $error = $userService->register(
        postValue('name'),
        postValue('email'),
        postValue('password'),
        postValue('password_confirm')
    );

    if ($error) {
        sendJson(['error' => $error], 400);
    }

    $user = $userService->findByEmail(postValue('email'));
    session_regenerate_id(true);
    $_SESSION['user_id'] = $user->id;

    sendJson(['success' => true]);
}

if ($action === 'login' && $isPost) {
    $user = $userService->login(postValue('email'), postValue('password'));

    if (!$user) {
        sendJson(['error' => 'Email sau parolă greșită.'], 401);
    }

    session_regenerate_id(true);
    $_SESSION['user_id'] = $user->id;

    sendJson(['success' => true]);
}

if ($action === 'user') {
    $user = null;

    if (isset($_SESSION['user_id'])) {
        $user = $userService->findById($_SESSION['user_id']);
    }

    sendJson(['user' => $user]);
}

if ($action === 'logout' && $isPost) {
    $_SESSION = [];
    session_destroy();

    sendJson(['success' => true]);
}

sendJson(['error' => 'Pagina nu a fost găsită.'], 404);

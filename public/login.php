<?php
session_start();

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/helpers.php';

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

$loader = new FilesystemLoader(__DIR__ . '/../templates');
$twig   = new Environment($loader);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if ($username === 'admin' && $password === 'test') {
        $_SESSION['user'] = 'admin';
        flash('success', 'Login successful.');
        header('Location: admin.php');
        exit;
    } else {
        flash('error', 'Invalid login credentials.');
        header('Location: login.php');
        exit;
    }
}

$flash_success = get_flash('success');
$flash_error   = get_flash('error');

echo $twig->render('login.twig', [
    'flash_success' => $flash_success,
    'flash_error'   => $flash_error
]);

<?php
session_start();

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/helpers.php';

use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use User\CgrdassignmentPapeSari\Database;
use User\CgrdassignmentPapeSari\NewsService;

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

$loader = new FilesystemLoader(__DIR__ . '/../templates');
$twig   = new Environment($loader);

$db          = Database::getConnection();
$newsService = new NewsService($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action  = $_POST['action'] ?? '';
    $title   = trim($_POST['title'] ?? '');
    $content = trim($_POST['content'] ?? '');
    $id      = (int)($_POST['id'] ?? 0);

    switch ($action) {
        case 'delete':
            $deleteId = (int)($_POST['delete_id'] ?? 0);
            if ($deleteId > 0) {
                $success = $newsService->delete($deleteId);
                flash($success ? 'success' : 'error', $success ? 'News was deleted.' : 'Error during deletion.');
            } else {
                flash('error', 'Invalid ID to delete.');
            }
            break;

        case 'edit':
            if ($id > 0 && $title !== '' && $content !== '') {
                $success = $newsService->update($id, $title, $content);
                flash($success ? 'success' : 'error', $success ? 'News successfully updated.' : 'Error while updating.');
            } else {
                flash('error', 'The title and content cannot be empty.');
            }
            break;

        case 'create':
        default:
            if ($id > 0) { 
                if ($title !== '' && $content !== '') {
                    $success = $newsService->update($id, $title, $content);
                    flash($success ? 'success' : 'error', $success ? 'News successfully updated.' : 'Error while updating.');
                } else {
                    flash('error', 'The title and content cannot be empty.');
                }
            } else {
                if ($title !== '' && $content !== '') {
                    $success = $newsService->create($title, $content);
                    flash($success ? 'success' : 'error', $success ? 'News successfully created.' : 'Error during creation.');
                } else {
                    flash('error', 'The title and content cannot be empty.');
                }
            }
            break;
    }

    header('Location: ' . $_SERVER['REQUEST_URI']);
    exit;
}

$newsList      = $newsService->getAll();
$flash_success = get_flash('success');
$flash_error   = get_flash('error');

echo $twig->render('admin.twig', [
    'username'      => $_SESSION['user'],
    'newsList'      => $newsList,
    'flash_success' => $flash_success,
    'flash_error'   => $flash_error
]);

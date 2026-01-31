<?php
session_start();
require_once __DIR__ . '/../includes/auth_check.php';
require_once __DIR__ . '/../classes/News.php';

$id = (int)($_GET['id'] ?? 0);
if ($id) {
    $newsModel = new News();
    $newsModel->delete($id);
}
header('Location: dashboard.php?deleted=1');
exit;

<?php
session_start();
require_once __DIR__ . '/../includes/auth_check.php';
require_once __DIR__ . '/../classes/Job.php';

$id = (int)($_GET['id'] ?? 0);
if ($id) {
    $jobModel = new Job();
    $jobModel->delete($id);
}
header('Location: dashboard.php?deleted=1');
exit;

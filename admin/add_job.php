<?php
session_start();
require_once __DIR__ . '/../includes/auth_check.php';
require_once __DIR__ . '/../classes/Job.php';

$jobModel = new Job();
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $company = trim($_POST['company'] ?? '');
    $location = trim($_POST['location'] ?? '');
    $sortOrder = (int)($_POST['sort_order'] ?? 0);

    if ($title === '' || $company === '' || $location === '') {
        $error = 'Plotësoni titullin, kompaninë dhe lokacionin.';
    } else {
        if ($jobModel->add($title, $company, $location, $sortOrder)) {
            header('Location: dashboard.php?saved=1');
            exit;
        }
        $error = 'Gabim gjatë ruajtjes.';
        if ($jobModel->getLastError() !== null) {
            $error .= ' (' . htmlspecialchars($jobModel->getLastError()) . ')';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="sq">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shto punë</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 1rem; max-width: 600px; }
        .error { color: #b91c1c; margin-bottom: 1rem; }
        label { display: block; margin-top: 0.75rem; font-weight: 600; }
        input[type="text"], input[type="number"] { width: 100%; padding: 0.5rem; margin-top: 0.25rem; }
        button { margin-top: 1rem; padding: 0.5rem 1rem; background: #2563eb; color: #fff; border: none; border-radius: 6px; cursor: pointer; }
        a { color: #2563eb; margin-left: 1rem; }
    </style>
</head>
<body>
    <h1>Shto punë</h1>
    <?php if ($error): ?><p class="error"><?= htmlspecialchars($error) ?></p><?php endif; ?>
    <form method="POST" action="">
        <label>Titulli *</label>
        <input type="text" name="title" value="<?= htmlspecialchars($_POST['title'] ?? '') ?>" required>
        <label>Kompania *</label>
        <input type="text" name="company" value="<?= htmlspecialchars($_POST['company'] ?? '') ?>" required>
        <label>Lokacioni *</label>
        <input type="text" name="location" value="<?= htmlspecialchars($_POST['location'] ?? '') ?>" required>
        <label>Rendi (numër)</label>
        <input type="number" name="sort_order" value="<?= htmlspecialchars($_POST['sort_order'] ?? '0') ?>" min="0">
        <button type="submit">Ruaj</button>
        <a href="dashboard.php">Anulo</a>
    </form>
</body>
</html>

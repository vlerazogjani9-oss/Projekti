<?php
session_start();
require_once __DIR__ . '/../includes/auth_check.php';
require_once __DIR__ . '/../classes/Job.php';

$id = (int)($_GET['id'] ?? 0);
if (!$id) { header('Location: dashboard.php'); exit; }

$jobModel = new Job();
$item = $jobModel->getById($id);
if (!$item) { header('Location: dashboard.php'); exit; }

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $company = trim($_POST['company'] ?? '');
    $location = trim($_POST['location'] ?? '');
    $sortOrder = (int)($_POST['sort_order'] ?? 0);

    if ($title === '' || $company === '' || $location === '') {
        $error = 'Plotësoni titullin, kompaninë dhe lokacionin.';
    } else {
        if ($jobModel->update($id, $title, $company, $location, $sortOrder)) {
            header('Location: dashboard.php?saved=1');
            exit;
        }
        $error = 'Gabim gjatë ruajtjes.';
    }
} else {
    $title = $item['title'];
    $company = $item['company'];
    $location = $item['location'];
    $sortOrder = (int)$item['sort_order'];
}
?>
<!DOCTYPE html>
<html lang="sq">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ndrysho punë</title>
    <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body>
    <header class="admin-header">
        <h1>PUNA IME – Menaxhimi</h1>
        <nav class="admin-header-nav">
            <a href="../index.php">Kryefaqja</a>
            <a href="dashboard.php">Dashboard</a>
            <a href="../auth/logout.php">Dil</a>
        </nav>
    </header>
    <div class="admin-form-wrap admin-main">
    <h1>Ndrysho punë</h1>
    <?php if ($error): ?><p class="error"><?= htmlspecialchars($error) ?></p><?php endif; ?>
    <form method="POST" action="">
        <label>Titulli *</label>
        <input type="text" name="title" value="<?= htmlspecialchars($title ?? '') ?>" required>
        <label>Kompania *</label>
        <input type="text" name="company" value="<?= htmlspecialchars($company ?? '') ?>" required>
        <label>Lokacioni *</label>
        <input type="text" name="location" value="<?= htmlspecialchars($location ?? '') ?>" required>
        <label>Rendi (numër)</label>
        <input type="number" name="sort_order" value="<?= (int)($sortOrder ?? 0) ?>" min="0">
        <div class="form-actions">
            <button type="submit">Ruaj</button>
            <a href="dashboard.php">Anulo</a>
        </div>
    </form>
    </div>
</body>
</html>

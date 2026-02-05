<?php
session_start();
require_once __DIR__ . '/../includes/auth_check.php';
require_once __DIR__ . '/../classes/Job.php';

$jobModel = new Job(); //krijimi i objektit nga klasa Job dhe thrret metoda si add() per te shtuar nje pune te re 
$error = ''; // variabel per ruajtjen e mesazhit te gabimit nese ka

if ($_SERVER['REQUEST_METHOD'] === 'POST') { //kontrollon nese forma eshte derguar me metod POST, dhe nese po, merr vlerat e fusheve te formes, i pastron ato
    $title = trim($_POST['title'] ?? ''); // $title merr vleren e fushes title, trim heq hapesirat e panevojshme nga fillimi dhe fundi i stringut, dhe ?? '' siguron qe nese fusha nuk eshte e vendosur, $title do te jete nje string bosh
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
        <div class="form-actions">
            <button type="submit">Ruaj</button>
            <a href="dashboard.php">Anulo</a>
        </div>
    </form>
    </div>
</body>
</html>

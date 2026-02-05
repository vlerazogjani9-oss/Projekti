<?php
session_start();
require_once __DIR__ . '/../includes/auth_check.php';
require_once __DIR__ . '/../classes/News.php';
require_once __DIR__ . '/../classes/Validator.php';

$newsModel = new News();
$validator = new Validator();
$error = '';
$uploadDir = __DIR__ . '/../uploads/news/';
if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);

$allowedImage = ['image/jpeg', 'image/png', 'image/gif'];
$allowedPdf = ['application/pdf'];
$maxSize = 5 * 1024 * 1024; // 5MB

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $body = trim($_POST['body'] ?? '');
    $imageName = null;
    $fileName = null;

    if (!$validator->validateNewsProduct(['title' => $title, 'body' => $body])) {
        $error = $validator->getFirstError();
    } else {
        if (!empty($_FILES['image']['name'])) {
            $finfo = new finfo(FILEINFO_MIME_TYPE);
            $mime = $finfo->file($_FILES['image']['tmp_name']);
            if (!in_array($mime, $allowedImage) || $_FILES['image']['size'] > $maxSize) {
                $error = 'Imazhi duhet të jetë JPG/PNG/GIF dhe max 5MB.';
            } else {
                $imageName = basename($_FILES['image']['name']);
                $imageName = preg_replace('/[^a-zA-Z0-9._-]/', '_', $imageName);
                $imageName = time() . '_' . $imageName;
                if (!move_uploaded_file($_FILES['image']['tmp_name'], $uploadDir . $imageName)) $error = 'Gabim ngarkimi të imazhit.';
            }
        }
        if ($error === '' && !empty($_FILES['file']['name'])) {
            $finfo = new finfo(FILEINFO_MIME_TYPE);
            $mime = $finfo->file($_FILES['file']['tmp_name']);
            if ($mime !== 'application/pdf' || $_FILES['file']['size'] > $maxSize) {
                $error = 'Skedari duhet të jetë PDF dhe max 5MB.';
            } else {
                $fileName = basename($_FILES['file']['name']);
                $fileName = preg_replace('/[^a-zA-Z0-9._-]/', '_', $fileName);
                $fileName = time() . '_' . $fileName;
                if (!move_uploaded_file($_FILES['file']['tmp_name'], $uploadDir . $fileName)) $error = 'Gabim ngarkimi të PDF.';
            }
        }
        if ($error === '' && (isset($imageName) || isset($fileName))) {
            if ($newsModel->add($title, $body, $imageName, $fileName, (int)$_SESSION['user']['id'])) {
                header('Location: dashboard.php?saved=1');
                exit;
            }
            $error = 'Gabim gjatë ruajtjes.';
        } elseif ($error === '') {
            $error = 'Shtoni të paktën një imazh ose një skedar PDF.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="sq">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shto lajm</title>
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
    <h1>Shto lajm</h1>
    <?php if ($error): ?><p class="error"><?= htmlspecialchars($error) ?></p><?php endif; ?>
    <form method="POST" action="" enctype="multipart/form-data">
        <label>Titulli *</label>
        <input type="text" name="title" value="<?= htmlspecialchars($_POST['title'] ?? '') ?>" required>
        <label>Përmbajtja *</label>
        <textarea name="body" required><?= htmlspecialchars($_POST['body'] ?? '') ?></textarea>
        <label>Imazh (JPG/PNG/GIF, max 5MB)</label>
        <input type="file" name="image" accept="image/jpeg,image/png,image/gif">
        <label>Skedar PDF (opsional, max 5MB)</label>
        <input type="file" name="file" accept="application/pdf">
        <div class="form-actions">
            <button type="submit">Ruaj</button>
            <a href="dashboard.php">Anulo</a>
        </div>
    </form>
    </div>
</body>
</html>

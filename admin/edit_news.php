<?php
session_start();
require_once __DIR__ . '/../includes/auth_check.php';
require_once __DIR__ . '/../classes/News.php';
require_once __DIR__ . '/../classes/Validator.php';

$id = (int)($_GET['id'] ?? 0);
if (!$id) { header('Location: dashboard.php'); exit; }

$newsModel = new News();
$item = $newsModel->getById($id);
if (!$item) { header('Location: dashboard.php'); exit; }

$validator = new Validator();
$error = '';
$uploadDir = __DIR__ . '/../uploads/news/';
if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);

$allowedImage = ['image/jpeg', 'image/png', 'image/gif'];
$maxSize = 5 * 1024 * 1024;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $body = trim($_POST['body'] ?? '');
    $imageName = $item['image'];
    $fileName = $item['file'];

    if (!$validator->validateNewsProduct(['title' => $title, 'body' => $body])) {
        $error = $validator->getFirstError();
    } else {
        if (!empty($_FILES['image']['name'])) {
            $finfo = new finfo(FILEINFO_MIME_TYPE);
            $mime = $finfo->file($_FILES['image']['tmp_name']);
            if (!in_array($mime, $allowedImage) || $_FILES['image']['size'] > $maxSize) {
                $error = 'Imazhi duhet të jetë JPG/PNG/GIF dhe max 5MB.';
            } else {
                $imageName = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '_', basename($_FILES['image']['name']));
                if (!move_uploaded_file($_FILES['image']['tmp_name'], $uploadDir . $imageName)) $error = 'Gabim ngarkimi.';
            }
        }
        if ($error === '' && !empty($_FILES['file']['name'])) {
            $finfo = new finfo(FILEINFO_MIME_TYPE);
            $mime = $finfo->file($_FILES['file']['tmp_name']);
            if ($mime !== 'application/pdf' || $_FILES['file']['size'] > $maxSize) {
                $error = 'Skedari duhet të jetë PDF, max 5MB.';
            } else {
                $fileName = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '_', basename($_FILES['file']['name']));
                if (!move_uploaded_file($_FILES['file']['tmp_name'], $uploadDir . $fileName)) $error = 'Gabim ngarkimi PDF.';
            }
        }
        if ($error === '' && $newsModel->update($id, $title, $body, $imageName ?: null, $fileName ?: null, (int)$_SESSION['user']['id'])) {
            header('Location: dashboard.php?saved=1');
            exit;
        }
        if ($error === '') $error = 'Gabim gjatë ruajtjes.';
    }
} else {
    $title = $item['title'];
    $body = $item['body'];
}
?>
<!DOCTYPE html>
<html lang="sq">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ndrysho lajm</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 1rem; max-width: 600px; }
        .error { color: #b91c1c; margin-bottom: 1rem; }
        label { display: block; margin-top: 0.75rem; font-weight: 600; }
        input[type="text"], textarea { width: 100%; padding: 0.5rem; margin-top: 0.25rem; }
        textarea { min-height: 120px; }
        button { margin-top: 1rem; padding: 0.5rem 1rem; background: #2563eb; color: #fff; border: none; border-radius: 6px; cursor: pointer; }
        a { color: #2563eb; margin-left: 1rem; }
    </style>
</head>
<body>
    <h1>Ndrysho lajm</h1>
    <?php if ($error): ?><p class="error"><?= htmlspecialchars($error) ?></p><?php endif; ?>
    <form method="POST" action="" enctype="multipart/form-data">
        <label>Titulli *</label>
        <input type="text" name="title" value="<?= htmlspecialchars($title ?? '') ?>" required>
        <label>Përmbajtja *</label>
        <textarea name="body" required><?= htmlspecialchars($body ?? '') ?></textarea>
        <label>Imazh (JPG/PNG/GIF)</label>
        <input type="file" name="image" accept="image/jpeg,image/png,image/gif">
        <?php if (!empty($item['image'])): ?><p>Imazhi aktual: <?= htmlspecialchars($item['image']) ?></p><?php endif; ?>
        <label>PDF</label>
        <input type="file" name="file" accept="application/pdf">
        <?php if (!empty($item['file'])): ?><p>Skedari aktual: <?= htmlspecialchars($item['file']) ?></p><?php endif; ?>
        <button type="submit">Ruaj</button>
        <a href="dashboard.php">Anulo</a>
    </form>
</body>
</html>

<?php
session_start();
require_once __DIR__ . '/../includes/auth_check.php';
require_once __DIR__ . '/../classes/Product.php';
require_once __DIR__ . '/../classes/Validator.php';

$productModel = new Product();
$validator = new Validator();
$error = '';
$uploadDir = __DIR__ . '/../uploads/products/';
if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);

$allowedImage = ['image/jpeg', 'image/png', 'image/gif'];
$maxSize = 5 * 1024 * 1024;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $imageName = null;
    $fileName = null;

    if (!$validator->validateNewsProduct(['title' => $title, 'body' => $description, 'description' => $description])) {
        $error = $validator->getFirstError();
    } else {
        if (!empty($_FILES['image']['name'])) {
            $finfo = new finfo(FILEINFO_MIME_TYPE);
            $mime = $finfo->file($_FILES['image']['tmp_name']);
            if (!in_array($mime, $allowedImage) || $_FILES['image']['size'] > $maxSize) {
                $error = 'Imazhi duhet të jetë JPG/PNG/GIF dhe max 5MB.';
            } else {
                $imageName = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '_', basename($_FILES['image']['name']));
                if (!move_uploaded_file($_FILES['image']['tmp_name'], $uploadDir . $imageName)) $error = 'Gabim ngarkimi të imazhit.';
            }
        }
        if ($error === '' && !empty($_FILES['file']['name'])) {
            $finfo = new finfo(FILEINFO_MIME_TYPE);
            $mime = $finfo->file($_FILES['file']['tmp_name']);
            if ($mime !== 'application/pdf' || $_FILES['file']['size'] > $maxSize) {
                $error = 'Skedari duhet të jetë PDF dhe max 5MB.';
            } else {
                $fileName = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '_', basename($_FILES['file']['name']));
                if (!move_uploaded_file($_FILES['file']['tmp_name'], $uploadDir . $fileName)) $error = 'Gabim ngarkimi të PDF.';
            }
        }
        if ($error === '' && ($imageName || $fileName)) {
            if ($productModel->add($title, $description, $imageName, $fileName, (int)$_SESSION['user']['id'])) {
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
    <title>Shto produkt</title>
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
    <h1>Shto produkt</h1>
    <?php if ($error): ?><p class="error"><?= htmlspecialchars($error) ?></p><?php endif; ?>
    <form method="POST" action="" enctype="multipart/form-data">
        <label>Titulli *</label>
        <input type="text" name="title" value="<?= htmlspecialchars($_POST['title'] ?? '') ?>" required>
        <label>Përshkrimi *</label>
        <textarea name="description" required><?= htmlspecialchars($_POST['description'] ?? '') ?></textarea>
        <label>Imazh (JPG/PNG/GIF, max 5MB)</label>
        <input type="file" name="image" accept="image/jpeg,image/png,image/gif">
        <label>Skedar PDF (opsional, max 5MB)</label>
        <input type="file" name="file" accept="application/pdf">
        <button type="submit">Ruaj</button>
        <a href="dashboard.php">Anulo</a>
    </form>
</body>
</html>

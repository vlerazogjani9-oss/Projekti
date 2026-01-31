<?php
session_start();
require_once __DIR__ . '/../includes/auth_check.php';
require_once __DIR__ . '/../classes/Contact.php';
require_once __DIR__ . '/../classes/News.php';
require_once __DIR__ . '/../classes/Product.php';

$contactModel = new Contact();
$newsModel = new News();
$productModel = new Product();

$contacts = $contactModel->getAll();
$newsList = $newsModel->getAll();
$products = $productModel->getAll();
?>
<!DOCTYPE html>
<html lang="sq">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.boxicons.com/3.0.6/fonts/basic/boxicons.min.css" rel="stylesheet">
    <style>
        * { box-sizing: border-box; }
        body { font-family: Arial, sans-serif; margin: 0; padding: 1rem; background: #f1f5f9; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; flex-wrap: wrap; gap: 1rem; }
        .header h1 { margin: 0; font-size: 1.5rem; }
        .header a { color: #2563eb; text-decoration: none; }
        .section { background: #fff; border-radius: 8px; padding: 1rem; margin-bottom: 1.5rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1); overflow-x: auto; }
        .section h2 { margin: 0 0 1rem; font-size: 1.1rem; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 0.5rem 0.75rem; text-align: left; border-bottom: 1px solid #e2e8f0; }
        th { background: #f8fafc; font-weight: 600; }
        .btn { display: inline-block; padding: 0.35rem 0.75rem; border-radius: 6px; text-decoration: none; font-size: 0.875rem; border: none; cursor: pointer; }
        .btn-primary { background: #2563eb; color: #fff; }
        .btn-small { padding: 0.25rem 0.5rem; font-size: 0.8rem; }
        .btn-danger { background: #dc2626; color: #fff; }
        .stats { display: flex; gap: 1rem; flex-wrap: wrap; margin-bottom: 1rem; }
        .stat { background: #fff; padding: 1rem 1.5rem; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); }
        .stat strong { display: block; font-size: 1.5rem; color: #2563eb; }
        .empty { color: #64748b; padding: 1rem; }
        .message { padding: 0.5rem; margin-bottom: 1rem; border-radius: 6px; }
        .message.success { background: #dcfce7; color: #166534; }
        .message.error { background: #fee2e2; color: #991b1b; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Admin Dashboard</h1>
        <a href="../index.php">Kthehu në faqen kryesore</a>
    </div>

    <?php
    if (isset($_GET['deleted'])) echo '<div class="message success">U fshi me sukses.</div>';
    if (isset($_GET['saved'])) echo '<div class="message success">U ruajt me sukses.</div>';
    ?>

    <div class="stats">
        <div class="stat">Mesazhe kontakti: <strong><?= count($contacts) ?></strong></div>
        <div class="stat">Lajme: <strong><?= count($newsList) ?></strong></div>
        <div class="stat">Produkte: <strong><?= count($products) ?></strong></div>
    </div>

    <div class="section">
        <h2>Mesazhet e kontaktit</h2>
        <?php if (empty($contacts)): ?>
            <p class="empty">Nuk ka mesazhe.</p>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>Data</th>
                        <th>Emri</th>
                        <th>Email</th>
                        <th>Mesazhi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($contacts as $c): ?>
                        <tr>
                            <td><?= date('d.m.Y H:i', strtotime($c['created_at'])) ?></td>
                            <td><?= htmlspecialchars($c['name']) ?></td>
                            <td><?= htmlspecialchars($c['email']) ?></td>
                            <td><?= nl2br(htmlspecialchars(mb_substr($c['message'], 0, 200))) ?><?= mb_strlen($c['message']) > 200 ? '…' : '' ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>

    <div class="section">
        <h2>Lajmet <a href="add_news.php" class="btn btn-primary btn-small">Shto lajm</a></h2>
        <?php if (empty($newsList)): ?>
            <p class="empty">Nuk ka lajme.</p>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>Titulli</th>
                        <th>Shtuar nga</th>
                        <th>Data</th>
                        <th>Veprime</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($newsList as $n): ?>
                        <tr>
                            <td><?= htmlspecialchars($n['title']) ?></td>
                            <td><?= htmlspecialchars($n['created_by_name'] ?? '—') ?></td>
                            <td><?= date('d.m.Y', strtotime($n['created_at'])) ?></td>
                            <td>
                                <a href="edit_news.php?id=<?= (int)$n['id'] ?>" class="btn btn-primary btn-small">Ndrysho</a>
                                <a href="delete_news.php?id=<?= (int)$n['id'] ?>" class="btn btn-danger btn-small" onclick="return confirm('Fshi këtë lajm?');">Fshi</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>

    <div class="section">
        <h2>Produktet <a href="add_product.php" class="btn btn-primary btn-small">Shto produkt</a></h2>
        <?php if (empty($products)): ?>
            <p class="empty">Nuk ka produkte.</p>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>Titulli</th>
                        <th>Shtuar nga</th>
                        <th>Data</th>
                        <th>Veprime</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $p): ?>
                        <tr>
                            <td><?= htmlspecialchars($p['title']) ?></td>
                            <td><?= htmlspecialchars($p['created_by_name'] ?? '—') ?></td>
                            <td><?= date('d.m.Y', strtotime($p['created_at'])) ?></td>
                            <td>
                                <a href="edit_product.php?id=<?= (int)$p['id'] ?>" class="btn btn-primary btn-small">Ndrysho</a>
                                <a href="delete_product.php?id=<?= (int)$p['id'] ?>" class="btn btn-danger btn-small" onclick="return confirm('Fshi këtë produkt?');">Fshi</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</body>
</html>

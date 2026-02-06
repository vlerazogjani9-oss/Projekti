<?php
session_start();
require_once __DIR__ . '/../includes/auth_check.php';
require_once __DIR__ . '/../classes/Contact.php';
require_once __DIR__ . '/../classes/News.php';
require_once __DIR__ . '/../classes/Product.php';
require_once __DIR__ . '/../classes/Job.php';
require_once __DIR__ . '/../config/job_privacy.php';

$contactModel = new Contact();
$newsModel = new News();
$productModel = new Product();
$jobModel = new Job();

$contacts = $contactModel->getAll();
$newsList = $newsModel->getAll();
$products = $productModel->getAll();
$jobs = $jobModel->getAll();
?>
<!DOCTYPE html>
<html lang="sq">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menaxhimi</title>
    <link rel="stylesheet" href="../assets/css/admin.css">
    <link href="https://cdn.boxicons.com/3.0.6/fonts/basic/boxicons.min.css" rel="stylesheet">
</head>
<body>
    <header class="admin-header">
        <h1>PUNA IME – Menaxhimi</h1>
        <nav class="admin-header-nav">
            <a href="../index.php">Kryefaqja</a>
            <a href="../auth/logout.php">Dil</a>
        </nav>
    </header>

    <main class="admin-main">
    <div class="admin-page-header">
        <h1>Dashboard</h1>
        <a href="../index.php" class="back-link">← Kthehu në faqen kryesore</a>
    </div>

    <?php
    if (isset($_GET['deleted'])) echo '<div class="message success">U fshi me sukses.</div>';
    if (isset($_GET['saved'])) echo '<div class="message success">U ruajt me sukses.</div>';
    ?>

    <div class="stats">
        <div class="stat">Mesazhe kontakti: <strong><?= count($contacts) ?></strong></div>
        <div class="stat">Lajme: <strong><?= count($newsList) ?></strong></div>
        <div class="stat">Punët: <strong><?= count($jobs) ?></strong></div>
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
        <h2>Punët <a href="add_job.php" class="btn btn-primary btn-small">Shto punë</a></h2>
        <?php if (empty($jobs)): ?>
            <p class="empty">Nuk ka punë.</p>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>Titulli</th>
                        <th>Kompania</th>
                        <th>Lokacioni</th>
                        <th>Data</th>
                        <th>Veprime</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($jobs as $j): ?>
                        <?php $j = getJobDisplay($j); ?>
                        <tr>
                            <td><?= htmlspecialchars($j['title']) ?></td>
                            <td><?= htmlspecialchars($j['company']) ?></td>
                            <td><?= htmlspecialchars($j['location']) ?></td>
                            <td><?= date('d.m.Y', strtotime($j['created_at'])) ?></td>
                            <td>
                                <a href="edit_job.php?id=<?= (int)$j['id'] ?>" class="btn btn-primary btn-small">Ndrysho</a>
                                <a href="delete_job.php?id=<?= (int)$j['id'] ?>" class="btn btn-danger btn-small" onclick="return confirm('Fshi këtë punë?');">Fshi</a>
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
    </main>
</body>
</html>

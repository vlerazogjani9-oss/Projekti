<?php
session_start();
require_once __DIR__ . "/classes/News.php";

$newsModel = new News();
$newsList = $newsModel->getAll();
?>
<!DOCTYPE html>
<html lang="sq">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>News</title>
    <link rel="stylesheet" href="assets/css/faqja1.css">
    <link rel="stylesheet" href="assets/css/contact.css">
    <link href="https://cdn.boxicons.com/3.0.6/fonts/basic/boxicons.min.css" rel="stylesheet">
    <style>
        .page-title { margin: 2rem auto; max-width: 1200px; padding: 0 1rem; }
        .news-list { max-width: 900px; margin: 0 auto 3rem; padding: 0 1rem; }
        .news-card { background: #fff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.1); margin-bottom: 1.5rem; display: flex; flex-direction: column; }
        .news-card img { width: 100%; max-height: 220px; object-fit: cover; }
        .news-card .body { padding: 1.25rem; }
        .news-card h3 { margin: 0 0 0.5rem; font-size: 1.25rem; }
        .news-card .excerpt { color: #444; line-height: 1.5; }
        .news-card .meta { font-size: 0.85rem; color: #666; margin-top: 0.75rem; }
        .news-card a.file-link { display: inline-block; margin-top: 0.5rem; color: #2563eb; }
        .no-items { max-width: 600px; margin: 2rem auto; padding: 2rem; text-align: center; background: #f8fafc; border-radius: 8px; }
        @media (min-width: 600px) { .news-card { flex-direction: row; } .news-card img { width: 280px; max-height: none; min-height: 180px; } }
    </style>
</head>
<body>
<header>
    <div class="navbar">
        <h3 id="title">PUNA IME</h3>
        <div class="right-side">
            <nav>
                <ul class="listed">
                    <li><a href="index.php">Kryefaqja</a></li>
                    <li><a href="about.php">Rreth nesh</a></li>
                    <li><a href="jobs.php">Punët</a></li>
                    <li><a href="news.php" class="active">Lajme</a></li>
                    <li><a href="contact.php">Kontakt</a></li>
                    <?php if (isset($_SESSION['user']) && (!empty($_SESSION['user']['role']) && $_SESSION['user']['role'] === 'admin')): ?><li><a href="admin/dashboard.php">Menaxhimi</a></li><?php endif; ?>
                </ul>
            </nav>
            <div class="buttons">
                <?php if (isset($_SESSION['user'])): ?>
                    <button onclick="location.href='auth/logout.php'">Dil</button>
                <?php else: ?>
                    <button onclick="location.href='auth/loginform.php'">Kyçu</button>
                    <button onclick="location.href='auth/registerform.php'">Regjistrohu</button>
                <?php endif; ?>
            </div>
        </div>
        <i class='bxr bx-menu' onclick="openNav()"></i>
    </div>
</header>
<div id="mySidenav" class="sidenav">
    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
    <a href="index.php">Kryefaqja</a>
    <a href="about.php">Rreth nesh</a>
    <a href="jobs.php">Punët</a>
    <a href="news.php">Lajme</a>
    <a href="contact.php">Kontakt</a>
    <?php if (isset($_SESSION['user']) && (!empty($_SESSION['user']['role']) && $_SESSION['user']['role'] === 'admin')): ?><a href="admin/dashboard.php">Menaxhimi</a><?php endif; ?>
</div>
<main>
    <h1 class="page-title">News</h1>
    <?php if (empty($newsList)): ?>
        <div class="no-items">Nuk ka lajme të shtuara ende.</div>
    <?php else: ?>
        <div class="news-list">
            <?php foreach ($newsList as $n): ?>
                <article class="news-card">
                    <?php if (!empty($n['image'])): ?>
                        <img src="uploads/news/<?= htmlspecialchars($n['image']) ?>" alt="<?= htmlspecialchars($n['title']) ?>">
                    <?php endif; ?>
                    <div class="body">
                        <h3><?= htmlspecialchars($n['title']) ?></h3>
                        <div class="excerpt"><?= nl2br(htmlspecialchars(mb_substr($n['body'], 0, 300))) ?><?= mb_strlen($n['body']) > 300 ? '…' : '' ?></div>
                        <?php if (!empty($n['file'])): ?>
                            <a class="file-link" href="uploads/news/<?= htmlspecialchars($n['file']) ?>" target="_blank">Shiko PDF</a>
                        <?php endif; ?>
                        <div class="meta">Shtuar nga: <?= htmlspecialchars($n['created_by_name'] ?? '—') ?><?= !empty($n['updated_by_name']) ? ' | Ndryshuar nga: ' . htmlspecialchars($n['updated_by_name']) : '' ?> | <?= date('d.m.Y', strtotime($n['created_at'])) ?></div>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</main>
<footer>
    <div class="elementet">
        <div class="object"><i class='bxr bx-book-open'></i><h4>Kërko miliona vende pune</h4><p>Kërko miliona vende pune dhe realizo ëndrrat profesionale.</p></div>
        <div class="object"><i class='bxr bx-people-diversity'></i><h4>Ekipe të mrekullueshme</h4><p>Rritu profesionalisht me ekipe të mrekullueshme.</p></div>
        <div class="object"><i class='bxr bx-buildings'></i><h4>Mjedis i mirë pune</h4><p>Shijo një mjedis të mirë pune dhe atmosferë.</p></div>
        <div class="object"><i class='bxr bx-biceps'></i><h4>Çdo ditë më i fortë</h4><p>Forcohu çdo ditë dhe tejkalo çdo pengesë.</p></div>
    </div>
    <div class="copyright">© 2025 VLERÉ. Të gjitha të drejtat e rezervuara.</div>
</footer>
<script src="assets/js/script.js"></script>
</body>
</html>

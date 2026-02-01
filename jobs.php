<?php
session_start();
require_once __DIR__ . "/classes/Job.php";

$jobModel = new Job();
$jobs = $jobModel->getAll();
?>
<!DOCTYPE html>
<html lang="sq">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Punët</title>
    <link rel="stylesheet" href="assets/css/faqja1.css">
    <link rel="stylesheet" href="assets/css/contact.css">
    <link href="https://cdn.boxicons.com/3.0.6/fonts/basic/boxicons.min.css" rel="stylesheet">
    <style>
        .page-title { margin: 2rem auto; max-width: 1200px; padding: 0 1rem; }
        .jobs-wrap { max-width: 1200px; margin: 0 auto 3rem; padding: 0 1rem; }
        .no-items { max-width: 600px; margin: 2rem auto; padding: 2rem; text-align: center; background: #f8fafc; border-radius: 8px; color: #64748b; }
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
                    <li><a href="jobs.php" class="active">Punët</a></li>
                    <li><a href="news.php">Lajme</a></li>
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
    <h1 class="page-title">Punët</h1>
    <div class="jobs-wrap">
        <?php if (empty($jobs)): ?>
            <p class="no-items">Nuk ka punë të shtuara ende. Kontrolloni më vonë.</p>
        <?php else: ?>
            <?php foreach ($jobs as $job): ?>
                <?php
                $initials = '';
                $words = preg_split('/\s+/', trim($job['title']), 2);
                if (count($words) >= 2) {
                    $initials = strtoupper(mb_substr($words[0], 0, 1) . mb_substr($words[1], 0, 1));
                } else {
                    $initials = strtoupper(mb_substr($job['title'], 0, 2));
                }
                ?>
                <div class="job-card">
                    <div class="left">
                        <div class="avatar"><?= htmlspecialchars($initials) ?></div>
                        <div class="details">
                            <div class="job-title"><?= htmlspecialchars($job['title']) ?></div>
                            <div class="company"><?= htmlspecialchars($job['company']) ?></div>
                            <div class="location"><?= htmlspecialchars($job['location']) ?></div>
                        </div>
                    </div>
                    <div class="right">
                        <?php if (isset($_SESSION['user'])): ?>
                            <button class="apply-btn">Apliko</button>
                        <?php else: ?>
                            <button class="apply-btn" onclick="location.href='auth/loginform.php'">Kyçu për të aplikuar</button>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
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

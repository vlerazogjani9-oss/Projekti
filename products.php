<?php
session_start();
require_once __DIR__ . "/classes/Product.php";

$productModel = new Product();
$products = $productModel->getAll();
?>
<!DOCTYPE html>
<html lang="sq">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
    <link rel="stylesheet" href="assets/css/faqja1.css">
    <link rel="stylesheet" href="assets/css/contact.css">
    <link href="https://cdn.boxicons.com/3.0.6/fonts/basic/boxicons.min.css" rel="stylesheet">
    <style>
        .page-title { margin: 2rem auto; max-width: 1200px; padding: 0 1rem; }
        .products-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 1.5rem; max-width: 1200px; margin: 0 auto 3rem; padding: 0 1rem; }
        .product-card { background: #fff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
        .product-card img { width: 100%; height: 180px; object-fit: cover; }
        .product-card .body { padding: 1rem; }
        .product-card h3 { margin: 0 0 0.5rem; font-size: 1.1rem; }
        .product-card .meta { font-size: 0.85rem; color: #666; margin-top: 0.5rem; }
        .product-card a.file-link { display: inline-block; margin-top: 0.5rem; color: #2563eb; }
        .no-items { max-width: 600px; margin: 2rem auto; padding: 2rem; text-align: center; background: #f8fafc; border-radius: 8px; }
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
                    <li><a href="news.php">Lajme</a></li>
                    <li><a href="contact.php">Kontakt</a></li>
                    <?php if (isset($_SESSION['user'])): ?><li><a href="admin/dashboard.php">Menaxhimi</a></li><?php endif; ?>
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
    <?php if (isset($_SESSION['user'])): ?><a href="admin/dashboard.php">Menaxhimi</a><?php endif; ?>
</div>
<main>
    <h1 class="page-title">Products</h1>
    <?php if (empty($products)): ?>
        <div class="no-items">Nuk ka produkte të shtuara ende.</div>
    <?php else: ?>
        <div class="products-grid">
            <?php foreach ($products as $p): ?>
                <div class="product-card">
                    <?php if (!empty($p['image'])): ?>
                        <img src="uploads/products/<?= htmlspecialchars($p['image']) ?>" alt="<?= htmlspecialchars($p['title']) ?>">
                    <?php elseif (!empty($p['file'])): ?>
                        <div class="body" style="padding: 1rem;"><a class="file-link" href="uploads/products/<?= htmlspecialchars($p['file']) ?>" target="_blank">Shiko PDF</a></div>
                    <?php else: ?>
                        <div style="height:120px;background:#eee;display:flex;align-items:center;justify-content:center;color:#999;">Nuk ka imazh</div>
                    <?php endif; ?>
                    <div class="body">
                        <h3><?= htmlspecialchars($p['title']) ?></h3>
                        <p><?= nl2br(htmlspecialchars(mb_substr($p['description'], 0, 200))) ?><?= mb_strlen($p['description']) > 200 ? '…' : '' ?></p>
                        <?php if (!empty($p['file']) && !empty($p['image'])): ?>
                            <a class="file-link" href="uploads/products/<?= htmlspecialchars($p['file']) ?>" target="_blank">Shiko PDF</a>
                        <?php endif; ?>
                        <div class="meta">Shtuar nga: <?= htmlspecialchars($p['created_by_name'] ?? '—') ?><?= !empty($p['updated_by_name']) ? ' | Ndryshuar nga: ' . htmlspecialchars($p['updated_by_name']) : '' ?></div>
                    </div>
                </div>
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

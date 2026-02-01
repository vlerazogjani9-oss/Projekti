<?php
session_start();
require_once __DIR__ . "/classes/SiteContent.php";
require_once __DIR__ . "/classes/TeamMember.php";

$siteContent = new SiteContent();
$teamModel = new TeamMember();

$aboutIntro = $siteContent->get('about_intro');
if ($aboutIntro === null) {
    $aboutIntro = "Ne jemi një platformë inovative që lidh punëkërkuesit me punëdhënësit, duke e bërë gjetjen e punës më të lehtë dhe më të shpejtë. Qëllimi ynë është të ofrojmë mundësi të barabarta për të gjithë dhe të mbështesim zhvillimin profesional të përdoruesve tanë.";
}
$teamMembers = $teamModel->getAll();
$defaultTeam = [
    ['name' => 'Stina Bytyqi', 'image' => '19222.jpg'],
    ['name' => 'Vlera Zogjani', 'image' => '2431.jpg'],
    ['name' => 'Elsa Canolli', 'image' => '93435.jpg'],
    ['name' => 'Vesa Kadriu', 'image' => '1328.jpg'],
];
if (empty($teamMembers)) {
    $teamMembers = $defaultTeam;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About</title>
    <link rel="stylesheet" href="assets/css/about.css">
    <link href='https://cdn.boxicons.com/3.0.6/fonts/basic/boxicons.min.css' rel='stylesheet'>
</head>
<body>

    <header>
        <div class="navbar">
            <h3 id="title">ABOUT</h3>
            <div class="right-side">
                <nav>
                    <ul class="listed">
                        <li><a href="index.php">Kryefaqja</a></li>
                        <li><a href="about.php" class="active">Rreth nesh</a></li>
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
                        <button id="loginBtn" onclick="location.href='auth/loginform.php'">Kyçu</button>
                        <button id="registerBtn" onclick="location.href='auth/registerform.php'">Regjistrohu</button>
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
        <section class="history-wrapper">
            <div class="about-info">
                <h2>About Us / Historiku Ynë</h2>
                <p><?= nl2br(htmlspecialchars($aboutIntro)) ?></p>
            </div>
        </section>

        <section class="team-wrapper">
            <div class="about-team">
                <h3>Ekipi Ynë</h3>
                <div class="team-box">
                    <?php foreach ($teamMembers as $member): ?>
                        <div class="team-member">
                            <?php
                            $imgPath = !empty($member['image']) ? 'assets/images/' . htmlspecialchars($member['image']) : 'assets/images/people.jpg';
                            ?>
                            <img src="<?= $imgPath ?>" alt="<?= htmlspecialchars($member['name']) ?>">
                            <span><?= htmlspecialchars($member['name']) ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
    </main>

    <footer>
        <div class="elementet">
            <div class="object">
                <i class='bxr bx-book-open'></i>
                <div class="fjalia1"><h4>Kërko miliona vende pune</h4></div>
                <div><p>Kërko miliona vende pune dhe realizo ëndrrat profesionale.</p></div>
            </div>
            <div class="object">
                <i class='bxr bx-people-diversity'></i>
                <div class="fjalia1"><h4>Ekipe të mrekullueshme</h4></div>
                <div><p>Rritu profesionalisht me ekipe të mrekullueshme.</p></div>
            </div>
            <div class="object">
                <i class='bxr bx-buildings'></i>
                <div class="fjalia1"><h4>Mjedis i mirë pune</h4></div>
                <div><p>Shijo një mjedis të mirë pune dhe atmosferë.</p></div>
            </div>
            <div class="object">
                <i class='bxr bx-biceps'></i>
                <div class="fjalia1"><h4>Çdo ditë më i fortë</h4></div>
                <div><p>Forcohu çdo ditë dhe tejkalo çdo pengesë.</p></div>
            </div>
        </div>
        <div class="copyright">© 2025 VLERÉ. Të gjitha të drejtat e rezervuara.</div>
    </footer>

    <script src="assets/js/script.js"></script>
</body>
</html>

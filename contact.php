<?php
session_start();
require_once __DIR__ . "/classes/Contact.php";
require_once __DIR__ . "/classes/Validator.php";

$contactSaved = false;
$contactError = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $validator = new Validator();
    $ok = $validator->validateContact([
        'name' => $_POST['name'] ?? '',
        'email' => $_POST['email'] ?? '',
        'message' => $_POST['message'] ?? ''
    ]);
    if ($ok) {
        $contact = new Contact();
        if ($contact->save(
            trim($_POST['name']),
            trim($_POST['email']),
            trim($_POST['message'])
        )) {
            header('Location: contact.php?saved=1');
            exit;
        }
        $contactError = 'Gabim gjatë dërgimit. Provoni përsëri.';
    } else {
        $contactError = $validator->getFirstError();
    }
}
$contactSaved = isset($_GET['saved']) && $_GET['saved'] == '1';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kontakti</title>
    <link rel="stylesheet" href="assets/css/contact.css">
    <link href='https://cdn.boxicons.com/3.0.6/fonts/basic/boxicons.min.css' rel='stylesheet'>
</head>
<body>

    <header>
        <div class="navbar">
            <h3 id="title">CONTACT</h3>
            <div class="right-side">
                <nav>
                    <ul class="listed">
                        <li><a href="index.php">Kryefaqja</a></li>
                        <li><a href="about.php">Rreth nesh</a></li>
                        <li><a href="jobs.php">Punët</a></li>
                        <li><a href="news.php">Lajme</a></li>
                        <li><a href="contact.php" class="active">Kontakt</a></li>
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

    <!-- Contact Section -->
    <main>
        <div class="container">
            <div class="contact-wrapper">

                <!-- Info boxes -->
                <div class="info-section">
                    <div class="info-boxes">
                        <div class="info-box">
                            <h4>Telefoni</h4>
                            <p>044-123-123</p>
                        </div>
                        <div class="info-box">
                            <h4>WhatsApp</h4>
                            <p>+383-123-123</p>
                        </div>
                        <div class="info-box">
                            <h4>Email</h4>
                            <p>careers@employment.com</p>
                        </div>
                        <div class="info-box">
                            <h4>Zyra Jonë</h4>
                            <p>Dukagjini Center, UBT</p>
                        </div>
                    </div>
                    <div class="map">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3021.123456789!2d21.123456!3d42.123456!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x135f123456789!2sDukagjini+Center!5e0!3m2!1sen!2xk!4v1700000000000"
                            width="100%" height="220" style="border:0;" allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                    </div>

                </div>

                <!-- Contact Form -->
                <div class="form">
                    <h2>Na kontakto</h2>
                    <p>Na dërgo një mesazh dhe ne do të përgjigjemi sa më shpejt të jetë e mundur.</p>
                    <?php if ($contactSaved): ?>
                        <div class="success" id="success" style="display:block;">Mesazhi u dërgua me sukses!</div>
                    <?php endif; ?>
                    <?php if ($contactError): ?>
                        <div class="message error"><?= htmlspecialchars($contactError) ?></div>
                    <?php endif; ?>
                    <form id="contactForm" method="POST" action="">
                        <div class="form-group">
                            <input type="text" name="name" id="name" placeholder="Emri juaj" value="<?= htmlspecialchars($_POST['name'] ?? '') ?>" required minlength="2">
                        </div>
                        <div class="form-group">
                            <input type="email" name="email" id="email" placeholder="Email-i juaj" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>
                        </div>
                        <div class="form-group">
                            <textarea name="message" id="message" placeholder="Mesazhi" required minlength="10"><?= htmlspecialchars($_POST['message'] ?? '') ?></textarea>
                        </div>
                        <button type="submit">Dërgo Tani</button>
                    </form>
                </div>

            </div>
        </div>
    </main>

    <footer>


        <div class="elementet">

            <div class="object">
                <i class='bxr  bx-book-open'></i>
                <div class="fjalia1">
                    <h4>Kërko miliona vende pune</h4>
                </div>
                <div>
                    <p>Kërko miliona vende pune dhe realizo ëndrrat profesionale.</p>
                </div>

            </div>

            <div class="object">
                <i class='bxr  bx-people-diversity'></i>
                <div class="fjalia1">
                    <h4>Ekipe të mrekullueshme</h4>
                </div>
                <div>
                    <p>Rritu profesionalisht me ekipe të mrekullueshme.</p>
                </div>

            </div>

            <div class="object">
                <i class='bxr  bx-buildings'></i>
                <div class="fjalia1">
                    <h4>Mjedis i mirë pune</h4>
                </div>
                <div>
                    <p>Shijo një mjedis të mirë pune dhe atmosferë.</p>
                </div>

            </div>

            <div class="object">
                <i class='bxr  bx-biceps'></i>
                <div class="fjalia1">
                    <h4>Çdo ditë më i fortë</h4>
                </div>
                <div>
                    <p>Forcohu çdo ditë dhe tejkalo çdo pengesë.</p>
                </div>

            </div>

        </div>








        <div class="copyright">
            © 2025 VLERÉ. Të gjitha të drejtat e rezervuara.
        </div>

    </footer>


    <script src="assets/js/script.js"></script>
</body>
</html>

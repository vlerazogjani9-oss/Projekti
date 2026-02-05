<?php
session_start();
require_once __DIR__ . "/../classes/User.php";
require_once __DIR__ . "/../classes/Validator.php";

$user = new User();
$validator = new Validator();
$message = '';
$success = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $password_confirm = $_POST['password_confirm'] ?? '';

    $ok = $validator->validateRegister([
        'name' => $name,
        'email' => $email,
        'password' => $password,
        'password_confirm' => $password_confirm
    ]);

    if ($ok) {
        if ($user->findByEmail($email)) {
            $message = 'Ky email është tashmë i regjistruar.';
        } else {
            if ($user->register($name, $email, $password)) {
                $success = true;
                $message = 'Regjistrimi u krye me sukses! Mund të kyçeni tani.';
            } else {
                $message = 'Gabim gjatë regjistrimit. Provoni përsëri.';
            }
        }
    } else {
        $message = $validator->getFirstError();
    }
}
?>
<!DOCTYPE html>
<html lang="sq">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Regjistrohu</title>
    <link rel="stylesheet" href="../assets/css/loginform.css">
    <link href='https://cdn.boxicons.com/3.0.6/fonts/basic/boxicons.min.css' rel='stylesheet'>
</head>
<body>

<div class="navbar">
    <h3 id="title">PUNA IME</h3>
    <div class="right-side">
        <nav>
            <ul class="listed">
                <li><a href="../index.php">Kryefaqja</a></li>
                <li><a href="../about.php">Rreth nesh</a></li>
                <li><a href="../jobs.php">Punët</a></li>
                <li><a href="../news.php">Lajme</a></li>
                <li><a href="../contact.php">Kontakt</a></li>
                <?php if (isset($_SESSION['user']) && ($_SESSION['user']['role'] ?? '') === 'admin'): ?><li><a href="../admin/dashboard.php">Menaxhimi</a></li><?php endif; ?>
            </ul>
        </nav>
        <div class="buttons">
            <button type="button" onclick="location.href='loginform.php'">Kyçu</button>
            <button class="active">Regjistrohu</button>
        </div>
    </div>
    <i class="bx bx-menu" onclick="openNav()" aria-label="Menu"></i>
</div>
<div id="mySidenav" class="sidenav">
    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
    <a href="../index.php">Kryefaqja</a>
    <a href="../about.php">Rreth nesh</a>
    <a href="../jobs.php">Punët</a>
    <a href="../news.php">Lajme</a>
    <a href="../contact.php">Kontakt</a>
    <?php if (isset($_SESSION['user'])): ?>
        <?php if (($_SESSION['user']['role'] ?? '') === 'admin'): ?><a href="../admin/dashboard.php">Menaxhimi</a><?php endif; ?>
        <a href="logout.php">Dil</a>
    <?php else: ?>
        <a href="loginform.php">Kyçu</a>
        <a href="registerform.php">Regjistrohu</a>
    <?php endif; ?>
</div>

<main class="form-page">
    <div class="wrapper">
        <form method="POST" action="">
            <h1>Regjistrohu</h1>
            <?php if ($message): ?>
                <div class="message <?= $success ? 'success' : 'error' ?>"><?= htmlspecialchars($message) ?></div>
            <?php endif; ?>
            <div class="input-box">
                <input type="text" name="name" placeholder="Emri i plotë" value="<?= htmlspecialchars($_POST['name'] ?? '') ?>" required minlength="2">
                <i class='bx bx-user'></i>
            </div>
            <div class="input-box">
                <input type="email" name="email" placeholder="Email adresa" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>
                <i class='bx bx-envelope'></i>
            </div>
            <div class="input-box">
                <input type="password" name="password" placeholder="Fjalëkalimi" required minlength="6">
                <i class='bx bx-lock'></i>
            </div>
            <div class="input-box">
                <input type="password" name="password_confirm" placeholder="Rishkruaj fjalëkalimin" required>
                <i class='bx bx-lock'></i>
            </div>
            <button class="btn" type="submit">Regjistrohu</button>
            <div class="register-link">
                <p>Keni llogari? <a href="loginform.php">Kyçu</a></p>
            </div>
        </form>
    </div>
</main>
<script src="../assets/js/script.js"></script>
</body>
</html>

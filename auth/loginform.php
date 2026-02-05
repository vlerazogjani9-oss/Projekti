<?php
session_start();
require_once __DIR__ . "/../classes/User.php";
require_once __DIR__ . "/../classes/Validator.php";

$user = new User();
$validator = new Validator(); //Validimi
$loginError = ''; //Mesazhi i gabimit

if (isset($_POST['login'])) {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($validator->validateLogin(['email' => $email, 'password' => $password])) {
        if ($user->login($email, $password)) {
            if ($_SESSION['user']['role'] === 'admin') { //ruan te dhenat e perdoruuesit pas loginit
                header("Location: ../admin/dashboard.php");
            } else {
                header("Location: ../index.php");
            }
            exit;
        }
        $loginError = 'Email ose fjalëkalimi i gabuar.';
    } else {
        $loginError = $validator->getFirstError() ?: 'Ju lutem plotësoni fushat saktë.';
    }
}
?>
<!DOCTYPE html>
<html lang="sq">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kyçu</title>
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
                <button class="active">Kyçu</button>
                <button type="button" onclick="location.href='registerform.php'">Regjistrohu</button>
            </div>
        </div>
        <i class="bx bx-menu" onclick="openNav()" aria-label="Menu"></i>
    </div>
    //Sidenav
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
                <h1>Kyçu</h1>
                <?php if ($loginError): ?>
                    <div class="message error"><?= htmlspecialchars($loginError) ?></div>
                <?php endif; ?>
                <div class="input-box">
                    <input type="email" name="email" placeholder="Email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>
                    <i class='bx bx-envelope'></i>
                </div>
                <div class="input-box">
                    <input type="password" name="password" placeholder="Fjalëkalimi" required>
                    <i class='bx bx-lock'></i>
                </div>
                <div class="remember-forgot">
                    <label><input type="checkbox" name="remember"> Më mbaj mend</label>
                </div>
                <button type="submit" name="login" class="btn">Kyçu</button>
                <div class="register-link">
                    <p>Nuk keni llogari? <a href="registerform.php">Regjistrohu</a></p>
                </div>
            </form>
        </div>
    </main>
    <script src="../assets/js/script.js"></script>
</body>
</html>

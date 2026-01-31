<?php
session_start();
require_once __DIR__ . "/../classes/User.php";
require_once __DIR__ . "/../classes/Validator.php";

$user = new User();
$validator = new Validator();
$loginError = '';

if (isset($_POST['login'])) {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($validator->validateLogin(['email' => $email, 'password' => $password])) {
        if ($user->login($email, $password)) {
            if ($_SESSION['user']['role'] === 'admin') {
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
                    <li><a href="../index.php">Home</a></li>
                    <li><a href="../about.php">About</a></li>
                    <li><a href="../products.php">Products</a></li>
                    <li><a href="../news.php">News</a></li>
                    <li><a href="../contact.php">Contact</a></li>
                </ul>
            </nav>
            <div class="buttons">
                <button class="active">Kyçu</button>
                <button type="button" onclick="location.href='registerform.php'">Regjistrohu</button>
            </div>
        </div>
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

</body>
</html>

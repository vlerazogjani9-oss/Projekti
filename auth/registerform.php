<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include('../config/database.php');

echo "Database loaded!<br>";

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $emri = trim($_POST['emri']);
    $mbiemri = trim($_POST['mbiemri']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $rpassword = trim($_POST['rpassword']);

    if ($password !== $rpassword) {
        $message = "Fjalëkalimet nuk përputhen!";
    } elseif (!empty($emri) && !empty($mbiemri) && !empty($email) && !empty($password)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (username, password) VALUES ('$email', '$hashed_password')";
        if ($conn->query($sql) === TRUE) {
            $message = "Regjistrimi u krye me sukses!";
        } else {
            $message = "Gabim: " . $conn->error;
        }
    } else {
        $message = "Ju lutem plotësoni të gjitha fushat!";
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
                <li><a href="faqja1.html">Home</a></li>
                <li><a href="about.html">About</a></li>
                <li><a href="contact.html">Contact</a></li>
            </ul>
        </nav>

        <div class="buttons">
            <button onclick="location.href='loginform.html'">Kyçu</button>
            <button class="active">Regjistrohu</button>
        </div>
    </div>
</div>

<main class="form-page">
    <div class="wrapper">
        <form method="POST" action="">
            <h1>Regjistrohu</h1>

            <!-- Mesazhi i suksesit / gabimit -->
            <?php if($message) echo "<div class='message'>$message</div>"; ?>

            <div class="input-box">
                <input type="text" name="emri" placeholder="Emri" required>
                <i class='bx bx-user'></i>
            </div>

            <div class="input-box">
                <input type="text" name="mbiemri" placeholder="Mbiemri" required>
                <i class='bx bx-user'></i>
            </div>

            <div class="input-box">
                <input type="email" name="email" placeholder="Email adresa" required>
                <i class='bx bx-envelope'></i>
            </div>

            <div class="input-box">
                <input type="password" name="password" placeholder="Fjalëkalimi" required>
                <i class='bx bx-lock'></i>
            </div>

            <div class="input-box">
                <input type="password" name="rpassword" placeholder="Rishkruaj fjalëkalimin" required>
                <i class='bx bx-lock'></i>
            </div>

            <button class="btn" type="submit">Regjistrohu</button>

            <div class="register-link">
                <p>Keni llogari? <a href="loginform.html">Kyçu</a></p>
            </div>
        </form>
    </div>
</main>

</body>
</html>

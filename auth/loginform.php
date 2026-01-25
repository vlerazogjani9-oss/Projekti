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
                    <li><a href="faqja1.html">Home</a></li>
                    <li><a href="about.html">About</a></li>
                    <li><a href="contact.html">Contact</a></li>
                </ul>
            </nav>

            <div class="buttons">
                <button class="active">Kyçu</button>
                <button onclick="location.href='registerform.html'">Regjistrohu</button>
            </div>
        </div>
    </div>

    <main class="form-page">
        <div class="wrapper">
            <form method="POST" action="">
                <h1>Kyçu</h1>

                <div class="input-box">
                    <input type="text" placeholder="Emri i përdoruesit" required>
                    <i class='bx bx-user'></i>
                </div>

                <div class="input-box">
                    <input type="password" placeholder="Fjalëkalimi" required>
                    <i class='bx bx-lock'></i>
                </div>

                <div class="remember-forgot">
                    <label><input type="checkbox"> Më mbaj mend</label>
                    <a href="#">Harrove fjalëkalimin?</a>
                </div>

                <button class="btn">Kyçu</button>

                <div class="register-link">
                    <p>Nuk keni llogari? <a href="registerform.html">Regjistrohu</a></p>
                </div>
            </form>
        </div>
    </main>

</body>

</html>
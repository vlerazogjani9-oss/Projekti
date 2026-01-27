<?php
 ini_set('display_errors', 1);
 ini_set('display_startup_errors', 1);
 error_reporting(E_ALL);

 include('../config/database.php');

 if($_SERVER["REQUEST_METHOD"]== "POST"){
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $message = trim($_POST['message']);

    if (empty($name) || emty($email) || emty($message)){
        echo "Ju lutem plotësoni të gjitha fushat!";
        exit;
    }

    $sql = "INSERT INTO contact_messages (name, email, message)"
    VALUES ('$name', $email, $message);

    if ($conn->query($sql) === TRUE){
        echo "Meesazhi u dërgua me sukses";
    } else {
        echo "Gabim: " . $conn->error;    
    }
 }
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kontakti</title>
    <link rel="stylesheet" href="contact.css">
    <link href='https://cdn.boxicons.com/3.0.6/fonts/basic/boxicons.min.css' rel='stylesheet'>
</head>

<body>

    <!-- Navbar -->
    <header>
        <div class="navbar">
            <h3 id="title">CONTACT</h3>
            <div class="right-side">
                <nav>
                    <ul class="listed">
                        <li><a href="faqja1.html">Home</a></li>
                        <li><a href="about.html">About</a></li>
                        <li><a href="contact.html" class="active">Contact</a></li>
                    </ul>

                </nav>
                <div class="buttons">
                    <button id="loginBtn">Kyçu</button>
                    <button id="registerBtn">Regjistrohu</button>
                </div>
            </div>
            <i class='bxr bx-menu' onclick="openNav()"></i>
        </div>
    </header>

    <!-- Offcanvas Menu -->
    <div id="mySidenav" class="sidenav">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
        <a href="#">Home</a>
        <a href="#">About</a>
        <a href="#">Contact</a>
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
                    <form id="contactForm" action="contact_backed.php" method="POST">
                        <div class="form-group">
                            <input type="text" id="name" name="name" placeholder="Emri juaj" required>
                        </div>
                        <div class="form-group">
                            <input type="email" id="email"name="email" placeholder="Email-i juaj" required>
                        </div>
                        <div class="form-group">
                            <textarea id="message" name="mesagge" placeholder="Mesazhi" required></textarea>
                        </div>
                        <button type="submit">Dërgo Tani</button>
                    </form>
                    <div class="success" id="success">Mesazhi u dërgua me sukses!</div>
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


    <script src="script.js"></script>
</body>

</html>330
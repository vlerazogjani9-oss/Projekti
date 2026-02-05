<?php
// Kontrollon ekzistencen e sesionit dhe nese perdoruesi eshte i loguar 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// nese perdoruesi nuk eshte i loguar ridrejtore ne faqen e loginit
if (!isset($_SESSION['user'])) {
    header("Location: ../auth/loginform.php");
    exit;
}
// nese perdoruesi nuk eshte admin, mos lejo hyrje ne menaxhim
if (($_SESSION['user']['role'] ?? '') !== 'admin') {
    header("Location: ../index.php");
    exit;
}

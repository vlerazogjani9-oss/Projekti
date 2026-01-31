<?php
session_start();
?>
<link rel="stylesheet" href="/Projekti/assets/css/faqja1.css">
<link href="https://cdn.boxicons.com/3.0.6/fonts/basic/boxicons.min.css" rel="stylesheet">

<header>
  <div class="navbar">
    <h3 id="title">PUNA IME</h3>

    <div class="right-side">
      <nav>
        <ul class="listed">
          <li><a href="/Projekti/faqja1.php">Home</a></li>
          <li><a href="/Projekti/about.php">About</a></li>
          <li><a href="/Projekti/contact.php">Contact</a></li>
        </ul>
      </nav>

      <div class="buttons">
        <?php if(isset($_SESSION['user'])): ?>
          <button onclick="location.href='/Projekti/dashboard.php'">Dashboard</button>
          <button onclick="location.href='/Projekti/auth/logout.php'">Logout</button>
        <?php else: ?>
          <button onclick="location.href='/Projekti/auth/loginform.php'">Kyçu</button>
          <button onclick="location.href='/Projekti/auth/registerform.php'">Regjistrohu</button>
        <?php endif; ?>
      </div>
    </div>
  </div>
</header>

<?php
session_start();
include('config/database.php');
?>
<!DOCTYPE html>
<html lang="sq">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Home Page</title>

  <!-- CSS -->
  <link rel="stylesheet" href="/Projekti/assets/css/faqja1.css">
  <link href="https://cdn.boxicons.com/3.0.6/fonts/basic/boxicons.min.css" rel="stylesheet">
</head>

<body>

<!-- ================= HEADER ================= -->
<header>
  <div class="navbar">
    <h3 id="title">PUNA IME</h3>

    <div class="right-side">
      <nav>
        <ul class="listed">
          <li><a href="faqja1.php" class="active">Home</a></li>
          <li><a href="about.php">About</a></li>
          <li><a href="contact.php">Contact</a></li>
        </ul>
      </nav>

      <div class="buttons">
        <?php if(isset($_SESSION['user'])): ?>
          <button onclick="location.href='auth/logout.php'">Dil</button>
        <?php else: ?>
          <button onclick="location.href='auth/loginform.php'">Kyçu</button>
          <button onclick="location.href='auth/registerform.php'">Regjistrohu</button>
        <?php endif; ?>
      </div>
    </div>

    <i class='bxr bx-menu' onclick="openNav()"></i>
  </div>
</header>

<!-- ================= OFFCANVAS ================= -->
<div id="mySidenav" class="sidenav">
  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
  <a href="about.php">About</a>
  <a href="contact.php">Contact</a>
</div>

<!-- ================= MAIN ================= -->
<main>

  <!-- SLOGAN -->
  <div class="slogan-quote">
    <div class="slogan">
      <p class="paragrafi1">
        PUNË QË TË PËRSHTATET,<br>
        <span style="font-weight:bold;color:white;">MUNDËSI QË RRIT.</span>
      </p>
    </div>

    <div class="quote">
      <p>
        Gjej punën tënde të ëndrrave, shpejt dhe lehtë! <br>
        Shfleto oferta, <strong>krijo</strong> profilin tënd profesional dhe <strong>apliko</strong> me një klikim!
      </p>
    </div>
  </div>

  <!-- SEARCH -->
  <div class="search-box">
    <div class="tabs">
      <button class="tab active">Kërko një punë</button>
      <button class="tab">Kërko një kandidat</button>
    </div>

    <div class="filters">
      <input type="text" placeholder="Pozicioni">
      <select>
        <option value="">Kategoria</option>
        <option>IT</option>
        <option>Marketing</option>
        <option>Financa</option>
      </select>
      <input type="text" placeholder="Lokacioni">
      <button class="search-btn">Kërko</button>
    </div>
  </div>

  <!-- ================= JOBS ================= -->
  <div class="jobs-wrap">

    <h2>Punë të shtuara kohët e fundit</h2>
    <h3>Kohës së fundit</h3>

    <!-- JOB 1 -->
    <div class="job-card">
      <div class="left">
        <div class="avatar">FD</div>
        <div class="details">
          <div class="job-title">Frontend Development</div>
          <div class="company">BrandingX</div>
          <div class="location">Pejton, Prishtinë</div>
        </div>
      </div>
      <div class="right">
        <?php if(isset($_SESSION['user'])): ?>
          <button class="apply-btn">Apliko</button>
        <?php else: ?>
          <button class="apply-btn"
            onclick="location.href='/Projekti/auth/loginform.php'">
            Kyçu për të aplikuar
          </button>
        <?php endif; ?>
      </div>
    </div>

    <!-- JOB 2 -->
    <div class="job-card">
      <div class="left">
        <div class="avatar">FS</div>
        <div class="details">
          <div class="job-title">Full Stack Developer</div>
          <div class="company">Raiffeisen Tech Kosovo</div>
          <div class="location">Dardani, Prishtinë</div>
        </div>
      </div>
      <div class="right">
        <button class="apply-btn" onclick="redirectToLogin()">Apliko</button>
      </div>
    </div>

    <!-- JOB 3 -->
    <div class="job-card">
      <div class="left">
        <div class="avatar">OP</div>
        <div class="details">
          <div class="job-title">Open Source Interactive Developer</div>
          <div class="company">KEN CREATIVE</div>
          <div class="location">Veterrnik, Prishtinë</div>
        </div>
      </div>
      <div class="right">
        <button class="apply-btn">Apliko</button>
      </div>
    </div>

    <!-- JOB 4 -->
    <div class="job-card">
      <div class="left">
        <div class="avatar">MM</div>
        <div class="details">
          <div class="job-title">Menaxher Marketingu</div>
          <div class="company">Creative Marketing Agency</div>
          <div class="location">Bregu i Diellit, Prishtinë</div>
        </div>
      </div>
      <div class="right">
        <button class="apply-btn">Apliko</button>
      </div>
    </div>

    <!-- JOB 5 -->
    <div class="job-card">
      <div class="left">
        <div class="avatar">DG</div>
        <div class="details">
          <div class="job-title">Dizajner Grafik</div>
          <div class="company">Tactica</div>
          <div class="location">Tophane, Prishtinë</div>
        </div>
      </div>
      <div class="right">
        <button class="apply-btn">Apliko</button>
      </div>
    </div>

    <!-- JOB 6 -->
    <div class="job-card">
      <div class="left">
        <div class="avatar">SI</div>
        <div class="details">
          <div class="job-title">Specialist IT</div>
          <div class="company">Growzillas</div>
          <div class="location">Arbëri, Prishtinë</div>
        </div>
      </div>
      <div class="right">
        <button class="apply-btn">Apliko</button>
      </div>
    </div>

  </div>
</main>

<!-- ================= FOOTER ================= -->
<footer>
  <div class="elementet">

    <div class="object">
      <i class='bxr bx-book-open'></i>
      <h4>Kërko miliona vende pune</h4>
      <p>Kërko miliona vende pune dhe realizo ëndrrat profesionale.</p>
    </div>

    <div class="object">
      <i class='bxr bx-people-diversity'></i>
      <h4>Ekipe të mrekullueshme</h4>
      <p>Rritu profesionalisht me ekipe të mrekullueshme.</p>
    </div>

    <div class="object">
      <i class='bxr bx-buildings'></i>
      <h4>Mjedis i mirë pune</h4>
      <p>Shijo një mjedis të mirë pune dhe atmosferë.</p>
    </div>

    <div class="object">
      <i class='bxr bx-biceps'></i>
      <h4>Çdo ditë më i fortë</h4>
      <p>Forcohu çdo ditë dhe tejkalo çdo pengesë.</p>
    </div>

  </div>

  <div class="copyright">
    © 2025 VLERÉ. Të gjitha të drejtat e rezervuara.
  </div>
</footer>

<script src="./assets/js/script.js"></script>
</body>
</html>

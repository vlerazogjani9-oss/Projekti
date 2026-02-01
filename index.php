<?php
session_start();
require_once __DIR__ . "/classes/Slider.php";
require_once __DIR__ . "/classes/Job.php";
require_once __DIR__ . "/classes/SiteContent.php";

$sliderModel = new Slider();
$jobModel = new Job();
$siteContent = new SiteContent();

$slides = $sliderModel->getAllActive();
$jobs = $jobModel->getAll();

// Apply job search filters from GET (position, category, location)
$searchPosition = trim($_GET['position'] ?? '');
$searchCategory = trim($_GET['category'] ?? '');
$searchLocation = trim($_GET['location'] ?? '');
if ($searchPosition !== '' || $searchCategory !== '' || $searchLocation !== '') {
    $jobs = array_filter($jobs, function ($job) use ($searchPosition, $searchCategory, $searchLocation) {
        if ($searchPosition !== '' && mb_stripos($job['title'], $searchPosition) === false) {
            return false;
        }
        if ($searchCategory !== '') {
            $inTitle = mb_stripos($job['title'], $searchCategory) !== false;
            $inCompany = mb_stripos($job['company'], $searchCategory) !== false;
            if (!$inTitle && !$inCompany) {
                return false;
            }
        }
        if ($searchLocation !== '' && mb_stripos($job['location'], $searchLocation) === false) {
            return false;
        }
        return true;
    });
    $jobs = array_values($jobs);
}

$sloganLine1 = $siteContent->get('home_slogan_line1') ?: 'PUNË QË TË PËRSHTATET,';
$sloganLine2 = $siteContent->get('home_slogan_line2') ?: 'MUNDËSI QË RRIT.';
$quoteText = $siteContent->get('home_quote') ?: 'Gjej punën tënde të ëndrrave, shpejt dhe lehtë! Shfleto oferta, krijo profilin tënd profesional dhe apliko me një klikim!';
?>
<!DOCTYPE html>
<html lang="sq">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Home Page</title>
  <link rel="stylesheet" href="assets/css/faqja1.css">
  <link href="https://cdn.boxicons.com/3.0.6/fonts/basic/boxicons.min.css" rel="stylesheet">
  <style>
    .slider-wrap { position: relative; width: 100%; max-height: 400px; overflow: hidden; background: #1e293b; }
    .slider-slides { display: flex; transition: transform 0.4s ease; }
    .slider-slide { min-width: 100%; box-sizing: border-box; padding: 3rem 2rem; text-align: center; color: #fff; display: flex; flex-direction: column; align-items: center; justify-content: center; min-height: 280px; position: relative; }
    .slider-slide img { position: absolute; left: 0; top: 0; width: 100%; height: 100%; object-fit: cover; z-index: 0; opacity: 0.6; filter: blur(5px); }
    .slider-slide::after { content: ''; position: absolute; left: 0; top: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.5); z-index: 1; }
    .slider-slide .content { position: relative; z-index: 2; }
    .slider-slide h2 { margin: 0 0 0.5rem; font-size: 1.75rem; }
    .slider-slide p { margin: 0; font-size: 1rem; opacity: 0.95; }
    .slider-dots { position: absolute; bottom: 1rem; left: 50%; transform: translateX(-50%); display: flex; gap: 0.5rem; z-index: 3; }
    .slider-dot { width: 10px; height: 10px; border-radius: 50%; background: rgba(255,255,255,0.5); cursor: pointer; border: none; padding: 0; }
    .slider-dot.active { background: #fff; }
    .slider-arrow { position: absolute; top: 50%; transform: translateY(-50%); background: rgba(0,0,0,0.3); color: #fff; border: none; width: 40px; height: 40px; border-radius: 50%; cursor: pointer; z-index: 3; font-size: 1.2rem; }
    .slider-arrow.prev { left: 1rem; }
    .slider-arrow.next { right: 1rem; }
  </style>
</head>
<body>

<header>
  <div class="navbar">
    <h3 id="title">PUNA IME</h3>
    <div class="right-side">
      <nav>
        <ul class="listed">
          <li><a href="index.php" class="active">Kryefaqja</a></li>
          <li><a href="about.php">Rreth nesh</a></li>
          <li><a href="jobs.php">Punët</a></li>
          <li><a href="news.php">Lajme</a></li>
          <li><a href="contact.php">Kontakt</a></li>
          <?php if (isset($_SESSION['user'])): ?><li><a href="admin/dashboard.php">Menaxhimi</a></li><?php endif; ?>
        </ul>
      </nav>
      <div class="buttons">
        <?php if (isset($_SESSION['user'])): ?>
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

<div id="mySidenav" class="sidenav">
  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
  <a href="index.php">Kryefaqja</a>
  <a href="about.php">Rreth nesh</a>
  <a href="jobs.php">Punët</a>
  <a href="news.php">Lajme</a>
  <a href="contact.php">Kontakt</a>
  <?php if (isset($_SESSION['user'])): ?><a href="admin/dashboard.php">Menaxhimi</a><?php endif; ?>
</div>

<main>
  <?php if (!empty($slides)): ?>
  <div class="slider-wrap" id="sliderWrap">
    <div class="slider-slides" id="sliderSlides">
      <?php foreach ($slides as $slide): ?>
        <div class="slider-slide">
          <?php if (!empty($slide['image'])): ?>
            <img src="uploads/slider/<?= htmlspecialchars($slide['image']) ?>" alt="<?= htmlspecialchars($slide['title']) ?>">
          <?php endif; ?>
          <div class="content">
            <h2><?= htmlspecialchars($slide['title']) ?></h2>
            <?php if (!empty($slide['subtitle'])): ?><p><?= htmlspecialchars($slide['subtitle']) ?></p><?php endif; ?>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
    <?php if (count($slides) > 1): ?>
      <button type="button" class="slider-arrow prev" id="sliderPrev" aria-label="Previous">&lsaquo;</button>
      <button type="button" class="slider-arrow next" id="sliderNext" aria-label="Next">&rsaquo;</button>
      <div class="slider-dots" id="sliderDots"></div>
    <?php endif; ?>
  </div>
  <?php endif; ?>

  <div class="slogan-quote">
    <div class="slogan">
      <p class="paragrafi1">
        <?= htmlspecialchars($sloganLine1) ?><br>
        <span style="font-weight:bold;color:white;"><?= htmlspecialchars($sloganLine2) ?></span>
      </p>
    </div>
    <div class="quote">
      <p><?= nl2br(htmlspecialchars($quoteText)) ?></p>
    </div>
  </div>

  <div class="search-box">
    <div class="tabs">
      <button type="button" class="tab active" data-search="jobs">Kërko një punë</button>
      <button type="button" class="tab" data-search="candidates">Kërko një kandidat</button>
    </div>
    <form class="filters filters-jobs" method="get" action="index.php#jobs-wrap">
      <input type="text" name="position" placeholder="Pozicioni" value="<?= htmlspecialchars($searchPosition ?? '') ?>">
      <select name="category">
        <option value="">Kategoria</option>
        <option value="IT"<?= ($searchCategory ?? '') === 'IT' ? ' selected' : '' ?>>IT</option>
        <option value="Marketing"<?= ($searchCategory ?? '') === 'Marketing' ? ' selected' : '' ?>>Marketing</option>
        <option value="Financa"<?= ($searchCategory ?? '') === 'Financa' ? ' selected' : '' ?>>Financa</option>
      </select>
      <input type="text" name="location" placeholder="Lokacioni" value="<?= htmlspecialchars($searchLocation ?? '') ?>">
      <button type="submit" class="search-btn">Kërko</button>
    </form>
    <div class="filters filters-candidates" style="display:none;">
      <input type="text" placeholder="Fusha / Specializimi">
      <select>
        <option value="">Eksperienca</option>
        <option value="all">Të gjitha</option>
        <option value="fillestar">Fillestar</option>
        <option value="1-3">1–3 vjet</option>
        <option value="3+">3+ vjet</option>
      </select>
      <input type="text" placeholder="Lokacioni">
      <button class="search-btn">Kërko</button>
    </div>
  </div>

  <div class="jobs-wrap" id="jobs-wrap">
    <h2>Punë të shtuara kohët e fundit</h2>
    <h3>Kohës së fundit</h3>
    <?php if ($searchPosition !== '' || $searchCategory !== '' || $searchLocation !== ''): ?>
      <p style="padding:0.5rem 1rem;color:#64748b;font-size:0.9rem;">
        <?= count($jobs) ?> punë u gjetën<?= ($searchPosition !== '' || $searchCategory !== '' || $searchLocation !== '') ? ' sipas kërkimit tuaj.' : '.' ?>
      </p>
    <?php endif; ?>

    <?php if (empty($jobs)): ?>
      <p style="padding:1rem;color:#64748b;"><?= ($searchPosition !== '' || $searchCategory !== '' || $searchLocation !== '') ? 'Nuk u gjet asnjë punë sipas kriterave. Provoni kërkimin tjetër.' : 'Nuk ka punë të shtuara ende. Kontrolloni më vonë.' ?></p>
    <?php else: ?>
      <?php foreach ($jobs as $job): ?>
        <?php
        $initials = '';
        $words = preg_split('/\s+/', trim($job['title']), 2);
        if (count($words) >= 2) {
          $initials = strtoupper(mb_substr($words[0], 0, 1) . mb_substr($words[1], 0, 1));
        } else {
          $initials = strtoupper(mb_substr($job['title'], 0, 2));
        }
        ?>
        <div class="job-card">
          <div class="left">
            <div class="avatar"><?= htmlspecialchars($initials) ?></div>
            <div class="details">
              <div class="job-title"><?= htmlspecialchars($job['title']) ?></div>
              <div class="company"><?= htmlspecialchars($job['company']) ?></div>
              <div class="location"><?= htmlspecialchars($job['location']) ?></div>
            </div>
          </div>
          <div class="right">
            <?php if (isset($_SESSION['user'])): ?>
              <button class="apply-btn">Apliko</button>
            <?php else: ?>
              <button class="apply-btn" onclick="location.href='auth/loginform.php'">Kyçu për të aplikuar</button>
            <?php endif; ?>
          </div>
        </div>
      <?php endforeach; ?>
    <?php endif; ?>
  </div>
</main>

<footer>
  <div class="elementet">
    <div class="object"><i class='bxr bx-book-open'></i><h4>Kërko miliona vende pune</h4><p>Kërko miliona vende pune dhe realizo ëndrrat profesionale.</p></div>
    <div class="object"><i class='bxr bx-people-diversity'></i><h4>Ekipe të mrekullueshme</h4><p>Rritu profesionalisht me ekipe të mrekullueshme.</p></div>
    <div class="object"><i class='bxr bx-buildings'></i><h4>Mjedis i mirë pune</h4><p>Shijo një mjedis të mirë pune dhe atmosferë.</p></div>
    <div class="object"><i class='bxr bx-biceps'></i><h4>Çdo ditë më i fortë</h4><p>Forcohu çdo ditë dhe tejkalo çdo pengesë.</p></div>
  </div>
  <div class="copyright">© 2025 VLERÉ. Të gjitha të drejtat e rezervuara.</div>
</footer>

<script src="assets/js/script.js"></script>
<script>
(function(){
  var params = new URLSearchParams(window.location.search);
  if (params.has('position') || params.has('category') || params.has('location')) {
    var el = document.getElementById('jobs-wrap');
    if (el) { el.scrollIntoView({ behavior: 'smooth', block: 'start' }); }
  }
})();
</script>
<?php if (!empty($slides) && count($slides) > 1): ?>
<script>
(function(){
  var slides = document.getElementById('sliderSlides');
  var dotsCont = document.getElementById('sliderDots');
  var prev = document.getElementById('sliderPrev');
  var next = document.getElementById('sliderNext');
  if (!slides || !dotsCont) return;
  var count = slides.children.length;
  var idx = 0;
  for (var i = 0; i < count; i++) {
    var d = document.createElement('button');
    d.className = 'slider-dot' + (i === 0 ? ' active' : '');
    d.setAttribute('type', 'button');
    d.setAttribute('aria-label', 'Slide ' + (i+1));
    (function(j){ d.addEventListener('click', function(){ goTo(j); }); })(i);
    dotsCont.appendChild(d);
  }
  function goTo(i) { idx = (i + count) % count; update(); }
  function update() {
    slides.style.transform = 'translateX(-' + (idx * 100) + '%)';
    var dots = dotsCont.querySelectorAll('.slider-dot');
    dots.forEach(function(d, i){ d.classList.toggle('active', i === idx); });
  }
  if (prev) prev.addEventListener('click', function(){ goTo(idx - 1); });
  if (next) next.addEventListener('click', function(){ goTo(idx + 1); });
  var t = setInterval(function(){ goTo(idx + 1); }, 5000);
})();
</script>
<?php endif; ?>
</body>
</html>

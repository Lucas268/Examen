<?php
require 'database/db.php';
session_start();

$zoekterm = isset($_GET['zoekterm']) ? $connection->real_escape_string($_GET['zoekterm']) : '';
$sql = !empty($zoekterm) ? 
    "SELECT id, title, bedrijf, description, thumbnail, start_datum, eind_datum FROM vacatures 
     WHERE title LIKE '%$zoekterm%' OR bedrijf LIKE '%$zoekterm%' OR description LIKE '%$zoekterm%'" :
    "SELECT id, title, bedrijf, description, thumbnail, start_datum, eind_datum FROM vacatures";

$result = $connection->query($sql);
?>
<!DOCTYPE html>
<html lang="nl">
<head>
  <meta charset="UTF-8">
  <title>Opdrachten Overzicht</title>
  <link rel="stylesheet" href="style.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

</head>
<body>
  <div class="navbar">
    <div>Open<span>OPDRACHTEN</span> 🔍</div>
    <div class="searchbar-container">
      <form method="GET">
        <input type="text" name="zoekterm" placeholder="Zoek opdrachten..." value="<?= isset($_GET['zoekterm']) ? htmlspecialchars($_GET['zoekterm']) : '' ?>">
      </form>
    </div>
    <div>
      <button onclick="location.href='/aanmaak-pagina/aanmaak.php'">Opdracht aanmaken</button>
      <?php if (isset($_SESSION['email'])): ?>
        <button onclick="location.href='/logout.php'">Logout</button>
      <?php else: ?>
        <button onclick="location.href='/inlog-pagina/inlog.php'">Login</button>
      <?php endif; ?>
    </div>
  </div>

  <div class="container">
    <div class="paneel opdrachten">
      <?php if ($result && $result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
          <div class="opdracht" onclick="showInfo(
            '<?= htmlspecialchars($row['title'], ENT_QUOTES) ?>',
            '<?= htmlspecialchars($row['bedrijf'], ENT_QUOTES) ?>',
            '<?= htmlspecialchars($row['description'], ENT_QUOTES) ?>',
            '<?= htmlspecialchars($row['thumbnail'] ?: '/images/default.png', ENT_QUOTES) ?>',
            '<?= htmlspecialchars($row['start_datum'], ENT_QUOTES) ?>',
            '<?= htmlspecialchars($row['eind_datum'], ENT_QUOTES) ?>'
          )">
            <h3><?= htmlspecialchars($row['title']); ?></h3>
            <p><strong>Bedrijf:</strong> <?= htmlspecialchars($row['bedrijf']); ?></p>
            <p><strong>Startdatum:</strong> <?= htmlspecialchars($row['start_datum']); ?></p>
            <p><strong>Einddatum:</strong> <?= htmlspecialchars($row['eind_datum']); ?></p>
            <p>➤ Beschrijving<br><?= htmlspecialchars($row['description']); ?></p>
            <div class="cta">
              <button>Solliciteren</button>
            </div>
          </div>
        <?php endwhile; ?>
      <?php else: ?>
        <p>Geen opdrachten beschikbaar.</p>
      <?php endif; ?>
    </div>

    <div class="paneel opdracht-info">
      <span class="close-btn" onclick="closeInfo()">×</span>
      <h2 id="info-title"></h2>
      <h4 id="info-bedrijf"></h4>
      <p><strong>Startdatum:</strong> <span id="info-start"></span></p>
      <p><strong>Einddatum:</strong> <span id="info-eind"></span></p>
      <img id="info-img" src="" alt="Opdracht afbeelding" style="max-width: 100%; height: auto; margin-top: 10px;">
      <p id="info-description"></p>
    </div>

    <div class="welkom">
      <h1>Welkom,<br><span><?= isset($_SESSION['email']) ? htmlspecialchars($_SESSION['email']) : 'Gast'; ?></span></h1>
    </div>
  </div>
</body>
</html>

  <script>
    function showInfo(title, bedrijf, description, imageSrc, startDatum, eindDatum) {
      const panel = document.querySelector('.opdracht-info');
      panel.classList.add('active');
      document.getElementById('info-title').innerText = title;
      document.getElementById('info-bedrijf').innerText = bedrijf;
      document.getElementById('info-description').innerText = description;
      document.getElementById('info-img').src = imageSrc || '/images/default.png';
      document.getElementById('info-start').innerText = startDatum || '-';
      document.getElementById('info-eind').innerText = eindDatum || '-';
    }
    function closeInfo() {
      document.querySelector('.opdracht-info').classList.remove('active');
    }
  </script>
<?php
require '../database/db.php';
session_start();

$zoekterm = isset($_GET['zoekterm']) ? $connection->real_escape_string($_GET['zoekterm']) : '';
$sql = !empty($zoekterm) ? 
    "SELECT id, title, bedrijf, description, thumbnail FROM vacatures 
     WHERE title LIKE '%$zoekterm%' OR bedrijf LIKE '%$zoekterm%' OR description LIKE '%$zoekterm%'" :
    "SELECT id, title, bedrijf, description, thumbnail FROM vacatures";

$result = $connection->query($sql);
?>
<!DOCTYPE html>
<html lang="nl">
<head>
  <meta charset="UTF-8">
  <title>Opdrachten Overzicht</title>
  <link rel="stylesheet" href="style.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <style>
    .searchbar-container {
      display: flex;
      align-items: center;
    }
    .searchbar-container form {
      display: flex;
      gap: 0.5rem;
    }
    .searchbar-container input[type="text"] {
      padding: 6px 10px;
      border: 1px solid #ccc;
      border-radius: 4px;
    }
    .searchbar-container button, .navbar button {
      padding: 6px 12px;
      background-color: #00b3a4;
      border: none;
      color: white;
      border-radius: 4px;
      cursor: pointer;
    }
    .navbar button:hover {
      background-color: #008f87;
    }
    .paneel.opdracht-info {
      display: none;
      position: relative;
    }
    .paneel.opdracht-info.active {
      display: block;
    }
    .close-btn {
      position: absolute;
      top: 8px;
      right: 12px;
      font-size: 20px;
      cursor: pointer;
      color: #888;
    }
    .close-btn:hover {
      color: black;
    }
  </style>
  <script>
    function showInfo(title, bedrijf, description, imageSrc) {
      const panel = document.querySelector('.opdracht-info');
      panel.classList.add('active');
      document.getElementById('info-title').innerText = title;
      document.getElementById('info-bedrijf').innerText = bedrijf;
      document.getElementById('info-description').innerText = description;
      document.getElementById('info-img').src = imageSrc;
    }
    function closeInfo() {
      document.querySelector('.opdracht-info').classList.remove('active');
    }
  </script>
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
      <button onclick="location.href='/aanmaak-pagina/aanmaak.php'">Aanmaak Pagina</button>
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
          <div class="opdracht" onclick="showInfo('<?= htmlspecialchars($row['title']) ?>', '<?= htmlspecialchars($row['bedrijf']) ?>', '<?= htmlspecialchars($row['description']) ?>', '<?= htmlspecialchars($row['thumbnail'] ?: '/images/default.png') ?>')">
            <h3><?= htmlspecialchars($row['title']); ?></h3>
            <p><?= htmlspecialchars($row['bedrijf']); ?></p>
            <p>➤ Beschrijving<br><?= htmlspecialchars($row['description']); ?></p>
            <?php if (!empty($row['thumbnail'])): ?>
              <img src="<?= htmlspecialchars($row['thumbnail']); ?>" alt="Thumbnail" style="max-width: 100%; height: auto;">
            <?php endif; ?>
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
      <img id="info-img" src="" alt="Opdracht afbeelding" style="max-width: 100%; height: auto;">
      <p id="info-description"></p>
    </div>

    <div class="welkom">
      <h1>Welkom,<br><span><?= isset($_SESSION['email']) ? htmlspecialchars($_SESSION['email']) : 'Gast'; ?></span></h1>
    </div>
  </div>
</body>
</html>

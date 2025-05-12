<?php
require '../database/db.php';
session_start();

// Fetch available assets from the database
$sql = "SELECT title, bedrijf, description, thumbnail FROM vacatures";
$result = $connection->query($sql);
?>
<!DOCTYPE html>
<html lang="nl">
<head>
  <meta charset="UTF-8">
  <title>Opdrachten Overzicht</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="navbar">
    <div>Open<span>OPDRACHTEN</span> 🔍</div>
    <div>Welkom, <strong><?= isset($_SESSION['email']) ? htmlspecialchars($_SESSION['email']) : 'Gast'; ?></strong></div>
    <div>
      <button onclick="location.href='/aanmaak-pagina/aanmaak.php'">Aanmaak Pagina</button>
      <button onclick="location.href='/inlog-pagina/inlog.php'">Login</button>
    </div>
  </div>

  <div class="container">
    <!-- Opdrachten -->
    <div class="paneel opdrachten">
      <?php if ($result && $result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
          <div class="opdracht">
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

    <!-- Opdracht Info -->
    <div class="paneel opdracht-info">
      <h2>Opdracht <span style="color:#00b3a4;">INFO</span></h2>
      <img src="VacatureImage.png" alt="Opdracht afbeelding">
      <p>"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua..."</p>
    </div>

    <!-- Welkom -->
    <div class="welkom">
      <h1>Welkom,<br><span><?= isset($_SESSION['email']) ? htmlspecialchars($_SESSION['email']) : 'Gast'; ?></span></h1>
    </div>
  </div>
</body>
</html>
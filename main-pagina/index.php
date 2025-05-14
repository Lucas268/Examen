<?php
require '../database/db.php';
session_start();

// Handle search input
$zoekterm = isset($_GET['zoekterm']) ? $connection->real_escape_string($_GET['zoekterm']) : '';
if (!empty($zoekterm)) {
    $sql = "SELECT title, bedrijf, description, thumbnail FROM vacatures 
            WHERE title LIKE '%$zoekterm%' 
               OR bedrijf LIKE '%$zoekterm%' 
               OR description LIKE '%$zoekterm%'";
} else {
    $sql = "SELECT title, bedrijf, description, thumbnail FROM vacatures";
}
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

    .searchbar-container button {
      padding: 6px 12px;
      background-color: #00b3a4;
      border: none;
      color: white;
      border-radius: 4px;
      cursor: pointer;
    }

    .navbar button {
      padding: 6px 12px;
      background-color: #00b3a4;
      border: none;
      color: white;
      border-radius: 4px;
      cursor: pointer;
      margin-left: 5px;
    }

    .navbar button:hover {
      background-color: #008f87;
    }
  </style>
</head>
<body>
  <div class="navbar">
    <div>Open<span>OPDRACHTEN</span> 🔍</div>
    
    <!-- hier staat alles voor de zoekbar -->
    <div class="searchbar-container">
      <form method="GET" action="">
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
    <!-- hier staan de Opdrachten in vertoond -->
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

    <!-- hierin staat de Opdracht Info -->
    <div class="paneel opdracht-info">
      <h2>Opdracht<span style="color:#00b3a4;">INFO</span></h2>
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

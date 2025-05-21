<?php
require 'database/db.php';
session_start();

if (!isset($_GET['id'])) {
    die("Geen opdracht ID opgegeven.");
}
$opdracht_id = intval($_GET['id']);

// Haal de opdracht op, alleen als de ingelogde gebruiker de eigenaar is
$email = $connection->real_escape_string($_SESSION['email']);
$res = $connection->query("SELECT * FROM vacatures WHERE id=$opdracht_id AND creator_email='$email'");
if (!$res || $res->num_rows === 0) {
    die("Opdracht niet gevonden of je bent niet de eigenaar.");
}
$row = $res->fetch_assoc();

// Verwerk het formulier
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['editOpdrachtId'])) {
    $opdrachtId = intval($_POST['editOpdrachtId']);
    $projectnaam = $connection->real_escape_string($_POST['projectnaam']);
    $bedrijf = $connection->real_escape_string($_POST['bedrijf']);
    $programmeertalen = $connection->real_escape_string($_POST['programmeertalen']);
    $opdracht = $connection->real_escape_string($_POST['opdracht']);
    $beschrijving = $connection->real_escape_string($_POST['beschrijving']);
    $startdatum = $connection->real_escape_string($_POST['startdatum']);
    $einddatum = $connection->real_escape_string($_POST['einddatum']);
    // Thumbnail uploaden? (optioneel, zie onder)

    $updateQuery = "
        UPDATE vacatures 
        SET title = '$projectnaam', bedrijf = '$bedrijf', programmeertalen = '$programmeertalen', description = '$beschrijving', opdracht = '$opdracht', start_datum = '$startdatum', eind_datum = '$einddatum'
        WHERE id = $opdrachtId AND creator_email = '$email'
    ";

    if ($connection->query($updateQuery)) {
        echo "<p style='color:green;'>Opdracht succesvol aangepast!</p>";
        // Eventueel: header('Location: index.php');
    } else {
        echo "<p style='color:red;'>Fout bij opslaan: " . $connection->error . "</p>";
    }
}
?>
<!DOCTYPE html>
<html lang="nl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Vacature Bewerken</title>
  <link rel="stylesheet" href="aanmaak-pagina/aanmaak.css">
</head>
<body>
  <div class="header">
    <h1>mijnVISTA</h1>
    <button onclick="location.href='index.php'" style="position: absolute; top: 10px; right: 10px;">Terug</button>
  </div>

  <div class="container">
    <h2>Vacature <strong>BEWERKEN</strong></h2>
    <form method="POST" enctype="multipart/form-data">
      <input type="hidden" name="editOpdrachtId" value="<?= htmlspecialchars($row['id']) ?>">
      <div class="form-group">
        <label for="projectnaam">Project Naam</label>
        <input type="text" id="projectnaam" name="projectnaam" value="<?= htmlspecialchars($row['title']) ?>" required>
      </div>
      <div class="form-group">
        <label for="bedrijf">Bedrijf</label>
        <input type="text" id="bedrijf" name="bedrijf" value="<?= htmlspecialchars($row['bedrijf']) ?>" required>
      </div>
      <div class="form-group">
        <label for="talen">Programmeer Talen</label>
        <input type="text" id="talen" name="programmeertalen" value="<?= htmlspecialchars($row['programmeertalen'] ?? '') ?>" required>
      </div>
      <div class="form-group">
        <label for="thumbnail">Thumbnail</label>
        <input type="file" id="thumbnail" name="thumbnail" accept="image/*" style="display: none;">
        <button type="button" class="upload-button" onclick="document.getElementById('thumbnail').click();">Uploaden</button>
        <?php if (!empty($row['thumbnail'])): ?>
          <div><img src="<?= htmlspecialchars($row['thumbnail']) ?>" alt="Huidige thumbnail" style="max-width:100px;"></div>
        <?php endif; ?>
      </div>
      <div class="form-group">
        <label for="opdracht">Opdracht</label>
        <textarea id="opdracht" name="opdracht" required><?= htmlspecialchars($row['opdracht'] ?? '') ?></textarea>
      </div>
      <div class="form-group">
        <label for="beschrijving">Beschrijving</label>
        <textarea id="beschrijving" name="beschrijving" required><?= htmlspecialchars($row['description']) ?></textarea>
      </div>
      <div class="form-group">
        <label for="startdatum">Startdatum</label>
        <input type="date" id="startdatum" name="startdatum" value="<?= htmlspecialchars($row['start_datum']) ?>" required>
      </div>
      <div class="form-group">
        <label for="einddatum">Einddatum</label>
        <input type="date" id="einddatum" name="einddatum" value="<?= htmlspecialchars($row['eind_datum']) ?>" required>
      </div>
      <div class="form-group full-width">
        <button type="submit" class="submit-button">OPSLAAN</button>
      </div>
    </form>
  </div>
  <script>
    const form = document.querySelector('form');
    const submitButton = document.querySelector('.submit-button');
    form.addEventListener('submit', () => {
      submitButton.style.backgroundColor = '#E56642';
      submitButton.style.color = 'white';
    });
  </script>
</body>
</html>

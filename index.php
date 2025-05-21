<?php
require 'database/db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['solliciteer_id']) && isset($_SESSION['email'])) {
    $vacature_id = intval($_POST['solliciteer_id']);
    $user_email = $connection->real_escape_string($_SESSION['email']);
    $res = $connection->query("SELECT Inschrijvingen FROM vacatures WHERE id=$vacature_id");
    $row = $res->fetch_assoc();
    $inschrijvingen = $row ? explode(',', $row['Inschrijvingen']) : [];
    if (!in_array($user_email, $inschrijvingen)) {
        $inschrijvingen[] = $user_email;
        $new_Inschrijvingen = $connection->real_escape_string(implode(',', array_filter($inschrijvingen)));
        $connection->query("UPDATE vacatures SET Inschrijvingen='$new_Inschrijvingen' WHERE id=$vacature_id");
        $signup_message = "Je bent succesvol ingeschreven!";
    } else {
        $signup_message = "Je bent al ingeschreven voor deze opdracht.";
    }
}
// Uitschrijven
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['uitschrijf_id']) && isset($_SESSION['email'])) {
    $vacature_id = intval($_POST['uitschrijf_id']);
    $user_email = $connection->real_escape_string($_SESSION['email']);
    $res = $connection->query("SELECT Inschrijvingen FROM vacatures WHERE id=$vacature_id");
    $row = $res->fetch_assoc();
    $inschrijvingen = $row ? explode(',', $row['Inschrijvingen']) : [];
    $inschrijvingen = array_filter($inschrijvingen, function($email) use ($user_email) {
        return $email !== $user_email && $email !== '';
    });
    $new_Inschrijvingen = $connection->real_escape_string(implode(',', $inschrijvingen));
    $connection->query("UPDATE vacatures SET Inschrijvingen='$new_Inschrijvingen' WHERE id=$vacature_id");
    $signup_message = "Je bent uitgeschreven voor deze opdracht.";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id']) && isset($_SESSION['email'])) {
    $vacature_id = intval($_POST['delete_id']);
    // Controleer of de gebruiker de eigenaar is
    $res = $connection->query("SELECT creator_email FROM vacatures WHERE id=$vacature_id");
    $row = $res->fetch_assoc();
    if ($row && $row['creator_email'] === $_SESSION['email']) {
        $connection->query("DELETE FROM vacatures WHERE id=$vacature_id");
        $signup_message = "Opdracht verwijderd.";
    }
}

$zoekterm = isset($_GET['zoekterm']) ? $connection->real_escape_string($_GET['zoekterm']) : '';
$sql = !empty($zoekterm) ? 
    "SELECT id, title, bedrijf, description, thumbnail, start_datum, eind_datum, creator_email, Inschrijvingen, programmeertalen FROM vacatures 
     WHERE title LIKE '%$zoekterm%' OR bedrijf LIKE '%$zoekterm%' OR description LIKE '%$zoekterm%'" :
    "SELECT id, title, bedrijf, description, thumbnail, start_datum, eind_datum, creator_email, Inschrijvingen, programmeertalen FROM vacatures";

$result = $connection->query($sql);
if ($result === false) {
    die("SQL Fout: " . $connection->error);
}
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
      top: 2px;
      right: 12px;
      font-size: 20px;
      cursor: pointer;
      color: #888;
    }
    .close-btn:hover {
      color: black;
    }
    .opdracht p {
      margin: 0.2rem 0;
    }
  </style>
  <script>
    function showInfo(title, bedrijf, description, imageSrc, startDatum, eindDatum, opdrachtId, creatorEmail, programmeertalen) {
      const panel = document.querySelector('.opdracht-info');
      panel.classList.add('active');
      document.getElementById('info-title').innerText = title;
      document.getElementById('info-bedrijf').innerText = bedrijf;
      document.getElementById('info-description').innerText = description;
      document.getElementById('info-img').src = imageSrc || '/images/default.png';
      document.getElementById('info-start').innerText = startDatum || '-';
      document.getElementById('info-eind').innerText = eindDatum || '-';
      document.getElementById('info-programmeertalen').innerText = programmeertalen || '-';

      const editDeleteDiv = document.getElementById('edit-delete-btns');
      <?php if (isset($_SESSION['email'])): ?>
        const loggedInEmail = <?= json_encode($_SESSION['email']) ?>;
        if (creatorEmail === loggedInEmail) {
          editDeleteDiv.style.display = 'block';
          document.getElementById('edit-link').href = 'index_Func.php?id=' + opdrachtId;
          document.getElementById('delete-id').value = opdrachtId;
        } else {
          editDeleteDiv.style.display = 'none';
        }
      <?php else: ?>
        editDeleteDiv.style.display = 'none';
      <?php endif; ?>
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
      <?php if (isset($signup_message)): ?>
        <p style="color:green;"><?= htmlspecialchars($signup_message) ?></p>
      <?php endif; ?>
      <?php if ($result && $result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
          <?php
            $already_signed_up = false;
            if (isset($_SESSION['email'])) {
                $inschrijvingen = array_filter(explode(',', $row['Inschrijvingen'] ?? ''));
                $already_signed_up = in_array($_SESSION['email'], $inschrijvingen);
            }
          ?>
          <div class="opdracht" onclick="showInfo(
            '<?= htmlspecialchars($row['title'], ENT_QUOTES) ?>',
            '<?= htmlspecialchars($row['bedrijf'], ENT_QUOTES) ?>',
            '<?= htmlspecialchars($row['description'], ENT_QUOTES) ?>',
            '<?= htmlspecialchars($row['thumbnail'] ?: '/images/default.png', ENT_QUOTES) ?>',
            '<?= htmlspecialchars($row['start_datum'], ENT_QUOTES) ?>',
            '<?= htmlspecialchars($row['eind_datum'], ENT_QUOTES) ?>',
            '<?= $row['id'] ?>', 
            '<?= htmlspecialchars($row['creator_email'], ENT_QUOTES) ?>',
            '<?= htmlspecialchars($row['programmeertalen'] ?? '', ENT_QUOTES) ?>'
          )">
            <h3><?= htmlspecialchars($row['title']); ?></h3>
            <p><strong>Bedrijf:</strong> <?= htmlspecialchars($row['bedrijf']); ?></p>
            <p><strong>Startdatum:</strong> <?= htmlspecialchars($row['start_datum']); ?></p>
            <p><strong>Einddatum:</strong> <?= htmlspecialchars($row['eind_datum']); ?></p>
            <p>➤ Beschrijving<br><?= htmlspecialchars($row['description']); ?></p>
            <div class="cta">
              <?php if (!isset($_SESSION['email'])): ?>
                <button onclick="location.href='/inlog-pagina/inlog.php'">Login om te solliciteren</button>
              <?php elseif ($_SESSION['email'] === ($row['creator_email'] ?? '')): ?>
                <button disabled>Eigen opdracht</button>
              <?php elseif ($already_signed_up): ?>
                <form method="POST" style="display:inline;">
                  <input type="hidden" name="uitschrijf_id" value="<?= $row['id'] ?>">
                  <button type="submit" style="background-color:#e74c3c;">Uitschrijven</button>
                </form>
              <?php else: ?>
                <form method="POST" style="display:inline;">
                  <input type="hidden" name="solliciteer_id" value="<?= $row['id'] ?>">
                  <button type="submit">Solliciteren</button>
                </form>
              <?php endif; ?>
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
      <p><strong>Programmeertalen:</strong> <span id="info-programmeertalen"></span></p>
      <img id="info-img" src="" alt="Opdracht afbeelding" style="max-width: 100%; height: auto; margin-top: 10px;">
      <p id="info-description"></p>
      <div id="edit-delete-btns" style="display:none; margin-top:10px;">
        <a id="edit-link" href="#" class="btn" style="background:#003F41;color:#fff;padding:6px 12px;border-radius:4px;text-decoration:none;">Bewerken</a>
        <form method="POST" style="display:inline;">
          <input type="hidden" name="delete_id" id="delete-id" value="">
          <button type="submit" style="background:#D6715B;color:#fff;padding:6px 12px;border:none;border-radius:4px;cursor:pointer;">Verwijderen</button>
        </form>
      </div>
    </div>

    <div class="welkom">
      <h1>Welkom,<br><span><?= isset($_SESSION['email']) ? htmlspecialchars($_SESSION['email']) : 'Gast'; ?></span></h1>
    </div>
  </div>
</body>
</html>

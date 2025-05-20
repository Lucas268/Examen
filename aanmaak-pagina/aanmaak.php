<?php
require '../database/db.php';
require 'vacature_aanmaak_func.php';
?>
<!DOCTYPE html>
<html lang="nl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Vacature Aanmaken</title>
  <link rel="stylesheet" href="aanmaak.css">

</head>
<body>
  <div class="header">
    <h1>mijnVISTA</h1>
    <button onclick="location.href='../index.php'" style="position: absolute; top: 10px; right: 10px;">Terug</button>
  </div>

  <div class="container">
    
    <h2>Vacature <strong>AANMAKEN</strong></h2>
    <form action="vacature_aanmaak_func.php" method="POST" enctype="multipart/form-data">
      <div class="form-group">
        <label for="projectnaam">Project Naam</label>
        <input type="text" id="projectnaam" name="projectnaam" required>
      </div>
      <div class="form-group">
        <label for="bedrijf">Bedrijf</label>
        <input type="text" id="bedrijf" name="bedrijf" required>
      </div>
      <div class="form-group">
        <label for="talen">Programmeer Talen</label>
        <input type="text" id="talen" name="programmeertalen" required>
      </div>
      <div class="form-group">
        <label for="thumbnail">Thumbnail</label>
        <input type="file" id="thumbnail" name="thumbnail" accept="image/*" style="display: none;">
        <button type="button" class="upload-button" onclick="document.getElementById('thumbnail').click();">Uploaden</button>
      </div>
      <div class="form-group">
        <label for="opdracht">Opdracht</label>
        <textarea id="opdracht" name="opdracht" required></textarea>
      </div>
      <div class="form-group">
        <label for="beschrijving">Beschrijving</label>
        <textarea id="beschrijving" name="beschrijving" required></textarea>
      </div>
      <div class="form-group">
        <label for="startdatum">Startdatum</label>
        <input type="date" id="startdatum" name="startdatum" required>
      </div>
      <div class="form-group">
        <label for="einddatum">Einddatum</label>
        <input type="date" id="einddatum" name="einddatum" required>
      </div>
      <div class="form-group full-width">
        <button type="submit" class="submit-button">VERSTUREN!</button>
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




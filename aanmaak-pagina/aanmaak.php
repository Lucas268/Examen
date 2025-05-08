<?php
require '../database/db.php';
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
    <div class="search-bar">
      <input type="text" placeholder="Zoeken">
    </div>
  </div>

  <div class="container">
    <div class="close-button">&times;</div>
    <h2>Vacature <strong>AANMAKEN</strong></h2>
    <form>
      <div class="form-group">
        <label for="projectnaam">Project Naam</label>
        <input type="text" id="projectnaam">
      </div>
      <div class="form-group">
        <label for="bedrijf">Bedrijf</label>
        <input type="text" id="bedrijf">
      </div>
      <div class="form-group">
        <label for="talen">Programmeer Talen</label>
        <input type="text" id="talen">
      </div>
      <div class="form-group">
        <label for="thumbnail">Thumbnail</label>
        <button class="upload-button" disabled>Uploaden</button>
      </div>
      <div class="form-group">
        <label for="opdracht">Opdracht</label>
        <textarea id="opdracht"></textarea>
      </div>
      <div class="form-group">
        <label for="beschrijving">Beschrijving</label>
        <textarea id="beschrijving"></textarea>
      </div>
      <div class="form-group">
        <label for="startdatum">Startdatum</label>
        <input type="date" id="startdatum" name="startdatum">
      </div>
      <div class="form-group">
        <label for="einddatum">Einddatum</label>
        <input type="date" id="einddatum" name="einddatum">
      </div>
      <div class="form-group full-width">
        <button type="submit" class="submit-button">VERSTUREN!</button>
      </div>
    </form>
  </div>
</body>
</html>

<!DOCTYPE html>
<html lang="nl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Vacature Aanmaken</title>
  <style>
    body {
      margin: 0;
      font-family: Arial, sans-serif;
      background-color: #f5f5f5;
    }

    .header {
      background-color: #155c5e;
      padding: 1rem 2rem;
      color: white;
      display: flex;
      align-items: center;
      justify-content: space-between;
    }

    .header h1 {
      margin: 0;
      font-size: 1.5rem;
    }

    .search-bar input {
      padding: 0.5rem;
      border-radius: 20px;
      border: none;
      width: 300px;
    }

    .container {
      background-color: white;
      margin: 2rem auto;
      padding: 2rem 3rem;
      border-radius: 10px;
      width: 90%;
      max-width: 1400px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      position: relative;
    }

    .close-button {
      position: absolute;
      top: 1rem;
      right: 1rem;
      font-size: 2rem;
      color: #155c5e;
      cursor: pointer;
    }

    .container h2 {
      color: #155c5e;
      margin-bottom: 2rem;
    }

    form {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 1.2rem 2rem;
    }

    .form-group {
      display: flex;
      flex-direction: column;
      gap: 0.3rem;
    }

    label {
      color: #155c5e;
      font-weight: bold;
      font-size: 1rem;
    }

    input[type="text"],
    textarea,
    select {
      padding: 0.9rem 1.2rem;
      border-radius: 25px;
      border: none;
      background-color: #d8cccc;
      font-size: 1rem;
    }

    textarea {
      resize: none;
      height: 150px;
    }

    .upload-button {
      padding: 0.9rem;
      background-color: #d8cccc;
      border: none;
      border-radius: 12px;
      cursor: not-allowed;
      font-size: 1rem;
    }

    .submit-button {
      padding: 0.9rem 2rem;
      background-color: #155c5e;
      color: white;
      border: none;
      border-radius: 30px;
      font-weight: bold;
      font-size: 1.2rem;
      justify-self: end;
      margin-top: 1rem;
    }

    .form-group.full-width {
      grid-column: 2;
      justify-content: flex-end;
      display: flex;
    }
  </style>
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
        <label for="opdracht">Opdracht</label>
        <textarea id="opdracht"></textarea>
      </div>
      <div class="form-group">
        <label for="beschrijving">Beschrijving</label>
        <textarea id="beschrijving"></textarea>
      </div>
      <div class="form-group">
        <label for="thumbnail">Thumbnail</label>
        <button class="upload-button" disabled>Uploaden</button>
      </div>
      <div class="form-group">
        <label for="startdatum">Startdatum</label>
        <select id="startdatum">
          <option>Kies een datum</option>
        </select>
      </div>
      <div class="form-group">
        <label for="einddatum">Einddatum</label>
        <select id="einddatum">
          <option>Kies een datum</option>
        </select>
      </div>
      <div class="form-group full-width">
        <button type="submit" class="submit-button">VERSTUREN!</button>
      </div>
    </form>
  </div>
</body>
</html>

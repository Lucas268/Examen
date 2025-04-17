<!DOCTYPE html>
<html lang="nl">
<head>
  <meta charset="UTF-8">
  <title>Vacature Overzicht</title>
  <style>
    body {
         margin: 0;
        font-family: 'Segoe UI', sans-serif;
      background: #e4e4e4 url('Group29.png') no-repeat bottom -10px right -80px;
      background-size: 450px auto; /* iets kleiner voor subtielere look */
      background-attachment: fixed;
    }


    .navbar {
      background-color: #004f51;
      padding: 15px 30px;
      color: white;
      font-size: 1.2em;
      font-weight: bold;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .navbar span {
      color: #00b3a4;
    }

    .container {
      display: flex;
      gap: 20px;
      padding: 20px;
    }

    .paneel {
      background: white;
      border-radius: 10px;
      box-shadow: 0 4px 6px rgba(0,0,0,0.1);
      position: relative;
      display: flex;
      flex-direction: column;
    }

    .paneel::before {
      content: '';
      height: 30px;
      width: 100%;
      background-color: #004f51;
      border-top-left-radius: 10px;
      border-top-right-radius: 10px;
      position: absolute;
      top: 0;
      left: 0;
    }

    .vacatures {
      flex: 1;
      padding: 20px;
    }

    .vacature {
      background: #f9f9f9;
      border-radius: 15px;
      margin-bottom: 15px;
      padding: 15px;
    }

    .vacature h3 {
      margin: 0 0 5px;
    }

    .vacature .cta {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-top: 10px;
    }

    .vacature .cta button {
      background: #004f51;
      color: white;
      padding: 8px 15px;
      border: none;
      border-radius: 20px;
      cursor: pointer;
    }

    .vacature-info {
      flex: 2;
      padding: 20px;
    }

    .vacature-info img {
      width: 100%;
      border-radius: 10px;
      margin: 10px 0;
    }

    .welkom {
      flex: 1;
      padding: 20px;
      color: #004f51;
      background: none; /* 🔥 Achtergrond weggehaald */
    }

    .welkom h1 {
      font-size: 1.8em;
      font-weight: 300;
    }

    .welkom h1 span {
      font-weight: 700;
    }
  </style>
</head>
<body>

  <div class="navbar">
    <div>Open<span>VACATURES</span> 🔍</div>
    <div>Welkom, <strong>Caio Goessens</strong></div>
  </div>

  <div class="container">
    <!-- Vacatures -->
    <div class="paneel vacatures">
      <div class="vacature">
        <h3>Visvijver Website</h3>
        <p>Caio Goessens</p>
        <p>➤ Beschrijving<br>We willen onze klanten een gebruiksvriendelijke en aantrekkelijke website bieden...</p>
        <div class="cta">
          <span>Studenten: 6</span>
          <button>Solliciteren</button>
        </div>
      </div>
      <!-- Meer vacatures indien gewenst -->
    </div>

    <!-- Vacature Info -->
    <div class="paneel vacature-info">
      <h2>Vacature <span style="color:#00b3a4;">INFO</span></h2>
      <img src="VacatureImage.png" alt="Vacature afbeelding">
      <p>"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua..."</p>
    </div>

    <!-- Welkom -->
    <div class="welkom">
      <h1>Welkom,<br><span>Caio Goessens</span></h1>
    </div>
  </div>

</body>
</html>

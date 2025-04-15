<!DOCTYPE html>
<html lang="nl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Vacature Overzicht</title>
  <style>
    body {
      margin: 0;
      font-family: 'Segoe UI', sans-serif;
      background-color: #e4e4e4;
      display: flex;
      gap: 20px;
      padding: 20px;
    }

    .vacatures, .vacature-info, .welkom {
      background: white;
      border-radius: 10px;
      box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    }

    /* Vacatures links */
    .vacatures {
      flex: 1;
      padding: 20px;
    }

    .vacatures h2 {
      color: #004f51;
      font-weight: 700;
      margin-bottom: 10px;
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

    .vacature p {
      font-size: 0.9em;
      color: #444;
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

    /* Info midden */
    .vacature-info {
      flex: 2;
      padding: 20px;
      display: flex;
      flex-direction: column;
    }

    .vacature-info h2 {
      color: #004f51;
    }

    .vacature-info img {
      width: 100%;
      border-radius: 10px;
      margin: 10px 0;
    }

    .vacature-info p {
      font-size: 0.9em;
      color: #333;
    }

    /* Welkom rechts */
    .welkom {
      flex: 1;
      padding: 20px;
      position: relative;
      display: flex;
      flex-direction: column;
      justify-content: center;
    }

    .welkom h1 {
      font-size: 1.8em;
      font-weight: 300;
    }

    .welkom h1 span {
      color: #004f51;
      font-weight: 700;
    }

    .badge {
      position: absolute;
      background: #fff169;
      color: #004f51;
      font-weight: bold;
      padding: 20px;
      border-radius: 50%;
      transform: rotate(-15deg);
      top: 60%;
      right: 20%;
      font-size: 1em;
    }

    .hoek {
      position: absolute;
      right: 0;
      bottom: 0;
      width: 0;
      height: 0;
      border-left: 150px solid #d76d50;
      border-top: 150px solid transparent;
    }
  </style>
</head>
<body>

  <div class="vacatures">
    <h2>Open<span style="color:#009999;">VACATURES</span> 🔍</h2>

    <div class="vacature">
      <h3>Visvijver Website</h3>
      <p>Caio Goessens</p>
      <p>➤ Beschrijving<br>We willen onze klanten een gebruiksvriendelijke en aantrekkelijke website bieden...</p>
      <div class="cta">
        <span>Studenten: 6</span>
        <button>Solliciteren</button>
      </div>
    </div>

    <div class="vacature">
      <h3>Visvijver Website</h3>
      <p>Caio Goessens</p>
      <p>➤ Beschrijving<br>We willen onze klanten een gebruiksvriendelijke en aantrekkelijke website bieden...</p>
      <div class="cta">
        <span>Studenten: 6</span>
        <button>Solliciteren</button>
      </div>
    </div>

    <div class="vacature">
      <h3>Visvijver Website</h3>
      <p>Caio Goessens</p>
      <p>➤ Beschrijving<br>We willen onze klanten een gebruiksvriendelijke en aantrekkelijke website bieden...</p>
      <div class="cta">
        <span>Studenten: 6</span>
        <button>Solliciteren</button>
      </div>
    </div>
  </div>

  <div class="vacature-info">
    <h2>Vacature<span style="color:#009999;">INFO</span></h2>
    <img src="https://images.unsplash.com/photo-1604079628041-94337e3be1fa" alt="Vacature afbeelding">
    <p>"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua..."</p>
  </div>

  <div class="welkom">
    <h1>Welkom,<br><span>Caio Goessens</span></h1>
    <div class="badge">WIJ ZIEN JOU!</div>
    <div class="hoek"></div>
  </div>

</body>
</html>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Corpus Christi Parish</title>
    <style>
      body {
        margin: 0;
        font-family: "Comic Sans MS", cursive, sans-serif;
        background-color: #e9e3a1;
        text-align: center;
      }

      .header {
        padding-top: 30px;
      }

      .logo {
        width: 80px;
        border-radius: 45px;
        margin-bottom: 10px;
      }

      .title {
        font-size: 1.5em;
        margin-bottom: 10px;
      }

      h2 {
        font-size: 2em;
        margin-bottom: 20px;
      }

      .event-container {
        display: flex;  
        gap: 30px;
        background-color: #654b4b;
        padding: 50px 0;
        border-radius: 20px;
        margin: 0 auto;
        max-width: 2000px;
      }

      .event {
        background-color: #654b4b;
        color: white;
        width: 600px;
      }

      .event img {
        width: 100%;
        border-radius: 20px;
      }

      .event-title {
        margin: 10px 0;
        font-weight: bold;
        font-size: 1.2em;
      }

      .book-btn {
        margin-top: 10px;
        background-color: #dedc75;
        color: black;
        padding: 10px 30px;
        font-weight: bold;
        border: none;
        border-radius: 20px;
        cursor: pointer;
        width: 630px;
      }

      .book-btn:hover {
        background-color: #c5c356;
      }
    </style>
  </head>
  <body>
    <div class="header">
      <a href="index.php"><img class="logo" src="logo.jpg" alt="Logo" /></a>
      <div class="title">Corpus Christi Parish: Event Booking</div>
      <h2>Choose an Event</h2>
    </div>

    <div class="event-container">
      <div class="event">
        <a href="wedding.php"><img src="wedding(2).jpg" alt="Wedding" /></a>
        <div class="event-title">WEDDING</div>
      </div>
      <div class="event">
        <a href="Baptismal.php"><img src="Baptismal.jpg" alt="Baptismal" /></a>
        <div class="event-title">BAPTISMAL</div>
      </div>
      <div class="event">
        <a href="Burial.php"><img src="Burial.jpg" alt="Burial" /></a>
        <div class="event-title">BURIAL</div>
      </div>
    </div>    
  </body>
</html>

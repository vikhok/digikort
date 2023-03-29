<?php
require_once("../assets/include/header.inc.php");
require_once("../assets/include/footer.inc.php");
?>

    <?php banner(false) ?>
    <!DOCTYPE html>
<html lang="no">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content-notat="width=device-width, initial-scale=1.0" />
    <title>Notater</title>
    <link rel="stylesheet" href="../assets/styles/styles.css">
  </head>
  <body>
    <main>
        <br>
            <br>
            <h1>Mine notater</h1>
      <section>
        <div class="notat-boks-wrapper">
          <div class="notat-boks">
            <h3>Notat 1: </h3>
            <p>Husk å luft barnet.</p>
          </div>
        </div>
        <div class="notat-boks-wrapper">
          <div class="notat-boks">
            <h3>Notat 2:</h3>
            <p>Husk å luft katten.</p>
          </div>
        </div>
        <div class="notat-boks-wrapper">
          <div class="notat-boks">
            <h3>Notat 3:</h3>
            <p>Husk å luft hunden.</p>
          </div>
        </div>
      </section>
       
      <form action="notes.php">
      <div class="button-mine-notater">
  <button type="submit">Nytt notat</button>
</form>
    </main>
  </body>
</html>

    <?php footer() ?>

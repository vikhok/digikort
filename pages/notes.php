<?php
require_once("../assets/include/header.inc.php");
require_once("../assets/include/footer.inc.php");

require_once("../assets/include/db.inc.php");


// Sjekk om tittel og notat-tekst er sendt inn via POST
if (isset($_POST['title']) && isset($_POST['note'])) {
  // Lagre notatet i en fil (kun som eksempel)
  $filename = '../assets/notes/' . time() . '.txt';
  $title = $_POST['title'];
  $note = $_POST['note'];
  file_put_contents($filename, $title . "\n" . $note);
  
  // Gå til mine-notater.php for å se notatet
  header('Location: mine-notater.php');
  exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Nytt notat</title>
  <link rel="stylesheet" href="../assets/styles/styles.css">
</head>
<body>
  <?php banner(false) ?>
  <div class="container-notat">
    <div class="content-notat">
      <div class="button-notat">
        <div class="textarea-notat">
          <div class="label-notat">
            <br>
            <br>
            <h1>Nytt notat</h1>
            <form method="post">
              <input type="text" placeholder="Tittel:" id="title" name="title" required>
              <textarea id="note" placeholder="Notat:" name="note" rows="13" required></textarea>
              <button type="submit">Lagre</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php footer() ?>
</body>
</html>
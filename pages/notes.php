<?php
require_once("../assets/include/header.inc.php");
require_once("../assets/include/footer.inc.php");
require_once("../assets/include/db.inc.php");

// Legg til et nytt notat hvis skjemaet er sendt inn
if (isset($_POST['submit'])) {
  $note_title = $_POST['note_title'];
  $note_text = $_POST['note_text'];
  if (create_note($_SESSION['user_id'], $note_title, $note_text)) {
    header('Location: mine-notater.php');
    exit();
  } else {
    $error = 'Kunne ikke legge til notatet';
  }
}

?>

<!DOCTYPE html>
<html lang="no">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Nytt notat</title>
</head>
<body>
  <?php banner(false) ?>
  <main>
    <br>
    <br>
    <h1>Nytt notat</h1>
    <form action="notes.php" method="POST">
      <div class="form-group">
        <label for="note_title">Tittel:</label>
        <input type="text" name="note_title" id="note_title" required>
      </div>
      <div class="form-group">
        <label for="note_text">Tekst:</label>
        <textarea name="note_text" id="note_text" rows="4" required></textarea>
      </div>
      <button type="submit" name="submit">Legg til notat</button>
    </form>
  </main>
</body>
</html>

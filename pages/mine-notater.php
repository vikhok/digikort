<?php
require_once("../assets/include/header.inc.php");
require_once("../assets/include/footer.inc.php");

require_once("../assets/include/db.inc.php");

// Sjekk om notatet skal slettes
if (isset($_GET['delete'])) {
  $filename = $_GET['delete'];
  if (file_exists($filename)) {
    unlink($filename);
  }
}

// Hent alle notatfilene fra assets/notes
$notes = array();
foreach (glob('../assets/notes/*.txt') as $filename) {
  $note_lines = file($filename);
  $title = trim($note_lines[0]);
  $note = trim(implode(array_slice($note_lines, 1)));
  $notes[] = array('filename' => $filename, 'title' => $title, 'note' => $note);
}
?>

<!DOCTYPE html>
<html lang="no">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Notater</title>
  <link rel="stylesheet" href="../assets/styles/styles.css">
</head>
<body>
<?php banner(false) ?>
  <main>
    <br>
    <br>
    <h1>Mine notater</h1>
    <section>
      <?php foreach ($notes as $note): ?>
      <div class="notat-boks-wrapper">
        <div class="notat-boks">
          <h3><?= $note['title'] ?></h3>
          <p><?= $note['note'] ?></p>
          <form action="notes.php" method="GET">
            <button type="submit" name="delete" value="<?= $note['filename'] ?>">Slett notat</button>
          </form>
        </div>
      </div>
      <?php endforeach; ?>
    </section>
    <form action="notes.php">
      <div class="button-mine-notater">
        <button type="submit">Nytt notat</button>
      </div>
    </form>
  </main>
  <?php footer() ?>
</body>
</html>
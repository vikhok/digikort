<?php
require_once("../assets/include/header.inc.php");
require_once("../assets/include/footer.inc.php");
require_once("../assets/include/db.inc.php");

session_start();

// Sjekk om notatet skal slettes
if (isset($_GET['delete']) && isset($_SESSION['user_id'])) {
  $note_id = $_GET['delete'];
  if (delete_note($note_id, $_SESSION['user_id'])) {
    header('Location: mine-notater.php');
    exit();
  } else {
    $error = 'Kunne ikke slette notatet';
  }
}

// Oppdater notatet hvis skjemaet er sendt inn
if (isset($_POST['submit']) && isset($_SESSION['user_id'])) {
  $note_id = $_POST['note_id'];
  $note_title = $_POST['note_title'];
  $note_text = $_POST['note_text'];

  // Sjekk om notatet eksisterer før oppdatering
  $note = get_all_notes($user_id);
  if ($note && $note['user_id'] === $_SESSION['user_id']) {
    if (edit_note($note_id, $_SESSION['user_id'], $note_title, $note_text)) {
      header('Location: mine-notater.php');
      exit();
    } else {
      $error = 'Kunne ikke oppdatere notatet';
    }
  } else {
    $error = 'Notatet eksisterer ikke eller tilhører ikke den gjeldende brukeren.';
  }
}

?>

<!DOCTYPE html>
<html lang="no">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Notater</title>
</head>
<body>
  <?php banner(false) ?>
  <main>
    <br>
    <br>
    <h1>Mine notater</h1>
    <?php if (is_countable($user_notes) && count($user_notes) == 0): ?>
      <p>Du har ingen notater.</p>
    <?php else: ?>
      <section>
        <?php foreach ($user_notes as $note): ?>
          <div class="notat-boks-wrapper">
            <div class="notat-boks">
              <h3><?= htmlspecialchars($note['note_title']) ?></h3>
              <p><?= htmlspecialchars($note['note_text']) ?></p>
              <form action="mine-notater.php" method="GET">
                <button type="submit" name="delete" value="<?= htmlspecialchars($note['note_id']) ?>">Slett notat</button>
              </form>
              <form action="mine-notater.php" method="POST">
                <input type="hidden" name="note_id" value="<?= htmlspecialchars($note['note_id']) ?>">
                <div class="form-group">
                  <label for="note_title">Tittel</label>
                  <input type="text" name="note_title" value="<?= htmlspecialchars($note['note_title']) ?>" required>
                </div>
                <div class="form-group">
                  <label for="note_text">Tekst</label>
                  <textarea name="note_text" required><?= htmlspecialchars($note['note_text']) ?></textarea>
                <button type="submit" name="submit">Oppdater notat</button>
              </form>
            </div>
          </div>
        <?php endforeach; ?>
      </section>
    <?php endif; ?>
    <form action="nytt-notat.php">
      <div class="button-mine-notater">
        <button type="submit">Nytt notat</button>
      </div>
    </form>
  </main>
</body>
</html>

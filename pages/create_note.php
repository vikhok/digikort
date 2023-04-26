<?php
    require_once("../assets/include/header.inc.php");
    require_once("../assets/include/db.inc.php");
    require_once("../assets/include/util.inc.php");

    session_start();
    $user_id = $_SESSION["user"]["user_id"];

    // Legg til et nytt notat hvis skjemaet er sendt inn
    if(isset($_REQUEST["create"])) {
        $note_subject = clean($_REQUEST["note_subject"]);
        $note_body = clean($_REQUEST["note_body"]);
        if($note_id = create_note($user_id, $note_subject, $note_body)) {
            header("Location: note.php?note_id=$note_id");
        } else {
            $status = "<h4><span style='color:red'>
                    Noe gikk galt, notat ble ikke lagret.
                    </span></h4>";
        }
    }
?>
<!DOCTYPE html>
<html lang="no">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../assets/styles/styles.css">
    <title>Nytt notat</title>
</head>
<body>
    <?php banner() ?>
    <main>
        <h1 class="h1_create_note">Nytt notat</h1>
        <form class="form_create_note" action="" method="POST">
            <div class="form-group">
                <label for="note_subject"><h3>Tittel:</h3></label>
                <input type="text" name="note_subject" id="note_subject" maxlength="255" required>
            </div>
            <div class="form-group">
                <label for="note_body"><h3>Tekst:</h3></label>
                <textarea name="note_body" id="note_body" rows="4" maxlength="255" required></textarea>
            </div>
            <br>
            <div class="button_create_note">
                <button  type="submit" name="create" >Legg til notat</button>
            </div>
        </form>
    </main>
</body>
</html>

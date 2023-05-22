<?php
    require_once("../assets/include/header.inc.php");
    require_once("../assets/include/db.inc.php");
    require_once("../assets/include/util.inc.php");

    session_start();
    $user_id = $_SESSION["user"]["user_id"];
    $note_id = $_REQUEST["note_id"];

    if($_SESSION["user"]["logged_in"]) {
        $_SESSION["site"]["last_visited"] = $_SERVER["REQUEST_URI"];
    } else {
        header("Location: utility/error.php?error=401");
        exit();
    }

    // Update note:
    if(isset($_REQUEST["update"])) {
        $note_subject = clean($_REQUEST["note_subject"]);
        $note_body = clean($_REQUEST["note_body"]);
        $encrypted_subject = digicrypt($note_subject, true);
        $encrypted_body = digicrypt($note_body, true);

        if(update_note($note_id, $encrypted_subject, $encrypted_body)) {
            show_alert("Notat ble oppdatert");
        } else {
            show_alert("Noe gikk galt, notat ble ikke oppdatert");
        }
    }

    // Delete note:
    if(isset($_REQUEST["delete"])) {
        if(delete_note($note_id, $user_id)) {
            header("Location: notes.php?user_id=$user_id");
            exit();
        } else {
            show_alert("Noe gikk galt, notat ble ikke slettet");
        }
    }

    // Recieve note from database:
    if($note = get_note($user_id, $note_id)) {
        $encrypted_subject = $note->note_subject;
        $encrypted_body = $note->note_body;
        $note_subject = digicrypt($encrypted_subject, false);
        $note_body = digicrypt($encrypted_body, false);
        $note_date = date("H:i d-m-Y", strtotime($note->note_date));
    } else {
        show_alert("Fant ingen notat");
    }
?>
<!DOCTYPE html>
<html lang="no">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/styles/styles.css">
    <script src="../assets/include/javascript/prompt.js" type="text/javascript"></script>
    <title>Note</title>
</head>
<body>
    <?php banner(); ?>
    <?php if($note): ?>
        <form class="form_create_note" action="" method="post">
            <div class="form-group">
                <label for="note_subject"><h3>Tittel:</h3>
                    <input type="text" name="note_subject" value="<?= $note_subject ?>" maxlength="64" accept-charset="UTF-8" required>
                </label>
                <label for="note_body"><h3>Notat:</h3>
                    <textarea type="text" name="note_body" maxlength="255" accept-charset="UTF-8" required><?= $note_body ?></textarea>
                </label>
                <div class="note_date">
                    <h3>Sist oppdatert:</h3>
                    <p><?= $note_date ?></p>
                </div>
                <br>
                <div class="button_create_note">
                    <button type="submit" name="update">Oppdater notat</button> 
                </div>
            </div>
        </form>
        <form class="form_create_note" action="" method="post">
            <br>
            <div class="button_delete_note">
                <button type="submit" name="delete">Slett notat</button>
            </div>
        </form>
    <?php endif; ?>
</body>
</html>
<?php
    require_once("../assets/include/header.inc.php");
    require_once("../assets/include/db.inc.php");
    require_once("../assets/include/util.inc.php");

    session_start();
    $user_id = $_SESSION["user"]["user_id"];
    $note_id = $_REQUEST["note_id"];

    // Update note:
    if(isset($_REQUEST["update"])) {
        $note_subject = clean($_REQUEST["note_subject"]);
        $note_body = clean($_REQUEST["note_body"]);
        $encrypted_subject = digicrypt($note_subject, true);
        $encrypted_body = digicrypt($note_body, true);

        if(update_note($note_id, $encrypted_subject, $encrypted_body)) {
            $status = "<h4><span style='color:green'>
                    Notat ble oppdatert.
                    </span></h4>";
        } else {
            $status = "<h4><span style='color:red'>
                    Noe gikk galt, notat ble ikke oppdatert.
                    </span></h4>";
        }
    }

    // Delete note:
    if(isset($_REQUEST["delete"])) {
        if(delete_note($note_id, $user_id)) {
            header("Location: my_notes.php?user_id=$user_id");
        } else {
            $status = "<h4><span style='color:red'>
                    Noe gikk galt, notat ble ikke slettet.
                    </span></h4>";
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
        $status = "<h4><span style='color:red'>
            Fant ingen notat.
            </span></h4>";
    }
?>
<!DOCTYPE html>
<html lang="no">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/styles/styles.css">
    <title>Note</title>
</head>
<body>
    <?php banner() ?>
    <?php if($note): ?>
        <form action="" method="post">
            <div class="form-group">
                <label for="note_subject"><h3>Tittel:</h3>
                    <input type="text" name="note_subject" value="<?= $note_subject ?>" maxlength="64" accept-charset="UTF-8" required>
                </label>
                <label for="note_body"><h3>Notat:</h3>
                    <textarea type="text" name="note_body" maxlength="255" accept-charset="UTF-8" required><?= $note_body ?></textarea>
                </label>
                <h3>Siste oppdatert:</h3>
                <p><?= $note_date ?></p>
                <br><button type="submit" name="update" style="color:black">Oppdater notat</button> 
            </div>
        </form>
        <form action="" method="post">
            <br><button type="submit" name="delete" style="color:black">Slett notat</button>
        </form>
    <?php endif; ?>
    <?php if(isset($status)) echo $status; ?>
</body>
</html>
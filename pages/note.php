<?php
    require_once("../assets/include/header.inc.php");
    require_once("../assets/include/db.inc.php");

    session_start();

    $note_id = $_REQUEST["note_id"];
    $user_id = $_SESSION["user"]["user_id"];

    if($note = get_note($user_id, $note_id)) {
        $note_subject = $note->note_subject;
        $note_body = $note->note_body;
        $note_date = $note->note_date;
    } else {
        $status = "<h4><span style='color:red'>
                Fant ingen notat.
                </span></h4>";
    }

    if(isset($_REQUEST["update"])) {
        $new_note_subject = $_REQUEST["note_subject"];
        $new_note_body = $_REQUEST["note_body"];
        if(update_note($note_id, $new_note_subject, $new_note_body)) {
            $status = "<h4><span style='color:green'>
                    Notat ble oppdatert.
                    </span></h4>";
        } else {
            $status = "<h4><span style='color:red'>
                    Noe gikk galt, notat ble ikke oppdatert.
                    </span></h4>";
        }
    } else {
        echo "wtf";
    }

    
?>
<!DOCTYPE html>
<html lang="en">
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
                <label for="note_subject"><h3>Tittel</h3>
                    <input type="text" name="note_subject" value="<?= $note_subject ?>" required>
                </label>
                <label for="note_body"><h3>Notat</h3>
                    <textarea type="text" name="note_body" required><?= $note_body ?></textarea>
                </label>
                <button type="submit" name="update" style="color:black">Oppdater notat</button>
            </div>
        </form>
        <form action="" method="get">
            <button type="submit" name="delete" style="color:black">Slett notat</button>
        </form>
    <?php endif; ?>
    <?php if(isset($status)) echo $status; ?>
</body>
</html>
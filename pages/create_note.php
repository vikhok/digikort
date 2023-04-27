<?php
    require_once("../assets/include/header.inc.php");
    require_once("../assets/include/db.inc.php");
    require_once("../assets/include/util.inc.php");

    session_start();
    $user_id = $_SESSION["user"]["user_id"];

    // Create note and push it to the database:
    if(isset($_REQUEST["create"])) {
        $note_subject = clean($_REQUEST["note_subject"]);
        $note_body = clean($_REQUEST["note_body"]);
        $encrypted_subject = digicrypt($note_subject, true);
        $encrypted_body = digicrypt($note_body, true);

        if($note_id = create_note($user_id, $encrypted_subject, $encrypted_body)) {
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
        <h1>Nytt notat:</h1>
        <form action="" method="POST">
            <div class="form-group">
                <label for="note_subject"><h3>Tittel:</h3></label>
                <input type="text" name="note_subject" id="note_subject" maxlength="64" accept-charset="UTF-8" required>
            </div>
            <div class="form-group">
                <label for="note_body"><h3>Tekst:</h3></label>
                <textarea type="text" name="note_body" id="note_body" rows="4" maxlength="255" accept-charset="UTF-8" required></textarea>
            </div>
            <br><button type="submit" name="create" style="color:black">Legg til notat</button>
        </form>
    </main>
</body>
</html>

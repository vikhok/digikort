<?php
    require_once("../assets/include/header.inc.php");
    require_once("../assets/include/db.inc.php");
    require_once("../assets/include/util.inc.php");

    session_start();
    $user_id = $_SESSION["user"]["user_id"];

    $notes = get_all_notes($user_id);

    // Oppdater notatet hvis skjemaet er sendt inn
    if(isset($_POST["submit"]) && isset($_SESSION["user_id"])) {
        $note_id = $_POST["note_id"];
        $note_title = $_POST["note_title"];
        $note_body = $_POST["note_body"];

        // Sjekk om notatet eksisterer før oppdatering
        if($note && $note["user_id"] === $_SESSION["user_id"]) {
            if(update_note($user_id, $note_subject, $note_body)) {
                header("Location: mine-notater.php");
                exit();
            } else {
                $error = "Kunne ikke oppdatere notatet";
            }
        } else {
            $error = "Notatet eksisterer ikke eller tilhører ikke den gjeldende brukeren.";
        }
    }
?>
<!DOCTYPE html>
<html lang="no">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/styles/styles.css">
    <title>Notater</title>
</head>
<body>
    <?php banner() ?>
    <main>
        <br>
        <br>
        <h1 class="h1_my_notes">Mine notater</h1>
        <?php if($notes):?>
            <section>
                <?php foreach($notes as $note): ?>
                    <div class="notat-boks-wrapper">
                        <div class="notat-boks">
                            <a href="note.php?note_id=<?=$note["note_id"]?>" style="color:black">
                                <h3><?=$note["note_subject"]?></h3>
                                <p><?=$note["note_body"]?></p>
                                <p><?=date("H:i d-m-Y", strtotime($note["note_date"]))?></p>
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </section>
        <?php else: ?>
            <p>Du har ingen notater lagret.</p>
        <?php endif; ?>
        <div class="button-mine-notater">
            <form action="create_note.php" method="post">
                <button type="submit" name="create_note" >Nytt notat</button>
            </form>
        </div>
    </main>
</body>
</html>

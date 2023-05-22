<?php
    require_once("../assets/include/header.inc.php");
    require_once("../assets/include/db.inc.php");
    require_once("../assets/include/util.inc.php");

    session_start();
    $user_id = $_SESSION["user"]["user_id"];

    if($_SESSION["user"]["logged_in"]) {
        $_SESSION["site"]["last_visited"] = $_SERVER["REQUEST_URI"];
    } else {
        header("Location: utility/error.php?error=401");
        exit();
    }

    $notes = get_all_notes($user_id);
    if($notes === false) {
        header("Loaction: utility/error.php?error=500");
        exit();
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
    <?php banner(); ?>
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
                                <h3><?=digicrypt($note["note_subject"], false)?></h3>
                                <p><?=digicrypt($note["note_body"], false)?></p>
                                <p><?=date("H:i d-m-Y", strtotime($note["note_date"]))?></p>
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </section>
        <?php else: ?>
            <p class="no_notes">Du har ingen notater lagret.</p>
        <?php endif; ?>
        <div class="button-mine-notater">
            <form action="note_create.php" method="post">
                <button type="submit" name="create_note" >Nytt notat</button>
            </form>
        </div>
    </main>
</body>
</html>

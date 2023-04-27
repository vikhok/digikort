<?php
    require_once("../assets/include/header.inc.php");
    require_once("../assets/include/db.inc.php");
    require_once("../assets/include/util.inc.php");

    session_start();
    $user_id = $_SESSION["user"]["user_id"];

    $notes = get_all_notes($user_id);
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
        <h1>Mine notater</h1>
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
            <p>Du har ingen notater lagret.</p>
        <?php endif; ?>
        <div class="button-mine-notater">
            <form action="create_note.php" method="post">
                <button type="submit" name="create_note" style="color:black">Nytt notat</button>
            </form>
        </div>
    </main>
</body>
</html>

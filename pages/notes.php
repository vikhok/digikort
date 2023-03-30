<?php
require_once("../assets/include/header.inc.php");
require_once("../assets/include/footer.inc.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nytt notat</title>
    <link rel="stylesheet" href="../assets/styles/styles.css">
</head>
<body>
    <?php banner(1, false) ?>
    <div class="container-notat">
        <div class="content-notat">
              <div class="button-notat">
               <div class="textarea-notat">
                       <div class="label-notat">
        </div>
        <br>
            <br>
            <h1>Nytt notat</h1>
            
            <form action="">    

                <input type="text" placeholder="Tittel:" id="title" name="title" required>
                <textarea id="text" placeholder="Notat:" name="title" rows="13" required></textarea>
                <button type="submit">Lagre</button>
            </form>
        </div>
    </div>
    <?php footer() ?>
</body>
</html>


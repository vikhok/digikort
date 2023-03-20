<?php
    require_once("../assets/include/header.inc.php");
    require_once("../assets/include/footer.inc.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/styles/styles.css">
    <title>Digikort</title>
</head>
<body>
    <?php banner(true) ?>

    <div class="business-card-container">
        <div class="personal-information">
            <h2>Ola Nordmann</h2>
            <h2>Senior systemutvikler</h2>
            <h2>Egde Consulting AS</h2>
            <h2>ola@egde.no</h2>
            <h2>+47 123 45 678</h2>
        </div>
        <div class="qr-code">
            <?php if($_SESSION["email"] == "EMAIL VARIABEL HER") { ?>
                <img src="../profiles/profile1/qr.png" alt="QR-kode">
            <?php } else { ?>
                <li class="menu-options"><a href=#>CV</a></li>
                <li class="menu-options"><a href=#>Kontakt</a></li>
                <li class="menu-options"><a href=#>Lagre kontakt</a></li>
                <li class="menu-options"><a href=#>Del</a></li>
            <?php } ?>
        </div>
    </div>

    <?php footer("profile") ?>
</body>
</html>
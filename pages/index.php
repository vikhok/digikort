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
    <link rel="stylesheet" href="../assets/fonts/fontawesome-free-6.3.0-web/css/fontawesome.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.14.0/css/all.css" integrity="sha384-HzLeBuhoNPvSl5KYnjx0BT+WB0QEEqLprO+NBkkk5gbc67FTaL7XIGa2w1L0Xbgc" crossorigin="anonymous">
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
            <h2>+47 123 45 6788</h2>
        </div>
    <div class="menu">
        <ul>
            <li><a href="#" class="menu-options"><i class="fa fa-file-text"></i> CV</a></li>
            <li><a href="#" class="menu-options"><i class="fa fa-envelope"></i> Kontakt</a></li>
            <li><a href="#" class="menu-options"><i class="fa fa-save"></i> Lagre kontakt</a></li>
            <li><a href="#" class="menu-options"><i class="fa fa-share-alt"></i> Del</a></li>
        </ul>
    </div>
</div>
    <?php footer("profile") ?>
</body>
</html>
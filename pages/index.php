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
        <div class="menu">
            <ul>
                <li><a href=# class="menu-options">CV</a></li>
                <li><a href=# class="menu-options">Kontakt</a></li>
                <li><a href=# class="menu-options">Lagre kontakt</a></li>
                <li><a href=# class="menu-options">Del</a></li>
            </ul> 
        </div>

        <div class="menu-icons">
            <ul>
                <li class="menu-item"><a href="#" class="menu-link"><img src="../assets/include/icons/envelope-solid.svg"></li>
                <li class="menu-item"><a href="#" class="menu-link"><img src="../assets/include/icons/share-from-square-solid.svg"></a></li>
                <li class="menu-item"><a href="#" class="menu-link"><img src="../assets/include/icons/user-plus-solid.svg"></a></li>
            </ul>
        </div>
    </div>

    <?php footer("profile") ?>
</body>
</html>
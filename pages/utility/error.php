<?php
    require_once("../../assets/include/header.inc.php");

    session_start();
    $error = $_REQUEST["error"];
?>
<!DOCTYPE html>
<html lang="no">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../assets/styles/styles.css">
    <link rel="stylesheet" href="../../assets/fonts/fontawesome-free-6.3.0-web/css/fontawesome.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.14.0/css/all.css" integrity="sha384-HzLeBuhoNPvSl5KYnjx0BT+WB0QEEqLprO+NBkkk5gbc67FTaL7XIGa2w1L0Xbgc" crossorigin="anonymous">
    <title>Error</title>
</head>
<body>
    <?php banner() ?>
    <div class="error_page_wrapper">
        <div class="error_message">
            <?php if($error == "404"): ?>
                <h1>ERROR 404</h1>
                <h4>Siden ble ikke funnet</h4>
            <?php elseif($error == "401"): ?>
                <h1>ERROR 401</h1>
                <h4>Du er ikke autorisert</h4>
            <?php elseif($error == "403"): ?>
                <h1>ERROR 403</h1>
                <h4>Tilgang forbudt</h4>
            <?php elseif($error == "500"): ?>
                <h1>ERROR 500</h1>
                <h4>Intern server feil</h4>
            <?php elseif($error == "503"): ?>
                <h1>ERROR 503</h1>
                <h4>Tjeneste utilgjengelig</h4>
            <?php endif; ?>
        </div>
        <div class="return_from_error">
            <form action="index.php" method="post">
                <button type="submit" name="submit" class="return_from_error_button">Take me back</button>
            </form>
        </div>
    </div>
</body>
</html>
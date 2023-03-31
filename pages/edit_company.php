<?php
    require_once("../assets/include/header.inc.php");
    require_once("../assets/include/db.inc.php");

    session_start();
    $_SESSION["site"]["last_visited"] = $_SERVER["REQUEST_URI"];

    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/styles/styles.css">
    <link rel="stylesheet" href="fonts/fontawesome-free-6.3.0-web/fontawesome.min.css">
    <title>Rediger bedrift</title>
</head>
<body>
    <?php banner(false) ?>
        <div class="edit_company">
            <form class ="edcom_form" action="edit_company.php" method="POST">
                <input type="text" name="Bedriftslogan" class="company_slogan">
                <input type="text" name="Bedriftbeskrivelse" class="company_description">
                <input type="text" name="web URL" class="web_url_link">
            </form>
        </div>
        <div class="edit_company_button">
            <button type="submit">Oppdater bedriften</button>
        </div>
</body>
<?php
    require_once("../assets/include/header.inc.php");
    require_once("../assets/include/db.inc.php");

    session_start();
    $user_id = $_REQUEST["user_id"];
    $_SESSION["user"]["last_visited"] = $user_id;

    
?>
<!DOCTYPE html>
<html lang="no">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/styles/styles.css">
    <title>Administrer medlemmer</title>
</head>
<body>
    <?php banner($user_id) ?>
    <div class="administrering_medlemmer">
        
    </div>
</body>
</html>
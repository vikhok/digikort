<?php
    require_once("../assets/include/header.inc.php");
    require_once("../assets/include/footer.inc.php");
    require_once("../assets/include/db.inc.php");

    session_start();
    $_SESSION["site"]["last_visited"] = $_SERVER["REQUEST_URI"];

    $user_id = $_GET["user_id"];
    if($user = get_user($user_id)) {
        $name = $user->first_name . " " . $user->last_name;
        $job_title = $user->job_title;
        $company = $user->company_name;
        $email = $user->email;
        $phone = $user->phone;
    } else {
        $failed = "<h4><span style='color:red'>
        Noe gikk galt, fant ikke bruker i systemet.
        </span></h4>";
    }
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
        <?php if(!isset($failed)) { ?>
            <div class="personal-information">
                <?php
                    if(!isset($failed)) {
                    echo "<h2>$name</h2>
                        <h2>$job_title</h2>
                        <h2>$company</h2>
                        <h2>$email</h2>
                        <h2>$phone</h2>";
                    }
                ?>
            </div>
                <?php if($_GET["user_id"] == $_SESSION["user"]["user_id"]) { ?>
                    <div class="qr-code">
                    <img src="../profiles/profile1/qr.png" alt="QR-kode">
                <?php } else { ?>
                    <div class="menu">
                        <ul>
                            <li class="menu-options"><a href="#"><i class="fa fa-file-text"></i> CV</a></li>
                            <li class="menu-options"><a href="#"><i class="fa fa-envelope"></i> Kontakt</a></li>
                            <li class="menu-options"><a href="#"><i class="fa fa-save"></i> Lagre kontakt</a></li>
                            <li class="menu-options"><a href="#"><i class="fa fa-share-alt"></i> Del</a></li>
                        </ul>
                <?php } ?>
             </div>
        <?php } else { echo $failed; }?>
    </div>
    <?php footer("profile") ?>
</body>
</html>
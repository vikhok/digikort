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
            <div class="qr-code">
                <?php if($email == "EMAIL VARIABEL HER") { ?>
                    <img src="../profiles/profile1/qr.png" alt="QR-kode">
                <?php } else { ?>
                    <li class="menu-options"><a href=#>CV</a></li>
                    <li class="menu-options"><a href=#>Kontakt</a></li>
                    <li class="menu-options"><a href=#>Lagre kontakt</a></li>
                    <li class="menu-options"><a href=#>Del</a></li>
                <?php } ?>
            </div>
        <?php } else { echo $failed; }?>
    </div>
    <?php footer("profile") ?>
</body>
</html>
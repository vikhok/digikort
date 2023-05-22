<?php
    require_once("../assets/include/header.inc.php");
    require_once("../assets/include/footer.inc.php");
    require_once("../assets/include/db.inc.php");
    require_once("../assets/include/qr.inc.php");
    require_once("../assets/include/vcard-inc.php");
    require_once("../assets/include/util.inc.php");

    session_start();
    $user_id = $_REQUEST["user_id"];
    $_SESSION["user"]["last_visited"] = $user_id;

    if($user = get_user($user_id)) {
        $_SESSION["site"]["last_visited"] = $_SERVER["REQUEST_URI"];
        
        $name = $user->first_name . " " . $user->last_name;
        $job_title = $user->job_title;
        $email = $user->email;
        $phone = $user->phone;
        if($user_company = get_user_company($user_id)) {
            $company = $user_company->company_name;
            $company_id = $user_company->company_id;
            $_SESSION["business_card"]["company_id"] = $company_id;
        } else {
            $company = null;
            $company_id = null;
            unset($_SESSION["business_card"]["company_id"]);
        }
        
        $url = $_SERVER["REQUEST_URI"];
        generateQR($user_id, $url);
    } else {
        header("Location: utility/error.php?error=404");
        exit();
    }

    if(isset($_REQUEST["save-contact"])) {
        if(generate_vcard($user->last_name, $user->first_name, $name, $phone, $email, $dir)) {
            show_alert("Kontaktopplysninger er blitt lastet ned");
        } else {
            show_alert("Noe gikk galt, finner ikke kontaktopplysninger.");
        }
    }

?>
<!DOCTYPE html>
<html lang="no">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/styles/styles.css">
    <link rel="stylesheet" href="../assets/fonts/fontawesome-free-6.3.0-web/css/fontawesome.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.14.0/css/all.css" integrity="sha384-HzLeBuhoNPvSl5KYnjx0BT+WB0QEEqLprO+NBkkk5gbc67FTaL7XIGa2w1L0Xbgc" crossorigin="anonymous">
    <script src="../assets/include/javascript/prompt.js" type="text/javascript"></script>
    <title>Digikort</title>
</head>
<body>
    <?php banner($user_id); ?>
    <div class="business-card-container">
        <div class="personal-information">
            <h2><?=$name?></h2>
            <h2><?=$company?></h2>
            <h2><?=$job_title?></h2>
            <h2><?=$email?></h2>
            <h2><?=$phone?></h2>
        </div>
        <?php if(isset($_SESSION["user"]["user_id"]) && $_GET["user_id"] == $_SESSION["user"]["user_id"]):
            $folder = md5("user." . $user_id);
            $dir = "../profiles/" . $folder . "/qr.png";
            echo "<img class='qr-code' src='$dir' alt='QR-kode'>";
        ?>
        <?php else: ?>
            <div class="menu">
                <form action="" method="post">
                    <ul>
                        <li><a href="contact_form.php?user_id=<?=$user_id?>" class="menu-options"><i class="fa fa-envelope"></i> Kontakt</a></li>
                        <li><button type="submit" class="menu-options" name="save-contact"><i class="fa fa-save"></i> Lagre kontakt</a></li>
                        <li><a href="#" class="menu-options" id="share-link"><i class="fa fa-share-alt"></i> Del</a></li>
                    </ul>
                </form>
            </div>
            <script src="../assets/include/javascript/webshare-api.js"></script>
        <?php endif; ?>
    </div>
    <?php footer($user_id, "user"); ?>
</body>
</html>
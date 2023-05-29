<?php
    require_once("../../assets/include/db.inc.php");
    require_once("../../assets/include/util.inc.php");

    session_start();
    
    if(isset($_SESSION["user"]["user_id"])) {
        $user_id = $_SESSION["user"]["user_id"];
        $email = $_SESSION["user"]["email"];
        if(isset($_REQUEST["verification"])) {
            $verification = $_REQUEST["verification"];
        } else $verification = null;

        if(validate_password_reset($email, $verification)) {
            if(isset($_REQUEST["verify_password_change"])) {
                $new_password = $_REQUEST["new_password"];
                $confrim_password = $_REQUEST["confirm_password"];
                if($new_password == $confrim_password) {
                    $password_hash = password_hash($new_password, PASSWORD_DEFAULT, ["cost" => 10]);
                    if(update_password($email, $password_hash)) {
                        delete_validation_code($email);
                        show_alert("Passordet ditt har blitt endret, sender deg til din profil");
                        header("Refresh: 3; url=../index.php?user_id=$user_id");
                    } else {
                        show_alert("Noe gikk galt, passrodet ble ikke oppdatert");
                    }
                } else {
                    show_alert("Passordene du fylte inn samsvarer ikke");
                }
            }
        } else {
            show_alert("Du må ha en aktiv verifiserings-kode for å bytte passord.");
        }
    } else {
        show_alert("Du må være logget inn for å bytte passord, vi sender deg til påloggingssiden");
        header("Refresh: 3; url=login.php");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="../../assets/include/javascript/prompt.js" type="text/javascript"></script>
    <link rel="stylesheet" href="../../assets/styles/login.css">
    <link rel="stylesheet" href="fonts/fontawesome-free-6.3.0-web/fontawesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <title>Bytt passord</title>
</head>
<body class="login-page">
    <div class="bytt-passord-form">
        <div class="bytt-passord-container">
            <form name="Bytt Passord" method="POST" action="#">
                <h1 class="digikort-heading">DigiKort</h1>
                <div class="form-control">
                    <input type="password" name="new_password" class="new-password-form" placeholder="Nytt passord" pattern=".{8,64}" required
                            oninvalid="this.setCustomValidity('Obligatorisk felt. Passordet kan kun innholde opptil 64 tegn')"
                            oninput="this.setCustomValidity('')">
                    <input type="password" name="confirm_password" class="confirm-password-form" placeholder="Bekreft passord" pattern=".{8,64}" required
                            oninvalid="this.setCustomValidity('Obligatorisk felt. Passordet kan kun innholde opptil 64 tegn')"
                            oninput="this.setCustomValidity('')">
                </div>
                <button type="submit" name="verify_password_change" class="submit">Lagre passord</button>
            </form>
            <?php if(isset($status)) echo $status; ?>
        </div>
    </div>
</body>

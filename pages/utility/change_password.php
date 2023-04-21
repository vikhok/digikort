<?php
    require_once("../../assets/include/db.inc.php");
    require_once("../../assets/include/util.inc.php");

    session_start();
    if(isset($_SESSION["user"]["user_id"])) {
        $user_id = $_SESSION["user"]["user_id"];
        $email = $_SESSION["user"]["email"];
        $verification = $_REQUEST["verification"];

        if(validate_password_reset($email, $verification)) {
            if(isset($_REQUEST["verify_password_change"])) {
                $new_password = $_REQUEST["new_password"];
                $confrim_password = $_REQUEST["confirm_password"];
                if($new_password == $confrim_password) {
                    $password_hash = password_hash($new_password, PASSWORD_DEFAULT, ["cost" => 10]);
                    if(update_password($user_id, $password_hash)) {
                        delete_validation_code($email);
                        $status = "<h4><span style='color:green'>
                            Passordet ditt har blitt endret, sender deg til din profil.
                            </span></h4>";
                        header("Refresh: 3; url=../index.php?user_id=$user_id");
                    } else {
                        $status = "<h4><span style='color:red'>
                            Noe gikk galt, passordet ble ikke oppdatert.
                            </span></h4>";
                    }
                } else {
                    $status = "<h4><span style='color:red'>
                        Passordene du fylte inn samsvarer ikke.
                        </span></h4>";
                }
            }
        } else {
            $status = "<h4><span style='color:red'>
                Du må ha en aktiv verifiserings-kode for å bytte passord.
                </span></h4>";
        }
    } else {
        $status = "<h4><span style='color:red'>
            Du må bære logget inn for å bytte passord, vi sender deg til loggin siden.
            </span></h4>";
        header("Refresh: 3; url=login.php");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styling/login.css">
    <link rel="stylesheet" href="fonts/fontawesome-free-6.3.0-web/fontawesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <title>Reset passord</title>
</head>
<body class="login-page">
    <div class="bytt-passord-form">
        <div class="bytt-passord-container">
            <form name="Bytt Passord" method="POST" action="#">
                <h1 class="digikort-heading">DigiKort</h1>
                <div class="form-control">
                    <input type="password" name="new_password" class="new-password-form" placeholder="Nytt passord" required>
                    <input type="password" name="confirm_password" class="confirm-password-form" placeholder="Bekreft passord" required>
                </div>
                <button type="submit" name="verify_password_change" class="submit">Lagre passord</button>
            </form>
            <?php if(isset($status)) echo $status; ?>
        </div>
    </div>
</body>

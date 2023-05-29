<?php
    require_once("../../assets/include/db.inc.php");
    require_once("../../assets/include/phpmailer.inc.php");
    require_once("../../assets/include/util.inc.php");

    session_start();
    
    if(isset($_REQUEST["send_verification"])) {
        $email = $_REQUEST["email"];
        $verification = substr(md5(microtime()),rand(0,26),6);

        delete_validation_code($email);
        if(create_validation_code($email, $verification, 30)) {
            $reciever_email = $email;
            $timestamp = strtotime("now") + 30*60;
            $valid_to = date('H:i', $timestamp);
            $subject = "Reset passord";
            $message  = "<h3>Du har nylig bedt om å få tilbakestilt passordet ditt,</h3>";
            $message .= "<p>Verifiseringskode:</p>";
            $message .= "<p>$verification</p>";
            $message .= "<p>Koden er gyldig til klokken $valid_to.</p>";
            $message .= "<p>Vennligst ta kontakt med oss på digikortpass@gmail.com om dette ikke var deg.</p>";
            
            if(sendMail($reciever_email, $subject, $message)) {
                show_alert("En verifiseringskode for tilbakestilling av passordet har blitt sendt til $reciever_email");
            } else {
                show_alert("Noe gikk galt, klarte ikke sende e-post for tilbakestilling av passord til $reciever_email.");
            }
        } else {
            show_alert("Noe gikk galt, vennligst prøv igjen");
        }
    }

    if(isset($_REQUEST["verify_password_reset"])) {
        $email = strtolower(validateEmail(cleanEmail($_REQUEST["email"])));
        $verification = clean($_REQUEST["verification_code"]);
        if(validate_password_reset($email, $verification)) {
            $new_password = clean($_REQUEST["new_password"]);
            $password_hash = password_hash($new_password, PASSWORD_DEFAULT, ["cost" => 10]);

            if(update_password($email, $password_hash)) {
                delete_validation_code($email);
                header("Location: login.php");
                exit();
            } else {
                show_alert("Noe gikk galt, passordet ble ikke oppdatert");
            }
        } else {
            show_alert("Ugyldig verifiseringskode, vennligst prøv igjen");
        }
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
    <title>Reset passord</title>
</head>
<body class="login-page">
    <div class="bytt-passord-form">
        <div class="bytt-passord-container">
            <form name="Bytt Passord" method="POST" action="#">
                <h1 class="digikort-heading">DigiKort</h1>
                <?php if(isset($_REQUEST["send_verification"])): ?>
                    <div class="form-control">
                        <input type="hidden" name="email" value="<?=$_REQUEST['email']?>">
                        <input type="password" name="new_password" class="new-password-form" placeholder="Nytt passord" pattern=".{8,64}" required
                            oninvalid="this.setCustomValidity('Obligatorisk felt. Passordet kan kun innhold opptil 64 tegn')"
                            oninput="this.setCustomValidity('')">
                        <input type="text" name="verification_code" class="confirm-password-form" placeholder="Verifiseringskode" pattern=".{6}" required 
                            oninvalid="this.setCustomValidity('Obligatorisk felt. Verifiseringskoden kan kun være 6 tegn')"
                            oninput="this.setCustomValidity('')">
                    </div>
                    <button type="submit" name="verify_password_reset" class="submit">Lagre passord</button>
                <?php else: ?>
                    <div class="form-control">
                        <input type="email" name="email" class="email-form" placeholder="E-post" required>
                    </div>
                    <button type="submit" name="send_verification" class="submit">Send verifiseringskode</button>
                <?php endif; ?>
            </form>
            <?php if(isset($status)) echo $status; ?>
        </div>
    </div>
</body>

<?php
    require_once("../assets/include/db.inc.php");

    session_start();

    if(isset($_REQUEST["register"])) {
        $first_name = $_REQUEST["first_name"];
        $last_name = $_REQUEST["last_name"];
        $email = $_REQUEST["email"];
        $phone = $_REQUEST["phone"];
        $password = $_REQUEST["password"];
        $confirm_password = $_REQUEST["confirm_password"];

        if(create_account($first_name, $last_name, $email, $phone, $password)) {
            $status = "<h4><span style='color:green'>
            Konto ble registrert i systemet.
            </span></h4>";
            header("Refresh: 5; url=login.php");
        } else {
            $status = "<h4><span style='color:red'>
            Noe gikk glat, konto ble ikke lagret i systemet.
            </span></h4>";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styling/Styling.css">
    <link rel="stylesheet" href="fonts/fontawesome-free-6.3.0-web/fontawesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <title>Registrer</title>
</head>
<body>
    <div class="register-form">
        <div class="register-container">
            <form name="register" class="login" method="POST">
                <h1 class="digikort-heading">DigiKort</h1>
                <div class="form-control">
                    <input type="text" name="first_name" class="firstname-form" placeholder="Fornavn" required>
                    <input type="text" name="last_name" class="surname-form" placeholder="Etternavn" required>
                    <input type="email" name="email" class="email-register-form" placeholder="Email" required>
                    <input type="tel" name="phone" class="phonenumber-form" placeholder="Mobilnummer" required>
                    <input type="text" name="password" class="register-password-form" placeholder="Passord" required>
                    <input type="text" name="confirm_password" class="confirm-password-form" placeholder="Gjenta Passord" required>
                </div>
                <button type="submit" name="register">Registrer</button>
                <p><a class="already-has-user-clicker" href="login.php">Jeg har allerede brukerkonto</a></p>
                <?php if(isset($status)) { echo $status; } ?>
            </form>
        </div>
    </div>
</body>
</html>
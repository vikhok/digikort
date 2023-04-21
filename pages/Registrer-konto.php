<?php
    require_once("../assets/include/db.inc.php");
    require_once("../assets/include/qr.inc.php");
    require_once("../assets/include/util.inc.php");

    session_start();

    if(isset($_REQUEST["register"])) {
        $first_name = ucfirst(clean($_REQUEST["first_name"]));
        $last_name = ucfirst(clean($_REQUEST["last_name"]));
        $email = clean($_REQUEST["email"]);
        $phone = clean($_REQUEST["phone"]);
        $password = clean($_REQUEST["password"]);
        $confirm_password = clean($_REQUEST["confirm_password"]);

        if($password == $confirm_password) {
            $password_hash = password_hash($password, PASSWORD_DEFAULT, ["cost" => 10]);
            if($user_id = create_account($first_name, $last_name, $email, $phone, $password_hash)) {
                $dir = "../profiles/" . md5("user." . $user_id);
                if(!file_exists($dir)) {
                    mkdir($dir, 0777, true);
                }
                $status = "<h4><span style='color:green'>
                        Konto ble registrert i systemet.
                        </span></h4>";
                header("Refresh: 5; url=login.php");
            } else {
                $status = "<h4><span style='color:red'>
                        Noe gikk galt, konto ble ikke lagret i systemet.
                        </span></h4>";
            }
        } else {
            $status = "<h4><span style='color:red'>
                    Passordene du skrev stemte ikke overrens.
                    </span></h4>";
        }
    }
?>
<!DOCTYPE html>
<html lang="no">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styling/login.css">
    <link rel="stylesheet" href="fonts/fontawesome-free-6.3.0-web/fontawesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <title>Registrer</title>
</head>
<body>
    <div class="register-user">
        <div class="register-container">
            <form name="register-form" class="login" method="POST">
                <h1 class="digikort-heading">DigiKort</h1>
                <div class="form-control">
                    <input type="text" name="first_name" class="firstname-form" placeholder="Fornavn" required size="50">
                    <input type="text" name="last_name" class="surname-form" placeholder="Etternavn" required>
                    <input type="email" name="email" class="email-register-form" placeholder="Email" required>
                    <input type="tel" name="phone" class="phonenumber-form" placeholder="Mobilnummer" required>
                    <input type="password" name="password" class="register-password-form" placeholder="Passord" required>
                    <input type="password" name="confirm_password" class="confirm-password-form" placeholder="Gjenta Passord" required>
                </div>
                <section class="form-submit">
                    <button type="submit" name="register">Registrer konto</button>
                </section>
                <p><a class="already-has-user-clicker" href="login.php">Jeg har allerede brukerkonto</a></p>
                <?php if(isset($status)) 
                { 
                    echo $status; 
                } ?>
            </form>
        </div>
    </div>
</body>
</html>
<?php
    require_once("../../assets/include/db.inc.php");
    require_once("../../assets/include/util.inc.php");

    session_start();

    if(isset($_REQUEST["register"])) {
        $first_name = ucfirst(strtolower(clean($_REQUEST["first_name"])));
        $last_name = ucfirst(strtolower(clean($_REQUEST["last_name"])));
        $email = strtolower(validateEmail(cleanEmail($_REQUEST["email"])));
        $phone = clean($_REQUEST["phone"]);
        $password = clean($_REQUEST["password"]);
        $confirm_password = clean($_REQUEST["confirm_password"]);

        if(strlen($password) >= 8 && $password == $confirm_password) {
            $password_hash = password_hash($password, PASSWORD_DEFAULT, ["cost" => 10]);
            if($user_id = create_account($first_name, $last_name, $email, $phone, $password_hash)) {
                $folder = "../profiles/" . md5("user." . $user_id);
                if(!file_exists($folder)) {
                    mkdir($folder, 0777, true);
                }
                $_SESSION["user"]["user_id"] = $user_id;
                $_SESSION["user"]["email"] = $email;
                $_SESSION["user"]["logged_in"] = true;
                header("Location: ../index.php?user_id=$user_id");
                exit();
            } else {
                show_alert("Noe gikk galt, konto ble ikke lagret i systemet");
            }
        } else {
            show_alert("Noe gikk galt, passordet må innhold minst 8 tegn eller samsvarer ikke");
        }
    }
?>
<!DOCTYPE html>
<html lang="no">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../assets/styles/login.css">
    <link rel="stylesheet" href="fonts/fontawesome-free-6.3.0-web/fontawesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <script src="../../assets/include/javascript/prompt.js" type="text/javascript"></script>
    <title>Registrer</title>
</head>
<body class="register-page">
    <div class="register-form">
        <div class="register-container">
            <form name="register" class="login" method="POST">
                <h1 class="digikort-heading">DigiKort</h1>
                <div class="form-control">
                    <input type="text" name="first_name" class="firstname-form" placeholder="Fornavn" pattern="[A-Za-zÆæØøÅå'-.]{1,64}" required
                        oninvalid="this.setCustomValidity('Obligatorisk felt. Fornavnet kan kun innhold bokstaver og 64 tegn')" 
                        oninput="this.setCustomValidity('')">
                    <input type="text" name="last_name" class="surname-form" placeholder="Etternavn" pattern="[A-Za-zÆæØøÅå'-.]{1,64}" required
                        oninvalid="this.setCustomValidity('Obligatorisk felt. Etternavnet kan kun innhold bokstaver og 64 tegn')" 
                        oninput="this.setCustomValidity('')">
                    <input type="email" name="email" class="email-register-form" placeholder="Email" pattern=".{1,128}" required
                        oninvalid="this.setCustomValidity('Obligatorisk felt. E-postadressen kan kun innhold 128 tegn')" 
                        oninput="this.setCustomValidity('')">
                    <input type="tel" name="phone" class="phonenumber-form" placeholder="Mobilnummer" pattern="[0-9+]{1,15}" required
                        oninvalid="this.setCustomValidity('Obligatorisk felt. Telefonnummer kan kun innhold nummer og 15 tegn')" 
                        oninput="this.setCustomValidity('')">
                    <input type="password" name="password" class="register-password-form" placeholder="Passord" pattern="[0-9A-Za-zÆæØøÅå'-.]{1,255}" required
                        oninvalid="this.setCustomValidity('Obligatorisk felt. Passordet kan kun innhold 255 tegn')" 
                        oninput="this.setCustomValidity('')">
                    <input type="password" name="confirm_password" class="confirm-password-form" placeholder="Gjenta passord" pattern="[0-9A-Za-zÆæØøÅå'-.]{1,255}" required
                        oninvalid="this.setCustomValidity('Obligatorisk felt. Passordet kan kun innhold 255 tegn')" 
                        oninput="this.setCustomValidity('')">
                    <div class="register-button">
                        <button type="submit" name="register">Registrer</button>
                    </div>
                    <p><a class="already-has-user-clicker" href="login.php">Jeg har allerede en brukerkonto</a></p>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
<?php
    require_once("../../assets/include/db.inc.php");
    require_once("../../assets/include/util.inc.php");

    session_start();

    if(isset($_REQUEST["login"])) {
        $email = $_REQUEST["email"];
        $password = $_REQUEST["password"];
        if($user = login($email, $password)) {
            $user_id = $user->user_id;
            $_SESSION["user"]["user_id"] = $user_id;
            $_SESSION["user"]["email"] = $email;
            $_SESSION["user"]["logged_in"] = true;
            if($user_company = get_user_company($user->user_id)) {
                $company_id = $user_company->company_id;
                $_SESSION["user"]["company_id"] = $company_id;
            }
            header("Location: ../index.php?user_id=" . $_SESSION["user"]["user_id"]);
        } else {
            show_alert("Feil e-post og/eller passord");
        }
    }
?>
<!DOCTYPE html>
<html lang="no">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="../../assets/include/javascript/prompt.js" type="text/javascript"></script>
    <link rel="stylesheet" href="../../assets/styles/login.css">
    <link rel="stylesheet" href="fonts/fontawesome-free-6.3.0-web/fontawesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <title>Digikort Login</title>
</head>
<body class="login-page">
    <div class="login-form">
        <div class="login-container">    
            <form name="login" method="POST" action="#">
                <h1 class="digikort-heading">DigiKort</h1>
                <div class="form-control">
                    <input type="email" name="email" class="email-form" placeholder="E-postadresse" required>
                    <input type="password" name="password" class="password-form" placeholder="Passord" required>
                </div>
                <div class="signup-form">
                    <p><a href="register.php">Mangler du brukerkonto?</a></p>
                </div>
                <div class="forgot-password-form">
                    <p><a href="password_reset.php">Glemt Passord?</a></p>
                </div>
                <button type="submit" name="login" class="submit">Login</button>
            </form>
            <?php if(isset($status)) { echo $status; } ?>
        </div>
    </div>
</body>
</html>
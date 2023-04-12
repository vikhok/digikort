<?php
    require_once("../assets/include/header.inc.php");
    require_once("../assets/include/footer.inc.php");
    require_once("../assets/include/db.inc.php");

    session_start();

    if(isset($_POST["login"])) {
        $email = $_POST["email"];
        $password = $_POST["password"];
        if($user = login($email, $password)) {
            $_SESSION["user"]["user_id"] = $user->user_id;
            $_SESSION["user"]["logged_in"] = true;
            header("Location: index.php?user_id=" . $_SESSION["user"]["user_id"]);
        } else {
            $status = "<h4><span style='color:red'>
                    Feil epost og/eller passord.
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
    <link rel="stylesheet" href="styling/login.css">
    <link rel="stylesheet" href="fonts/fontawesome-free-6.3.0-web/fontawesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <title>Digikort Log-in</title>
</head>
<body>
    <div class="login-form">
        <div class="login-container">    
            <form name="login" method="POST" action="#">
                
                <h1 class="digikort-heading">DigiKort</h1>
                
                <div class="form-control">
                    <input type="email" name="email" class="email-form" placeholder="E-postadresse" required>
                    <input type="password" name="password" class="password-form" placeholder="Passord" required>
                </div>

                <div class="remember-password-checkbox">
                    <label for="husk-passord">Husk passord</label>
                    <input type="checkbox" id="remember-password" name="remember-password">
                </div>
            
                <div class="signup-form">
                    <p><a href="Registrer-konto.php">Mangler du brukerkonto?</a></p>
                </div> 

                <div class="forgot-password-form">
                    <p><a href="recover.php">Glemt Passord?</a></p>
                </div>
                <button type="submit" name="login" class="submit">Login</button>
            </form>
            <?php if(isset($status)) { echo $status; } ?>
        </div>
    </div>
</body>
</html>
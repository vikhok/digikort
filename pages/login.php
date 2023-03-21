<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styling/Styling.css">
    <link rel="stylesheet" href="fonts/fontawesome-free-6.3.0-web/fontawesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <title>Login</title>
</head>
<body>
 
<div class="login-form">
    <div class="login-container">    
        <form name="login" class="login" action="POST">

            <div class="digikort-heading">
                <h1>DigiKort</h1>
            </div>
            
            <div class="email-form">
                <input type="text" class="form-control" placeholder="E-postadresse" required>
            </div>

            <div class="password-form">
                <input type="password" class="form-control" placeholder="Passord" required>
            </div>

            <div class="remember-password-checkbox">
                <input type="checkbox" id="remember-password" name="remember-password">
                <label for="husk-passord">Husk passord</label>
            </div>
        
            <div class="signup-form">
                <p><a href="#">Mangler du brukerkonto?</a></p>
            </div> 

            <div class="forgot-password-form">
                <p><a href="#">Glemt Passord?</a></p>
            </div>
            <div>
                <button type="submit"> Login</button>
        </form>
    </div>
</div>
</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styling/styles.css">
    <title>Login-page</title>
</head>
<body>
 
<div class="login-form">
    <div class="login-container">    
        <form name="login" class="login" action="login.php">

            <div class="digikort-heading">
                <h1>DigiKort</h1>
            </div>
            
            <div class="email-form">
                <label>E-postadresse</label>
                <input type="text" class="form-control" required>
            </div>

            <div class="password-form">
                <label>Passord</label>
                <input type="password" class="form-control" required>
            </div>

            <div class="remember-password-checkbox">
                <input type="checkbox" id="remember-password" name="remember-password">
                <label for="husk-passord">Husk passord</label>
            </div>
        
            <div class="signup-form">
                <p>Mangler du brukerkonto? <a href="#">Registerer konto</a></p>
            </div> 

            <div class="forgot-password-form">
                <p>Glemt passord? <a href="#">Trykk her</a></p>
            </div>

            <input type="submit" class="btn" value="Login">
        </form>
        </div>
        </div>
</body>
</html>
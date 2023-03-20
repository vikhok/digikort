<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styling/Styles-registrer-konto.css">
    <link rel="stylesheet" href="fonts/fontawesome-free-6.3.0-web/fontawesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <title>Registrer</title>
</head>
<body>

<div class="register-form">
    <div class="register-container">
        <form name="register" class="login" action="POST">
            
        <div class="digikort-heading">
            <h1>DigiKort</h1>
        </div>

        <div class="firstname-form">
            <input type="text" class="form-control" placeholder="Fornavn" required>
        </div>

        <div class="surname-form">
            <input type="text" class="form-control" placeholder="Etternavn" required>
        </div>

        <div class="email-register-form">
            <input type="text" class="form-control" placeholder="Email" required>
        </div>

        <div class="phonenumber-form">
            <input type="tel" class="form-control" placeholder="Mobilnummer" required>
        </div>

        <div class="register-password-form">
            <input type="password" class="form-control" placeholder="Passord" required>
        </div>
        
        <div class="confirm-password-form">
            <input type="password" class="form-control" placeholder="Gjenta Passord" required>
        </div>

        <div>
            <button type="submit">Registrer</button>
        </div>
        <div class="already-has-user-clicker">
            <p><a href="#">Jeg har allerede brukerkonto</a></p>
        </div>
        </form>
    </div>
</div>
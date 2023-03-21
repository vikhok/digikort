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
        <form name="register" class="login" action="POST">
            
        <div class="digikort-heading">
            <h1>DigiKort</h1>
        </div>
        <div class="form-control">
            <input class="firstname-form" type="text"  placeholder="Fornavn" required>
            <input class="surname-form" type="text"  placeholder="Etternavn" required>
            <input class="email-register-form" type="text"  placeholder="Email" required>
            <input class="phonenumber-form" type="tel"  placeholder="Mobilnummer" required>
            <input class="register-password-form" type="password"  placeholder="Passord" required>
            <input class="confirm-password-form" type="password"  placeholder="Gjenta Passord" required>
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
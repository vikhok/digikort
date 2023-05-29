<?php
    require_once("../assets/include/header.inc.php");
    require_once("../assets/include/footer.inc.php");
    require_once("../assets/include/db.inc.php");
    require_once("../assets/include/phpmailer.inc.php");
    require_once("../assets/include/util.inc.php");

    session_start();
    $user_id = $_REQUEST["user_id"];
    
    if($user = get_user($user_id)) {
        $_SESSION["site"]["last_visited"] = $_SERVER["REQUEST_URI"];
        $email = $user->email;
        $first_name = $user->first_name;
    } else {
        header("Location: utility/error.php?error=404");
        exit();
    }

    if(isset($_REQUEST["send"])) {
        $sender_name = ucfirst(strtolower(clean($_REQUEST["name"])));
        $sender_email = strtolower(validateEmail(cleanEmail($_REQUEST["email"])));
        
        $reciever_name = $first_name; // Test "Reciever"
        $reciever_email = $email; // Test "digikortpass@gmail.com"

        $subject = $_REQUEST["subject"];
        $message = "<h4>Fra: " . $sender_name . "</h4>";
        $message .= "<h4>Email: " . $sender_email . "</h4>";
        $message .= "<h4>Melding: </h4>" . $_REQUEST["message"];

        // Attempting to send email:
        if(sendMail($reciever_email, $subject, $message, $reciever_name, $sender_name)) {
            show_alert("E-post sendt, du vil få svar fortløpende");
        } else {
            show_alert("Noe gikk galt, e-post ble ikke sendt");
        }
    }
?>
<!DOCTYPE html>
<html lang="no">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/styles/styles.css">
    <link rel="stylesheet" href="../assets/fonts/fontawesome-free-6.3.0-web/css/fontawesome.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.14.0/css/all.css" integrity="sha384-HzLeBuhoNPvSl5KYnjx0BT+WB0QEEqLprO+NBkkk5gbc67FTaL7XIGa2w1L0Xbgc" crossorigin="anonymous">
    <script src="../assets/include/javascript/prompt.js" type="text/javascript"></script>
    <title>Kontaktskjema</title>
</head>
<body>
    <?php banner($user_id); ?>
    <section class="contact-form" id="fields">
        <form name="contact" action="" method="POST"> 
            <div class="name-section">
                <label for="name">Ditt navn</label><br>
                <input type="text" id="name" name="name" value="" size="100" required 
                    oninvalid="this.setCustomValidity('Obligatorisk felt, intill 64 tegn.')"
                    oninput="this.setCustomValidity('')">
            </div>
            <div class="email-section">
                <label for="email">Din e-postadresse</label><br>
                <input type="text" id="email" name="email" value="" required 
                    oninvalid="this.setCustomValidity('Obligatorisk felt, eksempelvis epost@epost.no.')"
                    oninput="this.setCustomValidity('')">
            </div>
            <div class="subject-section">
                <label for="subject">Emne</label><br>
                <input type="text" id="subject" name="subject" value="" pattern=".{1,64}" required 
                    oninvalid="this.setCustomValidity('Obligatorisk felt, intill 64 tegn.')"
                    oninput="this.setCustomValidity('')">
            </div>
            <div class="freetext-section" id="freetext">
                <label for="message">Din melding</label><br>
                <textarea cols="25" rows="10" name="message" wrap="physical" required 
                    oninvalid="this.setCustomValidity('Obligatorisk felt.')"
                    oninput="this.setCustomValidity('')"></textarea>
            </div>
            <div class="submit-button">
                <button type="submit" name="send">Send inn</button>
            </div>
        </form>
    </section>
</body>
</html>
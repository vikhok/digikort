<?php
    require_once("../assets/include/header.inc.php");
    require_once("../assets/include/footer.inc.php");
    require_once("../assets/include/db.inc.php");
    require_once("../assets/include/phpmailer.inc.php");

    session_start();
    $_SESSION["site"]["last_visited"] = $_SERVER["REQUEST_URI"];

    $user_id = $_REQUEST["user_id"];
    if($user = get_user($user_id)) {
        $_SESSION["site"]["last_visited"] = $_SERVER["REQUEST_URI"];
        $email = $user->email;
        $name = $user->first_name;

        if(isset($_REQUEST["send"])) {
            $sender_name = $_REQUEST["name"];
            $sender_email = $_REQUEST["email"];
            
            $reciever_name = $name; // "Reciever";
            $reciever_email = $email; // "digikortpass@gmail.com"; // Hvem skal motta epost (denne må endres til company_email fra db)
    
            $subject = $_REQUEST["subject"];
            $message = "<h4>Fra: " . $sender_name . "</h4>";
            $message .= "<h4>Email: " . $sender_email . "</h4>";
            $message .= "<h4>Melding: </h4>" . $_REQUEST["message"];
    
            // Attempting to send email:
            if(sendMail($reciever_email, $subject, $message, $reciever_name, $sender_name)) {
                $status = "<h4><span style='color:green'>
                        Epost sendt, du vil få svar fortløpende.
                        </span></h4>";
            } else {
                $status = "<h4><span style='color:red'>
                        Noe gikk galt, epost ble ikke sendt.
                        </span></h4>";
            }
        }
    } else {
        header("Location: utility/error.php?error=404");
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
    <title>Kontaktskjema</title>
</head>
<body>
    <?php banner($user_id); ?>
    <section class="contact-form" id="fields">
        <form name="contact" action="" method="POST"> 
            <div class="name-section">
                <label for="name">Ditt navn</label><br>
                <input type="text" id="name" name="name" value="" size="100" required>
            </div>
            <div class="email-section">
                <label for="email">Din e-postadresse</label><br>
                <input type="text" id="email" name="email" value="" required>
            </div>
            <div class="subject-section">
                <label for="subject">Subject</label><br>
                <input type="text" id="subject" name="subject" value="" required>
            </div>
            <div class="freetext-section" id="freetext">
                <label for="message">Din melding</label><br>
                <textarea cols="25" rows="10" name="message" wrap="physical"></textarea>
            </div>
            <div class="submit-button">
                <button type="submit" name="send">Send inn</button>
            </div>
        </form>
        <?php if(isset($status)) echo $status; ?>
    </section>
</body>
</html>
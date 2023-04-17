<?php
    require_once("../assets/include/header.inc.php");
    require_once("../assets/include/footer.inc.php");
    require_once("../assets/include/db.inc.php");

    session_start();
    $_SESSION["site"]["last_visited"] = $_SERVER["REQUEST_URI"];

    $user_id = $_REQUEST["user_id"];
    if($user = get_user($user_id)) {
        $name = $user->first_name . " " . $user->last_name;
        $email = $user->email;
        $phone = $user->phone;
        $job_title = null;
        $company = null;
    } else {
        $failed = "<h4><span style='color:red'>
        Noe gikk galt, fant ikke bruker i systemet.
        </span></h4>";
    }
    if($user_company = get_user_company($user_id)) {
        $job_title = $user_company->job_title;
        $company = $user_company->company_name;
    }

?>

<!DOCTYPE html>
<html lang="en">
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
    <?php banner($user_id, false) ?>
    <div class="contact-form" id="fields">
        <form name="contact" method="POST"> 
            <section class="name-section">
                <label for="name">Navn</label>
                <input type="text" id="name" name="name" size="100" required>
            </section>

            <section class="email-section">
                <label for="email">E-post</label>
                <input type="text" id="email" name="email" required>
            </section>

            <section class="freetext-section" id="freetext">
                <label for="message">Din melding</label>
                <textarea name="freetext" cols="25" rows="10" name="description" wrap="physical" required></textarea>
            </section>

            <section class="submit-button">
                <button type="submit">Send inn</button>
            </section>
        </form>
    </div>
    <?php footer("profile"); ?>
</body>
</html>
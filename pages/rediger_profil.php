<?php
    require_once("../assets/include/header.inc.php");
    require_once("../assets/include/footer.inc.php");
    require_once("../assets/include/db.inc.php");

    session_start();
    $_SESSION["site"]["last_visited"] = $_SERVER["REQUEST_URI"];

    $user_id = $_GET["user_id"];
    if($user = get_user($user_id)) {
        $name = $user->first_name . " " . $user->last_name;
        $job_title = $user->job_title;
        $company = $user->company_name;
        $email = $user->email;
        $phone = $user->phone;
    } else {
        $failed = "<h4><span style='color:red'>
        Noe gikk galt, fant ikke bruker i systemet.
        </span></h4>";
    }
?>
<!DOCTYPE html>
<html lang="no">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/styles/styles.css">
    <!--<link rel="stylesheet" href="styling/rediger_profil_styles.css">-->
    <title>Rediger profil</title>
</head>
<body>
    <?php banner(true) ?>
    <div class="rediger_profil">
        <form action="rediger_profil.php" method="POST">
            <div class="profil_bilde">    
                <label for="profile-picture">Endre profilbilde</label>
                <img class="vis_profil_bilde" src="plassholder for senere bilde" alt="Profil bilde">
                <input type="file" id="profil_bilde" name="profil_bilde" accept="image/*">
            </div>

            <div class="redpro_input_text">
                <label for="full_name">Fullt navn</label>
                <input type="text" id="full_name" name="full_name" placeholder="Navnet ditt"><br><br>
            </div>

            <div class="redpro_input_text">
                <label for="stillingstittel">Stillingstittel</label>
                <input type="text" id="stillingstittel" name="stillingstittel" placeholder="Din stillingstittel"><br><br>
            </div>

            <div class="redpro_email">
                <label for="email">E-post</label>
                <input type="email" id="email" name="email" placeholder="eksempel@epost.no" ><br><br>
            </div>

            <div class="redpro_input_text">
                <label for="telefon">Telefon</label>
                <input type="tel" id="telefon" name="telefon" placeholder="+47 12345678" ><br><br>
            </div>

            <div class="rediger_some">
                <div class="column_rediger_profil">
                <label for="linkedin">LinkedIn</label>
                <input type="url" id="linkedin" name="linkedin" placeholder="linkedin.com/"><br><br>
                </div>

                <div class="column_rediger_profil">
                <label for="github">Github</label>
                <input type="url" id="github" name="github" placeholder="github.com/"><br><br>
                </div>

                <div class="column_rediger_profil">
                <label for="instagram">Instagram</label>
                <input type="url" id="instagram" name="instagram" placeholder="www.instagram.com/"><br><br>
                </div>
            </div>

            <div class="oppdater_profil_knapp">    
                <button type="submit">Oppdater profil</button>
            </div>
        </form>
    </div>
    <?php footer() ?>
</body>
</html>
<?php
    require_once("../assets/include/header.inc.php");
    require_once("../assets/include/db.inc.php");
    require_once("../assets/include/util.inc.php");
    require_once("../assets/include/phpmailer.inc.php");

    session_start();
    $_SESSION["site"]["last_visited"] = $_SERVER["REQUEST_URI"];
    $user_id = $_SESSION["user"]["user_id"];

    // Get user information from the database:
    if($user = get_user($user_id)) {
        $name = $user->first_name . " " . $user->last_name;
        $email = $user->email;
        $phone = $user->phone;
        $job_title = $user->job_title;
        $company = null;
    } else {
        $status = "<h4><span style='color:red'>
        Noe gikk galt, fant ikke bruker i systemet.
        </span></h4>";
    }

    // Oppdaterer tabellen med nye endringer gjort av bruker.
    if(isset($_REQUEST["submit_redpro"])) {
        $first_name = ucfirst(strtolower(clean($_REQUEST["first_name"])));
        $last_name = ucfirst(strtolower(clean($_REQUEST["last_name"])));
        $job_title = clean_allow_null($_REQUEST["stillingstittel"]);
        $email = validateEmail(cleanEmail($_REQUEST["email"]));
        $phone = clean($_REQUEST["telefon"]);
        $linkedin = clean_allow_null($_REQUEST["linkedin"]);
        $github = clean_allow_null($_REQUEST["github"]);
        $instagram = clean_allow_null($_REQUEST["instagram"]);

        $updated_profile = [$first_name, $last_name, $job_title, $email, $phone, $linkedin, $github, $instagram];

        if($first_name && $last_name && $email && $phone) {

            if(update_user_profile($user_id, $first_name, $last_name, $job_title, $email, $phone, $linkedin, $github, $instagram)) {
                $status = "<h4><span style='color:green'>
                Profil ble endret.
                </span></h4>";
            } else {
                $status = "<h4><span style='color:red'>
                Noe gikk galt, endringer ble ikke foretatt.
                </span></h4>";
            }
        } else {
            $status = "<h4><span style='color:red'>
            Noe gikk galt, endringer ble ikke foretatt i det større bildet.
            </span></h4>";
        }
    }
    
    // Forsøk på å vise informasjon allerede tilgjengelig i redpro.
    $user_profile = get_user($user_id);
    $first_name = null;
    $last_name = null;
    $job_title = null;
    $email = null;
    $phone = null;

    if($user_profile) {
        $first_name = $user_profile->first_name ?? '';
        $last_name = $user_profile->last_name ?? '';
        $job_title = $user_profile->job_title ?? '';
        $email = $user_profile->email ?? '';
        $phone = $user_profile->phone ?? '';
    } else {
        // Endringer behøvs
        $failed = "<h4><span style='color:red'>
        Noe gikk galt. kjipt.
        </span></h4>";
    }
    
    // Gjør det slik at alle some lenker er null til å begynne med.
    $user_social = get_user_socialmedia($user_id);
    $linkedin = null;
    $github = null;
    $instagram = null;

    // Skal gjøre en sjekk for å se om det finnes i databasen
    if($user_social) {
        $linkedin = $user_social->linkedin ?? '';
        $github = $user_social->github ?? '';
        $instagram = $user_social->instagram ?? '';
    } else {
        // Endringer behøvs
        $failed = "<h4><span style='color:red'>
        Noe gikk galt, fant ingen linker i systemet.
        </span></h4>";
    }

    // Change password verification email:
    if(isset($_REQUEST["change_password"])) {
        $verification = substr(md5(microtime()),rand(0,26),6);
        
        delete_validation_code($email);
        if(create_validation_code($email, $verification, 60)) {
            $reciever_name = $user->first_name;
            $reciever_email = $user->email;
            $timestamp = strtotime("now") + 60*60;
            $valid_to = date('H:i', $timestamp);
            $subject = "Bytt passord";
            $message  = "<h3>Følg lenken for å bytte passordet:</h3>";
            $message .= "<a href='http://localhost/digikort/pages/utility/password_change.php?verification=$verification'>Klikk her for å bytte passord.</a>"; // Denne må oppdateres om vi går live.
            $message .= "<p>Lenken er gyldig til klokken $valid_to.</p>";
            $message .= "<p>Vennligst ta kontakt med oss på digikortpass@gmail.com om dette ikke var deg.</p>";
            
            if(sendMail($reciever_email, $subject, $message, $reciever_name)) {
                $status = "<h4><span style='color:green'>
                    En link for tilbakestilling av passordet har blitt sendt til $reciever_email.
                    </span></h4>";
            } else {
                $status = $status = "<h4><span style='color:red'>
                    Noe gikk galt, klarte ikke sende link for tilbakestilling av passord til $reciever_email.
                    </span></h4>";
            }
        } else {
            $status = $status = "<h4><span style='color:red'>
                Noe gikk galt, vennligst prøv igjen.
                </span></h4>";
        }
    }

    // Upload new image
    if(isset($_REQUEST["submit_redpro"])) { // Knappen er trykt
        if(is_uploaded_file($_FILES['upload-file']['tmp_name'])) {
            $file_type = $_FILES['upload-file']['type']; // Type
            $file_size = $_FILES['upload-file']['size']; // Bytes
            $file_size = round($file_size / 1048576, 2); // MB

            $acc_file_types = array("jpg" => "image/jpeg", "png" => "image/png"); // Tillatt filtyper
            $max_file_size = 200; // MB

            $folder = md5("user." . $user_id);
            // $dir = "../profiles/" . $folder. "/";
            $dir = $_SERVER['DOCUMENT_ROOT'] . "/digikort/profiles/" . $folder . "/"; // Definerer mappe
            if(!file_exists($dir)) { // Om mappen ikke eksisterer
                if(!mkdir($dir, 0777, true)) { // Lager mappe og gir feilmeding vis det ikke går
                    die("Kunne ikke opprette mappen: " . $dir);
                }
            }

            $error = array(); // Setter opp array som samler inn feilmeldinger
            if(!in_array($file_type, $acc_file_types)) {
                $acc_types = implode(", ", array_keys($acc_file_types));
                $error[] = "Ugyldig filtype, kun $acc_types er tillat.";
            }
            if($file_size > $max_file_size) {
                $error[] = "Filen du valgte er på $file_size MB og overgår grensen på 2 MB.";
            }

            if(empty($error)) { // Dersom feilmelding-array er tomt
                if(file_exists($dir . "profile_picture.jpg")) {
                    unlink($dir . "profile_picture.jpg");
                    //echo 1;
                }
                if(file_exists($dir . "profile_picture.png")) {
                    unlink($dir . "profile_picture.png");
                    //echo 2;
                }

                $suffix = array_search($file_type, $acc_file_types);
                $filename = "profile_picture." . $suffix;
                
                $uploaded_file = move_uploaded_file($_FILES['upload-file']['tmp_name'], $dir . $filename); // Prøver å laste opp fil
                if(!$uploaded_file) { // Hvis den feiler
                    $error[] = "Filen kunne ikke lastes opp.";
                    //echo 3;
                }
            }
        } 
    }
    // Display error message(s)
    if(isset($error) && !empty($error)) { // Skriver ut feilmeldinger om det er noen feil
        echo "<h4><span style='color:red';>Feilmelding" . (count($error) > 1 ? "er:" : ":") . "</span></h4>";
        foreach($error as $message) {
            echo "<span style='color:red';>" . $message . "</span><br>";
        }
        //echo 5;
    }
?>
<!DOCTYPE html>
<html lang="no">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/styles/styles.css">
    <title>Rediger profil</title>
</head>
<body>
    <?php banner($user_id) ?>
    <div class="rediger_profil">
        <form class="redpro_form" action="" method="POST" enctype="multipart/form-data">
        <?php if(isset($status)) echo $status; ?>
            <div class="profil_bilde">    
                <label class="redpro_label" for="upload-file">Endre profilbilde</label>
                <input type="file" id="profil_bilde" name="upload-file">
            </div>

            <div class="redpro_input_text">
                <label class="redpro_label" for="first_name">Fornavn<mandatory style="color: red">*</mandatory></label>
                <input type="text" id="first_name" name="first_name" placeholder="Fornavnet ditt" value="<?=$first_name?>"><br><br>
            </div>

            <div class="redpro_input_text">
                <label class="redpro_label" for="last_name">Etternavn<mandatory style="color: red">*</mandatory></label>
                <input type="text" id="last_name" name="last_name" placeholder="Etternavnet ditt" value="<?=$last_name?>"><br><br>
            </div>

            <div class="redpro_input_text">
                <label class="redpro_label" for="stillingstittel">Stillingstittel</label>
                <input type="text" id="stillingstittel" name="stillingstittel" placeholder="Din stillingstittel" value="<?=$job_title?>"><br><br>
            </div>

            <div class="redpro_email">
                <label class="redpro_label" for="email">E-post<mandatory style="color: red">*</mandatory></label>
                <input type="email" id="email" name="email" placeholder="eksempel@epost.no" value="<?=$email?>"><br><br>
            </div>

            <div class="redpro_input_text">
                <label class="redpro_label" for="telefon">Telefon<mandatory style="color: red">*</mandatory></label>
                <input type="tel" id="telefon" name="telefon" placeholder="+47 12345678" value="<?=$phone?>"><br><br>
            </div>

            <!-- Legg til et felt for å slutte i bedrift -->

            <div class="rediger_some">
                <div class="column_rediger_profil">
                    <label class="redpro_label" for="linkedin">LinkedIn</label>
                    <input type="url" id="linkedin" name="linkedin" placeholder="linkedin.com/" value="<?=$linkedin?>"><br><br>
                </div>

                <div class="column_rediger_profil">
                    <label class="redpro_label" for="github">Github</label>
                    <input type="url" id="github" name="github" placeholder="github.com/" value="<?=$github?>"><br><br>
                </div>

                <div class="column_rediger_profil">
                    <label class="redpro_label" for="instagram">Instagram</label>
                    <input type="url" id="instagram" name="instagram" placeholder="www.instagram.com/" value="<?=$instagram?>"><br><br>
                </div>
            </div>
            <div class="oppdater_profil_knapp">    
                <button type="submit" name="submit_redpro">Oppdater profil</button>
            </div>
        </form>
        <form action="" method="post">
            <div class="change_password_button">
                <button type="submit" name="change_password">Bytt passord</button>
            </div>
        </form>
    </div>
</body>
</html>
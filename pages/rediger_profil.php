<?php
    require_once("../assets/include/header.inc.php");
    require_once("../assets/include/db.inc.php");
    require_once("../assets/include/util.inc.php");

    session_start();
    $_SESSION["site"]["last_visited"] = $_SERVER["REQUEST_URI"];
    $user_id = $_SESSION["user"]["user_id"];

    if($user = get_user($user_id)) {
        $name = $user->first_name . " " . $user->last_name;
        $email = $user->email;
        $phone = $user->phone;
        $job_title = null;
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
    <?php banner($user_id, false) ?>
    <div class="rediger_profil">
    <?php
            if(isset($status)) {
                echo $status;
            }
        ?>
            <form class="redpro_form" action="rediger_profil.php" method="POST" enctype="multipart/form-data">
            <div class="profil_bilde">    
                <label class="redpro_label" for="profile-picture">Endre profilbilde</label>
                <!-- Tror ikke det er behov for img -->
                <input type="file" id="profil_bilde" name="profil_bilde" accept="image/*">
            </div>

            <div class="redpro_input_text">
                <label class="redpro_label" for="first_name">Fornavn<mandatory style="color: red">*</mandatory></label>
                <input type="text" id="first_name" name="first_name" placeholder="Fornavnet ditt"><br><br>
            </div>

            <div class="redpro_input_text">
                <label class="redpro_label" for="last_name">Etternavn<mandatory style="color: red">*</mandatory></label>
                <input type="text" id="last_name" name="last_name" placeholder="Etternavnet ditt"><br><br>
            </div>

            <div class="redpro_input_text">
                <label class="redpro_label" for="stillingstittel">Stillingstittel</label>
                <input type="text" id="stillingstittel" name="stillingstittel" placeholder="Din stillingstittel"><br><br>
            </div>

            <div class="redpro_email">
                <label class="redpro_label" for="email">E-post<mandatory style="color: red">*</mandatory></label>
                <input type="email" id="email" name="email" placeholder="eksempel@epost.no" ><br><br>
            </div>

            <div class="redpro_input_text">
                <label class="redpro_label" for="telefon">Telefon<mandatory style="color: red">*</mandatory></label>
                <input type="tel" id="telefon" name="telefon" placeholder="+47 12345678" ><br><br>
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
        
    </div>
</body>
</html>
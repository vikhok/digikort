<?php
    require_once("../assets/include/header.inc.php");
    require_once("../assets/include/db.inc.php");
    require_once("../assets/include/util.inc.php");
    require_once("../assets/include/phpmailer.inc.php");

    session_start();
    $user_id = $_SESSION["user"]["user_id"];

    // Get user information from the database:
    if($user = get_user_with_socials_and_company($user_id)) {
        $first_name = $user->first_name ?? null;
        $last_name = $user->last_name ?? null;
        $job_title = $user->job_title ?? null;
        $email = $user->email ?? null;
        $phone = $user->phone ?? null;
        $linkedin = $user->linkedin ?? null;
        $github = $user->github ?? null;
        $instagram = $user->instagram ?? null;
        $company_id = $user->company_id ?? false;

        // Array as reference of current information state:
        $current_profile = [$first_name, $last_name, $job_title, $email, $phone, $linkedin, $github, $instagram];

        // Oppdaterer tabellen med nye endringer gjort av bruker.
        if(isset($_REQUEST["update_profile"])) {
            $first_name = ucfirst(strtolower(clean($_REQUEST["first_name"])));
            $last_name = ucfirst(strtolower(clean($_REQUEST["last_name"])));
            $job_title = clean_allow_null($_REQUEST["stillingstittel"]);
            $email = strtolower(validateEmail(cleanEmail($_REQUEST["email"])));
            $phone = clean($_REQUEST["telefon"]);
            $linkedin = strtolower(clean_allow_null($_REQUEST["linkedin"]));
            $github = strtolower(clean_allow_null($_REQUEST["github"]));
            $instagram = strtolower(clean_allow_null($_REQUEST["instagram"]));

            // Array to compare against the current information state:
            $updated_profile = [$first_name, $last_name, $job_title, $email, $phone, $linkedin, $github, $instagram];

            // Check that all variables are accepted:
            if(!in_array(false, $updated_profile, true)) {
                // Check if changes were made to the profile or profile picture:
                if($updated_profile != $current_profile || is_uploaded_file($_FILES["upload-file"]["tmp_name"])) {
                    $error = array(); // Setter opp array som samler inn feilmeldinger
                    if($_FILES["upload-file"]["tmp_name"] != null) {
                        $file_type = $_FILES["upload-file"]["type"]; // Type
                        $file_size = $_FILES["upload-file"]["size"]; // Bytes
                        $file_size = round($file_size / 1048576, 2); // MB
                        $acc_file_types = array("jpg" => "image/jpeg", "png" => "image/png"); // Tillatt filtyper
                        $max_file_size = 2; // MB
            
                        $folder = md5("user." . $user_id);
                        $dir = $_SERVER["DOCUMENT_ROOT"] . "/digikort/profiles/" . $folder . "/"; // Definerer mappe
                        if(!file_exists($dir)) { // Om mappen ikke eksisterer
                            if(!mkdir($dir, 0777, true)) { // Lager mappe og gir feilmeding vis det ikke går
                                die("Kunne ikke opprette mappen: " . $dir);
                            }
                        }
            
                        if(!in_array($file_type, $acc_file_types)) {
                            $acc_types = implode(", ", array_keys($acc_file_types));
                            $error[] = "Ugyldig filtype, kun $acc_types er tillat.";
                        }
                        if($file_size > $max_file_size) {
                            $error[] = "Filen du valgte er på $file_size MB og overgår grensen på 2 MB.";
                        }
            
                        if(empty($error)) {
                            if(file_exists($dir . "profile_picture.jpg")) {
                                unlink($dir . "profile_picture.jpg");
                            }
                            if(file_exists($dir . "profile_picture.png")) {
                                unlink($dir . "profile_picture.png");
                            }
                            $suffix = array_search($file_type, $acc_file_types);
                            $filename = "profile_picture." . $suffix;
                            
                            $uploaded_file = move_uploaded_file($_FILES["upload-file"]["tmp_name"], $dir . $filename); // Prøver å laste opp fil
                            if(!$uploaded_file) { // Hvis den feiler
                                $error[] = "Filen kunne ikke lastes opp.";
                            }
                        }
                    }

                    if(empty($error)) {
                        if(update_user_profile($user_id, $first_name, $last_name, $job_title, $email, $phone, $linkedin, $github, $instagram)) {
                            $status = "<h4><span style='color:green'>
                                Profilen ble endret.
                                </span></h4>";
                        } else {
                            $status = "<h4><span style='color:red'>
                                Noe gikk galt, endringer av profil ble ikke foretatt.
                                </span></h4>";
                        }
                    }
                } else {
                    $status = "<h4><span style='color:red'>
                        Ingen endringer har blitt foretatt.
                        </span></h4>";
                }
            } else {
                $status = "<h4><span style='color:red'>
                    Noe gikk galt, endringer av profil ble ikke foretatt XDLMAO.
                    </span></h4>";
            }
        }
    
        if(isset($_REQUEST["change_password"])) {
            $verification = substr(md5(microtime()),rand(0,26),6);
            delete_validation_code($email);
            if(create_validation_code($email, $verification, 60)) {
                $reciever_name = $user->first_name;
                $reciever_email = $user->email;
                $timestamp = strtotime("now") + 60*60;
                $valid_to = date("H:i", $timestamp);
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

        if(isset($_REQUEST["leave_company"])) {
            if(leave_company($user_id, $company_id)) {
                $status = "<h4><span style='color:green'>
                    Du har forlatt bedriften.
                    </span></h4>";
            } else {
                $status = "<h4><span style='color:red'>
                    Noe gikk galt, fikk ikke til å forlate bedriften.
                    </span></h4>";
            }
        }

        if(isset($_REQUEST["delete_user"])) {
            $folder = md5("user." . $user_id);
            $dir = "../profiles/$folder";
            if(rrmdir($dir)) {
                if(delete_user($user_id)) {
                    header("Location: utility/login.php");
                } else {
                    $status = "<h4><span style='color:red'>
                        Noe gikk galt, fikk ikke slettet profilen 1.
                        </span></h4>";
                }
            } else {
                $status = "<h4><span style='color:red'>
                    Noe gikk galt, fikk ikke slettet profilen 2.
                    </span></h4>";
            }
        }
    } else {
        $status = "<h4><span style='color:red'>
            Noe gikk galt, fant ikke bruker i systemet.
            </span></h4>";
    }
?>
<!DOCTYPE html>
<html lang="no">
<head>
    <script>
        
    </script>
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
            <?php
                if(isset($status)) echo $status;
                if(isset($error) && !empty($error)) {
                    echo "<h4><span style='color:red';>Feilmelding" . (count($error) > 1 ? "er:" : ":") . "</span></h4>";
                    foreach($error as $message) {
                        echo "<span style='color:red';>" . $message . "<br>Endring ble ikke lagret.</span>";
                    }
                }
            ?>
            <div class="profil_bilde">    
                <label class="redpro_label" for="upload-file">Endre profilbilde</label>
                <input type="file" id="profil_bilde" name="upload-file">
            </div>
            <div class="redpro_input_text">
                <label class="redpro_label" for="first_name">Fornavn<mandatory style="color:red">*</mandatory></label>
                <input type="text" id="first_name" name="first_name" placeholder="Fornavn" pattern="[A-Za-zÆæØøÅå'-]{1,64}" value="<?=$first_name?>" required 
                    oninvalid="this.setCustomValidity('Obligatorisk felt. Fornavn kan kun inneholde store og små bokstaver, apostrof og bindestrek opp til 64 tegn')"
                    oninput="this.setCustomValidity('')"><br><br>
            </div>
            <div class="redpro_input_text">
                <label class="redpro_label" for="last_name">Etternavn<mandatory style="color:red">*</mandatory></label>
                <input type="text" id="last_name" name="last_name" placeholder="Etternavn" pattern="[A-Za-zÆæØøÅå'-]{1,64}" value="<?=$last_name?>" required 
                    oninvalid="this.setCustomValidity('Obligatorisk felt. Etternavn kan kun inneholde store og små bokstaver, apostrof og bindestrek opp til 64 tegn')"
                    oninput="this.setCustomValidity('')"><br><br>
            </div>
            <div class="redpro_input_text">
                <label class="redpro_label" for="stillingstittel">Stillingstittel</label>
                <input type="text" id="stillingstittel" name="stillingstittel" placeholder="Stilling" pattern="[A-Za-zÆæØøÅå'-]{1,64}" value="<?=$job_title?>" 
                    oninvalid="this.setCustomValidity('Obligatorisk felt. Etternavn kan kun inneholde store og små bokstaver, apostrof og bindestrek opp til 64 tegn')"
                    oninput="this.setCustomValidity('')"><br><br>
            </div>
            <div class="redpro_email">
                <label class="redpro_label" for="email">E-post<mandatory style="color:red">*</mandatory></label>
                <input type="email" id="email" name="email" placeholder="eksempel@epost.no" value="<?=$email?>" required 
                    oninvalid="this.setCustomValidity('Obligatorisk felt. Eksempelvis: ola@mail.no.')"
                    oninput="this.setCustomValidity('')"><br><br>
            </div>
            <div class="redpro_input_text">
                <label class="redpro_label" for="telefon">Telefon<mandatory style="color:red">*</mandatory></label>
                <input type="tel" id="telefon" name="telefon" placeholder="+4712345678" pattern="[0-9+]{8,12}" value="<?=$phone?>" required 
                    oninvalid="this.setCustomValidity('Obligatorisk felt. Eksempelvis +4712345678')"
                    oninput="this.setCustomValidity('')"><br><br>
            </div>
            <div class="rediger_some">
                <div class="column_rediger_profil">
                    <label class="redpro_label" for="linkedin">LinkedIn</label>
                    <input type="url" id="linkedin" name="linkedin" placeholder="https://www.linkedin.com/" pattern="{1,255}" value="<?=$linkedin?>"><br><br>
                </div>
                <div class="column_rediger_profil">
                    <label class="redpro_label" for="github">Github</label>
                    <input type="url" id="github" name="github" placeholder="https://www.github.com/" pattern="{1,255}" value="<?=$github?>"><br><br>
                </div>
                <div class="column_rediger_profil">
                    <label class="redpro_label" for="instagram">Instagram</label>
                    <input type="url" id="instagram" name="instagram" placeholder="https://www.instagram.com/" pattern="{1,255}" value="<?=$instagram?>"><br><br>
                </div>
            </div>
            <div class="oppdater_profil_knapp">    
                <button type="submit" name="update_profile">Oppdater profil</button>
            </div>
        </form>
        <form action="" method="post">
            <div class="change_password_button">
                <button type="submit" name="change_password">Bytt passord</button>
            </div>
        </form>
        <form actuon="" method="post">
            <div class="leave_company_button">
                <button type="submit" name="leave_company">Forlat bedrift</button>
            </div>
        </form>
        <form actuon="" method="post">
            <div class="delete_user_button">
                <button type="submit" name="delete_user">Slett profil</button>
            </div>
        </form>
    </div>
</body>
</html>

<?php
    require_once("../assets/include/header.inc.php");
    require_once("../assets/include/db.inc.php");
    require_once("../assets/include/util.inc.php");
    require_once("../assets/include/phpmailer.inc.php");

    session_start();
    $company_id = $_SESSION["user"]["company_id"];

    if($company = get_company_info($company_id)) {
        $_SESSION["site"]["last_visited"] = $_SERVER["REQUEST_URI"];
        
        $company_name = $company->company_name ?? null;
        $company_desc = $company->company_desc ?? null;
        $company_email = $company->company_email ?? null;
        $company_url = $company->company_url ?? null;
        $company_address = $company->company_address ?? null;
        $company_city = $company->company_city ?? null;
        $company_zip = $company->company_zip ?? null;
        $access_code = $company->access_code ?? null;

        // Array as reference of current information state:
        $current_company = [$company_name, $company_desc, $company_email, $company_url, $company_address, $company_city, $company_zip, $access_code];

        // Oppdaterer tabellen med nye endringer gjort av bruker.
        if(isset($_REQUEST["submit"])) {
            $company_name = clean($_REQUEST["company_name"]);
            $company_desc = ucfirst(clean($_REQUEST["company_desc"]));
            $company_email = strtolower(validateEmail(cleanEmail($_REQUEST["company_email"])));
            $company_url = strtolower(clean_allow_null($_REQUEST["company_url"]));
            $company_address = ucwords(strtolower(clean($_REQUEST["company_address"])));
            $company_city = ucwords(strtolower(clean_allow_null($_REQUEST["company_city"])));
            $company_zip = clean_allow_null($_REQUEST["company_zip"]);
            $access_code = clean($_REQUEST["access_code"]);

            // Array to compare against the current information state:
            $updated_company = [$company_name, $company_desc, $company_email, $company_url, $company_address, $company_city, $company_zip, $access_code];

            // Check that all variables are accepted:
            if(!in_array(false, $updated_company, true)) {
                // Check if changes were made to the profile or profile picture:
                if($current_company != $updated_company || is_uploaded_file($_FILES["upload-file"]["tmp_name"])) {
                    if($_FILES["upload-file"]["tmp_name"] != null) {
                        $upload_image = upload_image($company_id, "company"); // returns array which may contain errors
                        if(!empty($upload_image)) {
                            $terminate = true;
                            show_alert("Noe gikk galt, endringer av bedriften ble ikke foretatt");
                        }
                    }
                    if(!isset($terminate)) {
                        if(update_company($company_name, $company_desc, $company_email, $company_url, $company_address, $company_city, $company_zip, $access_code, $company_id)) {
                            show_alert("Bedriften ble endret");
                        } else {
                            show_alert("Noe gikk galt, endringer av bedriften ble ikke foretatt");
                        }
                    }        
                } else {
                    show_alert("Ingen endringer har blitt foretatt");
                }
            } else {
                show_alert("Noe gikk galt, endringer av bedriften ble ikke foretatt");
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="no">
<head>
    <meta charset="UTF-8">
    <title>Rediger Bedrift</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/styles/styles.css">
    <script src="../assets/include/javascript/prompt.js" type="text/javascript"></script>
</head>
<body>
    <?php banner(); ?>
    <div class="rediger_profil">
        <?php if(isset($status)) echo $status; ?>
        <form class="redpro_form" action="" method="post" enctype="multipart/form-data">
            <div class="profil_bilde"> 
                <label class="rediger-bedrift-label" for="upload-file">Endre bakgrunnsbilde for bedrift</label>
                <input type="file" id="bedrift-bilde" name="upload-file">
            </div>
            <div class="redpro_input_text" id="fields">
                <label class="rediger-bedrift-label" for="company_name">Navn på bedriften</label>
                <input type="text" id="company_name" name="company_name" placeholder="Bedriften AS" pattern="[A-Za-zÆæØøÅå'- ]{1,50}" value="<?=$company_name?>" required 
                    oninvalid="this.setCustomValidity('Obligatorisk felt. Navn på bedrift kan kun inneholde store og små bokstaver, apostrof og bindestrek opp til 50 tegn.')"
                    oninput="this.setCustomValidity('')">
            </div>
            <div class="redpro_input_text" id="freetext">
                <label class="rediger-bedrift-label" for="company_desc">Beskrivelse av bedriften</label>
                <textarea name="company_desc" placeholder="Vi er bedriften og holder på med..." wrap="physical" pattern="[A-Za-zÆæØøÅå'- ]{1,200}" required 
                    oninvalid="this.setCustomValidity('Obligatorisk felt. Beskrivelse kan kun inneholde store og små bokstaver, apostrof og bindestrek opp til 200 tegn.')"
                    oninput="this.setCustomValidity('')"><?=$company_desc?></textarea>
            </div>
            <div class="redpro_input_text" id="freetext">
                <label class="rediger-bedrift-label" for="company_email">E-post</label>
                <input type="email" name="company_email" placeholder="bedriften@mail.no" value="<?=$company_email?>" required 
                    oninvalid="this.setCustomValidity('Obligatorisk felt. Eksempelvis: bedriften@mail.no.')"
                    oninput="this.setCustomValidity('')">
            </div>
            <div class="redpro_input_text" for="company_url">
                <label class="rediger-bedrift-label" for="company_url">Nettstedets URL</label>
                <input type="text" id="company_url" name="company_url" placeholder="www.bedrift.no" pattern="[A-Za-zÆæØøÅå'-.]{1,50}" value="<?=$company_url?>" required 
                    oninvalid="this.setCustomValidity('Obligatorisk felt. Vennligst følg formatet www.bedriften.no, inntill 50 tegn.')"
                    oninput="this.setCustomValidity('')">
            </div>
            <div class="redpro_input_text" for="company_address">
                <label class="rediger-bedrift-label" for="name">Addresse</label>
                <input type="text" id="company_address" name="company_address" placeholder="Bedriftveien 3" pattern="[0-9A-Za-zÆæØøÅå'- ]{1,100}" value="<?=$company_address?>" required 
                    oninvalid="this.setCustomValidity('Obligatorisk felt. Addressen kan kun inneholde store og små bokstaver, tall, apostrof og bindestrek opp til 100 tegn.')"
                    oninput="this.setCustomValidity('')">
            </div>
            <div class="redpro_input_text" for="company_city">
                <label class="rediger-bedrift-label" for="name">By</label>
                <input type="text" id="company_city" name="company_city" placeholder="Kristiansand" pattern="[A-Za-zÆæØøÅå'- ]{1,50}" value="<?=$company_city?>" required 
                    oninvalid="this.setCustomValidity('Obligatorisk felt. By kan kun inneholde store og små bokstaver, apostrof og bindestrek opp til 50 tegn.')"
                    oninput="this.setCustomValidity('')">
            </div>
            <div class="redpro_input_text" for="company_zip">
                <label class="rediger-bedrift-label" for="name">Postnummer</label>
                <input type="text" id="company_zip" name="company_zip" placeholder="4630" pattern="[0-9]{1,4}" value="<?=$company_zip?>" required 
                    oninvalid="this.setCustomValidity('Obligatorisk felt. Postnummer kan kun inneholde fire tall, vennligst følg formatet 1234.')"
                    oninput="this.setCustomValidity('')">
            </div>
            <div class="redpro_input_text" for="access_code">
                <label class="rediger-bedrift-label" for="name">Sikkerhetskode</label>
                <input type="text" id="access_code" name="access_code" placeholder="Hemmelig kode" pattern="[A-Za-zÆæØøÅå-!?#]{1,50}" value="<?=$access_code?>" required 
                    oninvalid="this.setCustomValidity('Obligatorisk felt. Sikkerhetskoden kan kun inneholde 50 karakterer i form av bokstaver, tall og tegn som -!?#')"
                    oninput="this.setCustomValidity('')">
            </div>
            <div class="rediger-bedrift_submit">
                <button type="submit" name="submit">Lagre</button>
            </div>
        </form>
    </div>
</body>
</html>

<?php
    require_once("../assets/include/header.inc.php");
    require_once("../assets/include/db.inc.php");
    require_once("../assets/include/util.inc.php");

    session_start();
    $user_id = $_SESSION["user"]["user_id"];

    if($_SESSION["user"]["logged_in"]) {
        if(!isset($_SESSION["user"]["company_id"])) {
            $_SESSION["site"]["last_visited"] = $_SERVER["REQUEST_URI"];
        } else {
            $company_id = $_SESSION["user"]["company_id"];
            header("Location: company.php?company_id=$company_id");
            exit();
        }
    } else {
        header("Location: utility/error.php?error=401");
        exit();
    }
    
    $company_name = null;
    $company_desc = null;
    $company_email = null;
    $company_url = null;
    $company_address = null;
    $company_city = null;
    $company_zip = null;
    $access_code = null;

    if(isset($_REQUEST["create_company"])) {
        $company_name = clean($_REQUEST["company_name"]);
        $company_desc = ucfirst(clean($_REQUEST["company_desc"]));
        $company_email = strtolower(validateEmail(cleanEmail($_REQUEST["company_email"])));
        $company_url = strtolower(clean_allow_null($_REQUEST["company_url"]));
        $company_address = ucwords(strtolower(clean($_REQUEST["company_address"])));
        $company_city = ucwords(strtolower(clean_allow_null($_REQUEST["company_city"])));
        $company_zip = clean_allow_null($_REQUEST["company_zip"]);
        $access_code = clean($_REQUEST["access_code"]);
        
        if($company_id = add_company($company_name, $company_desc, $company_email, $company_url, $company_address, $company_city, $company_zip, $access_code, $user_id)) {
            $folder = "../companies/" . md5("company." . $company_id);
            if(!file_exists($folder)) mkdir($folder, 0777, true);
            $_SESSION["user"]["company_id"] = $company_id;
            header("Location: company.php?company_id=$company_id");
            exit();
        } else {
            show_alert("Noe gikk galt, bedriften ble ikke opprettet i systemet. Det kan være at en bedrift med samme navn allerede er registrert.");
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
    <script src="../assets/include/javascript/prompt.js" type="text/javascript"></script>
    <title>Opprett bedrift</title>
</head>
<body>
    <?php banner(); ?>
    <div class="rediger_profil">
        <?php if(isset($status)) echo $status; ?>
        <form class="redpro_form" method="post" enctype="multipart/form-data">
            <div class="redpro_input_text" id="fields">
                <label class="rediger-bedrift-label" for="company_name">Navn på bedriften</label>
                <input type="text" id="company_name" name="company_name" placeholder="Bedriften AS" pattern="[A-Za-zÆæØøÅå'- ]{1,50}" value="<?=$company_name?>" required 
                    oninvalid="this.setCustomValidity('Obligatorisk felt. Navn på bedrift kan kun inneholde store og små bokstaver, apostrof og bindestrek opp til 50 tegn.')"
                    oninput="this.setCustomValidity('')">
            </div>
            <div class="redpro_input_text" id="free_text">
                <label class="rediger-bedrift-label" for="company_email">E-post</label>
                <input type="email" class="company_email_field" name="company_email" placeholder="bedriften@mail.no" value="<?=$company_email?>" required 
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
            <div class="redpro_input_text" id="free_text">
                <label class="rediger-bedrift-label" for="company_desc">Beskrivelse av bedriften</label>
                <textarea name="company_desc" class="company_descr" placeholder="Vi er bedriften og holder på med..." wrap="physical" pattern="[0-9A-Za-zÆæØøÅå'- ]{1,200}" value="<?=$company_desc?>" required 
                    oninvalid="this.setCustomValidity('Obligatorisk felt. Beskrivelse kan kun inneholde store og små bokstaver, tall, apostrof og bindestrek opp til 200 tegn.')"
                    oninput="this.setCustomValidity('')"><?=$company_desc?></textarea>
            </div>  
            <div class="blue_button">
                <button type="submit" name="create_company">Opprett bedrift</button>
            </div>
        </form>
    </div>
</body>
</html>
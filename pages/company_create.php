<?php
    require_once("../assets/include/header.inc.php");
    require_once("../assets/include/db.inc.php");
    require_once("../assets/include/util.inc.php");

    session_start();
    $user_id = $_SESSION["user"]["user_id"];
    
    if(isset($_REQUEST["submit"])) {
        $company_name = clean($_REQUEST["company_name"]);
        $company_desc = ucfirst(clean($_REQUEST["company_desc"]));
        $company_email = strtolower(validateEmail(cleanEmail($_REQUEST["company_email"])));
        $company_url = strtolower(clean_allow_null($_REQUEST["company_url"]));
        $company_address = ucwords(strtolower(clean($_REQUEST["company_address"])));
        $company_city = ucwords(strtolower(clean_allow_null($_REQUEST["company_city"])));
        $company_zip = clean_allow_null($_REQUEST["company_zip"]);
        $access_code = clean($_REQUEST["access_code"]);
        
        if($company_id = add_company($company_name, $company_desc, $company_email, $company_url, $company_address, $company_city, $company_zip, $access_code)) {
            header("Location: company.php?company_id=$company_id");
        } else {
            $status = "<h4><span style='color:red'>
                Noe gikk galt, bedriften ble ikke opprettet i systemet.
                </span></h4>";
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
    <title>Opprett bedrift</title>
</head>
<body>
    <?php banner(); ?>
    <div class="rediger_profil">
        <form class="redpro_form" method="POST" action="" enctype="multipart/form-data">
            <div class="redpro_input_text" id="fields">
                <label class="rediger-bedrift-label" for="company_name">Navn på bedriften</label>
                <input type="text" id="company_name" name="company_name" placeholder="Bedriften AS" pattern="[A-Za-zÆæØøÅå'- ]{1,50}" required 
                    oninvalid="this.setCustomValidity('Obligatorisk felt. Navn på bedrift kan kun inneholde store og små bokstaver, apostrof og bindestrek opp til 50 tegn.')"
                    oninput="this.setCustomValidity('')">
            </div>
            <div class="redpro_input_text" id="freetext">
                <label class="rediger-bedrift-label" for="company_desc">Beskrivelse av bedriften</label>
                <input type="text" name="company_desc" placeholder="Vi er bedriften og holder på med..." wrap="physical" pattern="[A-Za-zÆæØøÅå'- ]{1,200}" required 
                    oninvalid="this.setCustomValidity('Obligatorisk felt. Beskrivelse kan kun inneholde store og små bokstaver, apostrof og bindestrek opp til 200 tegn.')"
                    oninput="this.setCustomValidity('')">
            </div>
            <div class="redpro_input_text" id="freetext">
                <label class="rediger-bedrift-label" for="company_email">E-post</label>
                <input type="email" name="company_email" placeholder="bedriften@mail.no" required 
                    oninvalid="this.setCustomValidity('Obligatorisk felt. Eksempelvis: bedriften@mail.no.')"
                    oninput="this.setCustomValidity('')">
            </div>
            <div class="redpro_input_text" for="company_url">
                <label class="rediger-bedrift-label" for="company_url">Nettstedets URL</label>
                <input type="text" id="company_url" name="company_url" placeholder="www.bedrift.no" pattern="[A-Za-zÆæØøÅå'-.]{1,50}" required 
                    oninvalid="this.setCustomValidity('Obligatorisk felt. Vennligst følg formatet www.bedriften.no, inntill 50 tegn.')"
                    oninput="this.setCustomValidity('')">
            </div>
            <div class="redpro_input_text" for="company_address">
                <label class="rediger-bedrift-label" for="name">Addresse</label>
                <input type="text" id="company_address" name="company_address" placeholder="Bedriftveien 3" pattern="[0-9A-Za-zÆæØøÅå'- ]{1,100}" required 
                    oninvalid="this.setCustomValidity('Obligatorisk felt. Addressen kan kun inneholde store og små bokstaver, tall, apostrof og bindestrek opp til 100 tegn.')"
                    oninput="this.setCustomValidity('')">
            </div>
            <div class="redpro_input_text" for="company_city">
                <label class="rediger-bedrift-label" for="name">By</label>
                <input type="text" id="company_city" name="company_city" placeholder="Kristiansand" pattern="[A-Za-zÆæØøÅå'- ]{1,50}" required 
                    oninvalid="this.setCustomValidity('Obligatorisk felt. By kan kun inneholde store og små bokstaver, apostrof og bindestrek opp til 50 tegn.')"
                    oninput="this.setCustomValidity('')">
            </div>
            <div class="redpro_input_text" for="company_zip">
                <label class="rediger-bedrift-label" for="name">Postnummer</label>
                <input type="text" id="company_zip" name="company_zip" placeholder="4630" pattern="[0-9]{1,4}" required 
                    oninvalid="this.setCustomValidity('Obligatorisk felt. Postnummer kan kun inneholde fire tall, vennligst følg formatet 1234.')"
                    oninput="this.setCustomValidity('')">
            </div>
            <div class="redpro_input_text" for="access_code">
                <label class="rediger-bedrift-label" for="name">Sikkerhetskode</label>
                <input type="text" id="access_code" name="access_code" placeholder="Hemmelig kode" pattern="[A-Za-zÆæØøÅå-!?#]{1,50}" required 
                    oninvalid="this.setCustomValidity('Obligatorisk felt. Sikkerhetskoden kan kun inneholde 50 karakterer i form av bokstaver, tall og tegn som -!?#')"
                    oninput="this.setCustomValidity('')">
            </div>
            <div class="rediger-bedrift_submit">
                <button type="submit" name="submit">Lagre</button>
            </div>
        </form>
    </div>
    <?php if(isset($status)) echo $status; ?>
</body>
</html>
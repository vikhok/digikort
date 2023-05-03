<?php
    require_once("../assets/include/header.inc.php");
    require_once("../assets/include/db.inc.php");
    require_once("../assets/include/util.inc.php");

    session_start();
    $user_id = $_SESSION["user"]["user_id"];
    
    if(isset($_REQUEST["submit"])) {
        $company_name = clean($_REQUEST["company_name"]);
        $company_desc = ucfirst(clean($_REQUEST["company_desc"]));
        $company_email = strtolower(validateEmail(cleanEmail($_REQUEST["email"])));
        $company_url = strtolower(clean_allow_null($_REQUEST["company_url"]));
        $company_address = ucwords(strtolower(clean($_REQUEST["company_address"])));
        $company_city = ucwords(strtolower(clean_allow_null($_REQUEST["company_city"])));
        $company_zip = clean_allow_null($_REQUEST["company_zip"]);
        $company_pass = clean($_REQUEST["company_pass"]);
        
        if($company_id = add_company($company_name, $company_email, $company_desc, $company_url, $company_address, $company_city, $company_zip, $company_pass)) {
            header("Location: Company-page.php?company_id=$company_id");
        } else {
            $status = "<h4><span style='color:red'>
                Noe gikk galt, endringer ble ikke foretatt.
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

<?php banner(false) ?>
<div class="addcompany_structure" id="fields">
    <form class="addcompany_form" action="#" method="POST" enctype="multipart/form-data">
        <section class="company_name" for="company_name">
            <label for="name">Bedriftnavn</label>
            <input type="text" id="company_name" name="company_name" placeholder="Bedrift avdeling Oslo AS" size="100" required>
        </section>

        <section class="company_email" for="email">
            <label for="email">E-postadresse til bedriften</label>
            <input type="text" id="email" name="email" placeholder="mail@epost.com" size="100" required>
        </section>

        <section class="company_url" for="web_url">
            <label for="url">Nettside til bedriften</label>
            <input type="text" id="web_url" name="web_url" placeholder="www.bedriftsnavn.no" size="100" required>
        </section>

        <section class="company_description" id="freetext">
            <label for="information">Beskrivelse av bedriften</label>
            <textarea name="freetext" type="text" cols="25" rows="10" name="description" placeholder="Vi leverer skreddersydde tjenester til våre kunder" wrap="physical" required></textarea>
        </section>

        <section class="addcompany_submit">    
            <button type="submit" name="submit">Opprett bedrift</button>
        </section>
        <?php if(isset($status)) echo $status; ?>
    </form>
</div>
</body>
</html>
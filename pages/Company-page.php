<?php
    require_once("../assets/include/header.inc.php");
    require_once("../assets/include/footer.inc.php");
    require_once("../assets/include/db.inc.php");

    session_start();
    $user_id = $_SESSION["user"]["user_id"];

    $company_id = $_REQUEST["company_id"];
    if($company_info = get_company_info($company_id)) {
        $company_name = $company_info->company_name;
        $company_desc = $company_info->descriptions;
        $company_url = $company_info->web_url;
        $company_address = $company_info->company_address . ", " . $company_info->zip . " " . $company_city = $company_info->city;
        $company_email = $company_info->company_email;
    } else {
        $status = "<h4><span style='color:red'>
        Noe gikk galt, du er ikke oppført i en bedrift.
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
<title>Bedrift</title>
<body>
    <?php banner(false, $company_id) ?>

    <div class="Bedrift-siden">
        <img class="bedrift_bilde_styling" src="../Companies/Company1/Egde_Grimstad.png" alt="Bilde av bedriften">
    
        <div class="Bedrift-Text">
            <?php
                echo "<h2 class='bedrift-tittel'>$company_name</h2>
                    <p class='bedrift-desc'>$company_desc</p>
                    <br>    
                    <h3 class='address-form'>Besøk oss</h3>
                    <p class='bedrift-adresse'>$company_address</p>
                    <br>
                    <h3 class='e-post-form'>Kontakt oss på e-post</h3>
                    <p class='bedrift-epost'><a href='mailto:$company_email'>$company_email</a></p>"
            ?>
        </div>

        <div class="Bedrift-knapper">
            <div class="om-og-kontakt-knapp">
                <a class="aboutus-ref" href="https://egde.no/om-oss/">Om oss</a>
                <a class="employeelist-ref" href="https://egde.no/kontakt/">Se ansatte</a>
                <a class="a-map-ref" href="company_map.php?company_id=<?=$company_id?>">Veibeskrivelse på kart</a>
            </div>
        </div>
        <?php footer($company_id, "company");?>
    </div>
    <?php if(isset($status)){ echo $status; }?>
</body>
</head>
</html>
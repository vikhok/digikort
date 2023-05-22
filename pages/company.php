<?php
    require_once("../assets/include/header.inc.php");
    require_once("../assets/include/footer.inc.php");
    require_once("../assets/include/db.inc.php");

    session_start();
    $company_id = $_REQUEST["company_id"];

    if($company_info = get_company_info($company_id)) {
        $_SESSION["site"]["last_visited"] = $_SERVER["REQUEST_URI"];

        $company_name = $company_info->company_name;
        $company_desc = $company_info->company_desc;
        $company_url = $company_info->company_url;
        $company_address = $company_info->company_address . ", " . $company_info->company_zip . " " . $company_info->company_city;
        $company_email = $company_info->company_email;

        $folder = "../companies/" . md5("company." . $company_id);
        if(!file_exists($folder)) {
            mkdir($folder, 0777, true);
        }
        $dir = "../companies/" . $folder . "/picture.png";
        if(!file_exists($dir)) {
            $dir = "../companies/" . $folder . "/picture.jpg";
            if(!file_exists($dir)){
                $dir = "../companies/stockcompany/picture.png";
            }
        }
        $_SESSION["site"]["last_visited"] = $_SERVER["REQUEST_URI"];
    } else {
        header("Location: utility/error.php?error=404");
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
    <?php banner(); ?>
    <?php if($company_info): ?>
        <div class="Bedrift-siden">
            <img class="bedrift_bilde_styling" src="<?=$dir?>" alt="Bedrift bilde">
            <section class="Bedrift-Text">
                <h2 class="bedrift-tittel"><?=$company_name?></h2>
                <p class="bedrift-desc"><?=$company_desc?></p><br>

                <h3 class="address-form">Besøk oss</h3>
                <p class="bedrift-adresse"><?=$company_address?></p><br>

                <h3 class="e-post-form">Kontakt oss på e-post</h3>
                <p class="bedrift-epost"><a href="mailto:<?=$company_email?>"><?=$company_email?></a></p>
            </section>
            <div class="Bedrift-knapper">
                <div class="om-og-kontakt-knapp">
                    <a class="aboutus-ref" href="https://egde.no/om-oss/">Om oss</a>
                    <a class="employeelist-ref" href="https://egde.no/kontakt/">Se ansatte</a>
                    <a class="a-map-ref" href="company_map.php?company_id=<?=$company_id?>">Veibeskrivelse på kart</a>
                </div>
            </div>
        </div>
    <?php endif; ?>
</body>
</head>
</html>
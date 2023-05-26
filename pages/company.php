<?php
    session_start();
    
    require_once("../assets/include/header.inc.php");
    require_once("../assets/include/footer.inc.php");
    require_once("../assets/include/db.inc.php");
    
    $company_id = $_REQUEST["company_id"];
    if($company_info = get_company_info($company_id)) {
        $_SESSION["site"]["last_visited"] = $_SERVER["REQUEST_URI"];
        $_SESSION["business_card"]["company_id"] = $company_id;

        $company_name = $company_info->company_name;
        $company_desc = $company_info->company_desc;
        $company_url = $company_info->company_url;
        $company_address = $company_info->company_address . ", " . $company_info->company_zip . " " . $company_info->company_city;
        $company_email = $company_info->company_email;

        $folder = "../images/companies/" . md5("company." . $company_id);
        if(!file_exists($folder)) {
            mkdir($folder, 0777, true);
        }
        $dir = $folder . "/picture.png";
        if(!file_exists($dir)) {
            $dir = $folder . "/picture.jpg";
            if(!file_exists($dir)){
                $dir = "../images/companies/stockcompany/picture.png";
            }
        }
        $_SESSION["site"]["last_visited"] = $_SERVER["REQUEST_URI"];
    } else {
        header("Location: utility/error.php?error=404");
        exit();
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
                    <a class="company_page_buttons" href="https://<?=$company_url?>">Nettside</a>
                    <a class="company_page_buttons" href="company_map.php?company_id=<?=$company_id?>">Veibeskrivelse</a>
                    <a class="company_page_buttons" href="company_members.php?company_id=<?=$company_id?>">Ansatte</a>
                    <?php if(isset($_SESSION["user"]["logged_in"]) && verify_admin_role($company_id, $_SESSION["user"]["user_id"])): ?>
                        <a class="company_page_buttons" href="company_update.php">Rediger bedrift</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php endif; ?>
</body>
</head>
</html>
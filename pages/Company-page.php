<?php
    require_once("../assets/include/header.inc.php");
    require_once("../assets/include/footer.inc.php");

    session_start();

    $company_id = $_REQUEST["company_id"];
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
            <h2 class="bedrift-tittel">Egde AS</h2>
            <h3 class="bedrift-slogan">Vi forener mennesker og teknologi.</h3>
            <p class="bedrift-setning">Sammen utvider vi horisonten for hvordan teknologi kan bidra til at virksomheter lykkes.</p>
        </div>

        <div class="Bedrift-knapper">
            <div class="om-og-kontakt-knapp">
            <a class="a_om_oss" href="https://egde.no/om-oss/">Om Oss</a>
            <a class="a-kontakt-oss" href="https://egde.no/kontakt/">Se ansatte</a>
            </div>
            <div class="veibeskrivelse-knapp">
            <a class="a_veibeskrivelse" href="company_map.php?company_id=<?=$company_id?>">Veibeskrivelse på kart</a>
            </div>
            </div>
        </div>
</body>
</head>
</html>
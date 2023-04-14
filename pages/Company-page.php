<?php
    require_once("../assets/include/header.inc.php");
    require_once("../assets/include/db.inc.php");

    session_start();
    $_SESSION["site"]["last_visited"] = $_SERVER["REQUEST_URI"];

    $company_id = $_REQUEST["company_id"];
    if($location = get_location($company_id)) {
        $address = $location->address;
        $city = $location->city;
        $zip = $location->zip;
    } else {
        $failed = "<h4><span style='color:red'>
        Noe gikk galt, fant ikke bedriften i systemet.
        </span></h4>";
    }

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
    <?php banner(false) ?>
    <div class="Bedrift-siden">
        <div class="Bedrift-bilde">
            <img class="Bedrift-bilde-styling" src="../Companies/Company1/Egde_Grimstad.png" alt="Bilde av bedriften">
        </div>

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
            <a class="a_veibeskrivelse" href="https://www.google.com/maps/place/Egde+Consulting+AS/@58.1401491,7.9944956,15.93z/data=!4m6!3m5!1s0x463802612c6a6bc5:0xec7da6512d9d2ce0!8m2!3d58.1409102!4d7.9948404!16s%2Fg%2F11c7t422qw">Veibeskrivelse på kart</a>
            </div>
            </div>
        </div>
        <?php
        // Build API address
        $full_address = "$address $zip $city";
        $url = "https://ws.geonorge.no/adresser/v1/sok?fuzzy=true&sok=";
        $url .= str_replace(" ", "%20", $full_address);
        $url .= "&treffPerSide=1&asciiKompatibel=true";

        // Get result from Geonorges API
        $ch = curl_init();
        $param = [CURLOPT_URL => $url, CURLOPT_RETURNTRANSFER => true];
        curl_setopt_array($ch, $param);
        $result = curl_exec($ch);
        curl_close($ch);
        $searchResult = json_decode($result, true);

        // Utilzie longitude and latitude from API result
        if(isset($searchResult["adresser"][0])) {
            $lat = $searchResult["adresser"][0]["representasjonspunkt"]["lat"];
            $lon = $searchResult["adresser"][0]["representasjonspunkt"]["lon"];
            // Display Google Maps on web-page using an iframe
            echo '<iframe class="map" src="https://maps.google.com/maps?q=' . $lat . ', ' . $lon . '&z=16&output=embed" width="50%" height="500px" frameborder="0" style="border:0"></iframe>';
        } else {
            echo "Kunne ikke generere kart for adressen.";
        }
    ?>
</body>
</head>
</html>

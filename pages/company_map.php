<?php
    require_once("../assets/include/header.inc.php");
    require_once("../assets/include/footer.inc.php");
    require_once("../assets/include/db.inc.php");
    require_once("../assets/include/util.inc.php");

    session_start();
    $user_id = $_SESSION["user"]["last_visited"]; 
    $company_id = $_REQUEST["company_id"];

    if($location = get_location($company_id)) {
        $_SESSION["site"]["last_visited"] = $_SERVER["REQUEST_URI"];

        $address = $location->company_address;
        $city = $location->company_city;
        $zip = $location->company_zip;
    } else {
        show_alert("Noe gikk galt, fant ikke lokasjonen til bedriften.");
    }
?>
<!DOCTYPE html>
<html lang="no">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/styles/styles.css">
    <title>Kart</title>
</head>
<body>
    <?php banner(); ?>
    <?php
        // Build API address
        $full_address = "$address $zip $city";
        $full_address = html_entity_decode($full_address);
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
</html>
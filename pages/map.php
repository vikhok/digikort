<?php
    require_once("../assets/include/header.inc.php");
    require_once("../assets/include/footer.inc.php");
    require_once("../assets/include/db.inc.php");

    session_start();
    $_SESSION["site"]["last_visited"] = $_SERVER["REQUEST_URI"];

    $company_id = $_GET["company_id"];
    if($location = get_location($company_id)) {
        $address = $location->address;
        $city = $location->city;
        $zip = $location->zip;
    } else {
        $failed = "<h4><span style='color:red'>
        Noe gikk galt, fant ikke bedriften i systemet.
        </span></h4>";
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/styles/styles.css">
    <title>Document</title>
</head>
<body>
    <?php banner(false) ?>
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
    <?php footer("company") ?>
</body>
</html>
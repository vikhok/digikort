<?php
    require_once("../assets/include/header.inc.php");
    require_once("../assets/include/db.inc.php");
    require_once("../assets/include/util.inc.php");

    session_start();
    $user_id = $_SESSION["user"]["user_id"];

    if($_SESSION["user"]["logged_in"]) {
        $_SESSION["site"]["last_visited"] = $_SERVER["REQUEST_URI"];
    } else {
        header("Location: utility/error.php?error=401");
        exit();
    }

    // Check if user is already in a company:
    if(!$user_company = get_user_company($user_id)) {
        if(isset($_REQUEST["submit_company"])) {
            $company_name = clean($_REQUEST["company_name"]);
            $access_code = clean($_REQUEST["access_code"]);
            if($company_id = join_company($company_name, $access_code, $user_id, false)) {
                $_SESSION["user"]["company_id"] = $company_id;
                $_SESSION["business_card"]["company_id"] = $company_id;
                header("Location: company.php?company_id=$company_id");
                exit();
            } else {
                show_alert("Noe gikk galt, fikk ikke til å bli med i bedriften.");
            }
        }
    } else {
        // Redirect if user is already in a company:
        $company_id = $user_company->company_id;
        header("Location: company.php?company_id=$company_id");
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	<script src="../assets/include/javascript/ajax.js"></script>
    <script src="../assets/include/javascript/prompt.js" type="text/javascript"></script>
    <script>
        ajax_search("utility/all_companies.php");
    </script>
    <title>Bli med i en bedrift</title>
</head>
<body>
    <?php banner(); ?>
    <div class="bli_med_bedrift">
        <form class="bli_med_bedrift_form" action="" method="POST">
            <div class="h1_bli_med_bedrift">
                <h1>Du er ikke oppført i en bedrift.</h1>
            </div>
            <div class="h1_bli_med_bedrift_2">
                <h1>Fyll inn navnet på bedriften eller opprett en ny bedrift.</h1>
            </div>
            <div class="bedrift_navn">
                <label for="bedrift_navn">Bedriftsnavn:</label>
                <input type="text" name="company_name" id="searchInput" placeholder="Søk etter en bedrift..." list="suggestions" required 
                    oninvalid="this.setCustomValidity('Velg en bedrift fra søkerfeltet.')"
                    oninput="this.setCustomValidity('')">
                <label for="access_code">Tilgangskode:</label>
                <input type="text" name="access_code" placeholder="Tilgangskode" required 
                    oninvalid="this.setCustomValidity('Obligatorisk felt, fyll inn sikkerhetskoden til bedriften.')"
                    oninput="this.setCustomValidity('')">
                <datalist id="suggestions"></datalist>
            </div>
            <div class="bli_med_bedrift_knapp">    
                <button type="submit" name="submit_company">Bli med i bedrift</button>
            </div>
        </form>
        <div class="opprett_ny_bedrift_knapp">
            <a class="a_ny_bedrift" href="company_create.php">Opprett bedrift</a>
        </div>
    </div>
</body>
</html>

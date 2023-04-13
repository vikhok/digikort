<?php
    require_once("../assets/include/header.inc.php");
    require_once("../assets/include/db.inc.php");

    session_start();
    $_SESSION["site"]["last_visited"] = $_SERVER["REQUEST_URI"];

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
    <script>
        ajax_search("all_companies.php");
    </script>
    <title>Bli med i en bedrift</title>
</head>
<body>
    <?php banner(true, true)?>
    <div class="bli_med_bedrift">

<form class="bli_med_bedrift_form" action="bli_med_bedrift.php" method="POST">

    <div class="h1_bli_med_bedrift">
        <h1>Du er ikke oppført i en bedrift.</h1>
    </div>
    <div class="h1_bli_med_bedrift_2">
        <h1>Fyll inn navnet på bedriften eller opprett en ny bedrift.</h1>
    </div>

    <div class="bedrift_navn">
        <form action="#" method="POST">
            <label for="bedrift_navn">Bedriftsnavn:</label>
            <input name="company" type="text" id="searchInput" name="bedrift_navn" placeholder="Søk etter en bedrift..." list="suggestions">
            <datalist id="suggestions"></datalist>
        </form>
    </div>

    <div class="bli_med_bedrift_knapp">    
        <button type="submit">Bli med</button>
    </div>


    <div class="opprett_ny_bedrift_knapp">
        <a class="a_ny_bedrift" href="https://youtu.be/FDEiOHUxhOk">Opprett bedrift</a>
    </div>

    </div>

</form>

</body>
</html>

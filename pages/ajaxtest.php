<?php
    require_once("../assets/include/header.inc.php");
    require_once("../assets/include/footer.inc.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/styles/styles.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	<script src="../assets/include/javascript/ajax.js"></script>
    <script>
        ajax_search("utility/all_users.php");
    </script>
    <title>Søk blant brukere</title>
</head>
<body>
    <?php banner(); ?>
    <div class="ajax-search-field">
        <h1>Brukere:</h1>
        <form method="post" action="">
            <input name="company" type="text" id="searchInput" placeholder="Søk blant brukere..." list="suggestions">
            <datalist id="suggestions"></datalist>
        </form>
    </div>
</body>
</html>
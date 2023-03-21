<?php
    require_once("../assets/include/header.inc.php");
    require_once("../assets/include/footer.inc.php");
    require_once("../assets/include/db.inc.php");

    session_start();
    $_SESSION["site"]["last_visited"] = $_SERVER["REQUEST_URI"];

    $company_id = $_GET["company_id"];
    if($company = get_location($company_id)) {
        $name = $user->first_name . " " . $user->last_name;
        $job_title = $user->job_title;
        $company = $user->company_name;
        $email = $user->email;
        $phone = $user->phone;
    } else {
        $failed = "<h4><span style='color:red'>
        Noe gikk galt, fant ikke bruker i systemet.
        </span></h4>";
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
</body>
</html>
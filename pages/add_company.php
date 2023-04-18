<?php
    require_once("../assets/include/header.inc.php");
    require_once("../assets/include/db.inc.php");

    session_start();

    $user_id = $_SESSION["user"]["user_id"];
    if(isset($_REQUEST["submit"])){
        $company_name = ($_REQUEST["company_name"]);
        $description = ($_REQUEST["description"]);
        $company_email = ($_REQUEST["email"]);
        $web_url = ($_REQUEST["web_url"]);
        if(add_company($company_name, $company_email, $description, $web_url)) {
            $status = "<h4><span style='color:green'>
                Bedriften ble opprettet.
                </span></h4>";
        } else {
        $status = "<h4><span style='color:red'>
                Noe gikk galt, endringer ble ikke foretatt.
                </span></h4>";
    }
}

?>
<!DOCTYPE html>
<html lang="no">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/styles/styles.css">
    <title>Opprett bedrift</title>
</head>
<body>

<?php banner($user_id, false) ?>
    <div class="rediger_profil">
            <form class="addcompany_form" action="#" method="POST" enctype="multipart/form-data">

            <div class="redpro_input_text">
                <label class="redpro_label" for="company_name">Navn på bedrift</label>
                <input type="text" id="company_name" name="company_name" placeholder="Navn på bedrift" required><br><br>

                <label class="redpro_label" for="email">Bedriftens e-postadresse</label>
                <input type="text" id="email" name="email" placeholder="Bedriftens e-postadresse" required><br><br>

                <label class="redpro_label" for="description">Beskrivelse av bedriften</label>
                <textarea type="text" id="description" name="description" placeholder="Beskriv bedriften" required></textarea> <br><br>

            <div class="addcompany_email">
                <label class="redpro_label" for="email">Nettside til bedriften</label>
                <input type="text" id="web_url" name="web_url" placeholder="Legg inn nettsiden til bedriften" required><br><br>
            </div>

            <div class="addcompany_submit">    
                <button type="submit" name="submit">Opprett bedrift</button>
            </div>
        </form>
        <?php
            if(isset($status)) {
                echo $status;
            }
        ?>
    </div>
</body>
</html>
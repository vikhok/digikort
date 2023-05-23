<?php
    require_once("../assets/include/header.inc.php");
    require_once("../assets/include/db.inc.php");
    require_once("../assets/include/util.inc.php");

    session_start();
    $company_id = $_REQUEST["company_id"];
    //$admin = verify_admin_role($company_id, $_SESSION["user"]["user_id"]);

    if($employees = get_all_employees($company_id)) {
        $_SESSION["site"]["last_visited"] = $_SERVER["REQUEST_URI"];
    } else {
        header("Location: utility/error.php?error=404");
        exit();
    }

    if(isset($_REQUEST["make_admin"])) {
        $user_id = $_REQUEST["user_id"];
        if(give_admin_role($company_id, $user_id)) {
            show_alert("Bruker har fått rollen som administrator.");
        } else {
            show_alert("Noe gikk galt, fikk ikke endret rettighetene til brukeren.");
        }
    }

    if(isset($_REQUEST["remove_member"])) {
        $user_id = $_REQUEST["user_id"];
        if(leave_company($user_id, $company_id)) {
            show_alert("Bruker har blitt fjernet fra bedriften.");
        } else {
            show_alert("Noe gikk galt, fikk ikke til å fjerne bruker fra bedriften.");
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
    <script src="../assets/include/javascript/prompt.js" type="text/javascript"></script>
    <title>Bedriftens medlemmer</title>
</head>
<body>
    <?php banner(); ?>
    <main>
        <h1 class="members_header">Ansatte</h1>
        <?php if($employees):?>
            <section class="members-section">
                <?php foreach($employees as $employee): ?>
                    <form action="" method="post">
                        <div class="employees_wrapper">
                            <a class="employee" href="index.php?user_id=<?=$employee["user_id"]?>">
                                <div class="employee_picture">
                                    <?php
                                        $user_id = $employee["user_id"];
                                        if($user_id) {
                                            $folder = md5("user." . $user_id);
                                            $dir = "../profiles/" . $folder . "/picture.png";
                                            if(!file_exists($dir)) {
                                                $dir = "../profiles/" . $folder . "/picture.jpg";
                                                if(!file_exists($dir)){
                                                    $dir = "../profiles/stockprofile/picture.png";
                                                }
                                            }
                                            echo "<img class='profile_picture_small' src='$dir' alt='Profile picture'>";
                                        }
                                    ?>
                                </div>
                                <div class="employee_information">
                                    <h4><?= $employee["first_name"] . " " . $employee["last_name"] ?></h4>
                                    <p><?= $employee ["job_title"] ?></p>
                                    <p><?= $employee["email"] ?></p>
                                </div>
                            </a>
                            <?php if(isset($_SESSION["user"]["logged_in"]) && verify_admin_role($company_id, $_SESSION["user"]["user_id"]) && !verify_admin_role($company_id, $user_id)): ?>
                                <div class="blue_button">
                                    <input type="hidden" name="user_id" value="<?= $user_id ?>">
                                    <button type="submit" class="member-make-admin" name="make_admin" onclick="confirmation('Er du sikker på at du ønsker å gi rettigheter til <?=$employee['first_name']?>?');">Gi rettigheter</button>
                                    <button type="submit" class="member-delete" name="remove_member" onclick="confirmation('Er du sikker på at du ønsker å fjerne <?=$employee['first_name']?> fra bedriften?');">Fjern medlem</button>
                                </div>
                            <?php endif; ?>
                        </div>
                    </form>
                    <br>
                <?php endforeach; ?>
            </section>
        <?php endif; ?>
    </main>
</body>
</html>
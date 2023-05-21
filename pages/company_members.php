<?php
    require_once("../assets/include/header.inc.php");
    require_once("../assets/include/db.inc.php");

    session_start();
    $company_id = $_REQUEST["company_id"];

    if(!$employees = get_all_employees($company_id)) {
        echo "This is minging";
    }

    if(isset($_REQUEST["member-delete"])) {
        if(leave_company($user_id, $company_id)) {
            $status = "<h4><span style='color:green'>
                Bruker har blitt fjernet fra bedriften.
                </span></h4>";
        } else {
            $status = "<h4><span style='color:red'>
                Noe gikk galt, fikk ikke til å fjerne bruker fra bedriften.
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
    <title>Administrer medlemmer</title>
</head>
<body>
    <?php banner(); ?>
    <main>
        <h1 class="members_header">Ansatte</h1>
        <?php if($employees):?>
            <section class="members-section">
                <?php foreach ($employees as $employee): ?>
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
                            <div class="admin_buttons">
                                <button type="submit" class="member-make-admin">Gi rettigheter</button>
                                <button type="submit" class="member-delete" name="member-delete">Slett</button>
                            </div>
                        </div>
                    </form>
                <?php endforeach; ?>
            </section>
        <?php endif ?>
    </main>
</body>
</html>
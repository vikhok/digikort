<?php
    require_once("../assets/include/header.inc.php");
    require_once("../assets/include/db.inc.php");

    session_start();
   $company_id = $_REQUEST["company_id"];

    $employees = get_all_employees(1);

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
    
    <?php banner() ?>
    <main>
        <div class="admin-bilde">
            <img class="admin-bedrift-bilde" src="../Companies/Company1/Egde_Grimstad.png" alt="Bilde av bedriften">
        </div>
        <br>
        <br>
        <h1 class="admin-header">Ansatte</h1>
        <br>
        <br>
        <?php if($employees):?>
            <section class="admin-section">
                <?php foreach ($employees as $employee): ?>
                    <form action="" inpuAt type="hidden" name="user_id" value="<?=$user_id?>">
                        <div class="Ansatt-wrapper">
                            <div class="Ansatte">
                                <a class="Ansatt-tekst" href="index.php?user_id=<?=$employee["user_id"]?>">
                                    <h4><?= $employee["first_name"]. " ". $employee["last_name"]?></h4>
                                    <p><?= $employee ["job_title"]?></p>
                                    <p class="ansatt-email"><?= $employee ["email"]?></p>
                                </a>
                            </div>
                                <div class="admin-buttons">
                                    <button type="submit" class="member-delete" name="member-delete">Slett</button>
                                    <button type="submit" class="member-make-admin">Gi rettigheter</button>
                               </div>
                        </div>
                    </form>
                <?php endforeach; ?>
            </section>
        <?php else: ?>
            <p>Finnes ingen ansatte i bedriften</p>
        <?php endif ?>
    </main>
</body>
</html>
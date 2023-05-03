<?php function banner($profile_picture = false) { ?>
    <header>
        <?php
            if(isset($_SESSION["user"]["user_id"])) $user_id = $_SESSION["user"]["user_id"];
            if(isset($_SESSION["user"]["company_id"])) $company_id = $_SESSION["user"]["company_id"]; 

            // Define and display profile picture:
            if($profile_picture) {
                $folder = md5("user." . $user_id);
                $dir = "../profiles/" . $folder . "/picture.png";
                if(!file_exists($dir)) {
                    $dir = "../profiles/" . $folder . "/picture.jpg";
                    if(!file_exists($dir)){
                        $dir = "../profiles/stockprofile/picture.png";
                    }
                }
                echo "<img class='profile_picture' src='$dir' alt='Profile picture'>";
            }
        ?>
        <nav class="navbar">
            <ul class="nav-menu">
                <?php // Check whether user is logged in or not:
                    if(isset($_SESSION["user"]["logged_in"]) && $_SESSION['user']['logged_in'] == true): ?>
                        <li class="nav-item"><a href="index.php?user_id=<?=$_SESSION['user']['user_id']?>" class="nav-link">Mitt visittkort</a></li>
                        <li class="nav-item"><a href="profile_update.php" class="nav-link">Rediger profil</a></li>
                        <li class="nav-item"><a href="notes.php" class="nav-link">Mine notater</a></li>
                        <?php // Check whether user belong in a company:
                        if(isset($company_id)): ?>
                            <li class="nav-item"><a href="company.php?company_id=<?=$company_id?>" class="nav-link">Bedrift</a></li>
                        <?php else: ?>
                            <li class="nav-item"><a href="company_join.php" class="nav-link">Bli med i bedrift</a></li>
                        <?php endif; ?>
                        <li class="nav-item"><a href="utility/logout.php" class="nav-link">Logg ut</a></li>
                <?php else: ?>
                    <li class="nav-item"><a href="index.php?user_id=<?=$_SESSION['user']['last_visited']?>" class="nav-link">Visittkort</a></li>
                    <?php // Check whether user belong in a company:
                    if(isset($company_id)): ?>
                        <li class="nav-item"><a href="company.php?company_id=<?=$company_id?>" class="nav-link">Bedrift</a></li>
                    <?php endif; ?>
                    <li class="nav-item"><a href="utility/login.php" class="nav-link">Logg inn</a></li>
                <?php endif; ?>
            </ul>
            <div class="hamburger">
                <span class="bar"></span>
                <span class="bar"></span>
                <span class="bar"></span>
            </div>
        </nav>
    </header>
    <script src="../assets/include/javascript/menu.js"></script>
<?php } ?>
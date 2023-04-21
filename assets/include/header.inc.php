<!--
    Denne funksjonen blir brukt til å importere HTML elementer for header/navbar.
    Importer denne der header/navbar trengs, så ungår vi code dupliaction.

    Importeres slik: require_once("denne filen");
    Kalles på i php: banner() med parameter true eller false, basert på om profilbilde skal vises.
-->
<?php function banner($user_id = false, $company_id = false) { ?>
    <header>
        <?php if($user_id) {
            // Define and display profile picture:
            $folder = md5("user." . $user_id);
            $dir = "../profiles/" . $folder . "/profile_picture.png";
            if(!file_exists($dir)) {
                $dir = "../profiles/stockprofile/profile_picture.png";
            }
            echo "<img class='profile_picture' src='$dir' alt='Profile picture'>";
        }
        ?>
        <nav class="navbar">
            <ul class="nav-menu">
                <?php // Check whether user is logged in or not:
                    if(isset($_SESSION["user"]["logged_in"]) && $_SESSION['user']['logged_in'] == true) { ?>
                    <li class="nav-item"><a href="index.php?user_id=<?=$_SESSION['user']['user_id']?>" class="nav-link">Mitt visittkort</a></li>
                    <li class="nav-item"><a href="my_notes.php" class="nav-link">Mine notater</a></li>
                    <li class="nav-item"><a href="rediger_profil.php" class="nav-link">Rediger profil</a></li>
                    <?php // Check whether user belong in a company:
                    if($company_id) { ?>
                        <li class="nav-item"><a href="company-page.php?company_id=<?=$company_id?>" class="nav-link">Bedrift</a></li>
                    <?php } else { ?>
                        <li class="nav-item"><a href="company-join.php" class="nav-link">Bli med i bedrift</a></li>
                    <?php } ?>
                    <li class="nav-item"><a href="utility/logout.php" class="nav-link">Logg ut</a></li>
                <?php } else { ?>
                    <li class="nav-item"><a href="index.php?user_id=<?=$_SESSION['user']['last_visited']?>" class="nav-link">Visittkort</a></li>
                    <?php // Check whether user belong in a company:
                    if($company_id) { ?>
                        <li class="nav-item"><a href="company-page.php?company_id=<?=$company_id?>" class="nav-link">Bedrift</a></li>
                    <?php } ?>
                    <li class="nav-item"><a href="utility/login.php" class="nav-link">Logg inn</a></li>
                <?php } ?>
            </ul>
            <div class="hamburger">
                <span class="bar"></span>
                <span class="bar"></span>
                <span class="bar"></span>
            </div>
        </nav>
    </header>
    <script src="../assets/include/js/menu.js"></script>
<?php } ?>
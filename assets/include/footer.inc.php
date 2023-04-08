<!--
    Denne funksjonen blir brukt til å importere HTML elementer for footer.
    Importer denne der footer trengs, så ungår vi code dupliaction.

    Importeres slik: require_once("denne filen");
    Kalles på i php: footer() med parameter "profile" eller "company" for å få frem sosiale-media lenker.
-->
<?php
require_once("../assets/include/db.inc.php");
    function footer($option = null) { ?>
    <footer>
        <nav class="footer">
            <ul class="footer-menu">
                <?php
                $user_id = $_REQUEST["user_id"];
                if($user_social = get_user_socialmedia($user_id)) {
                    $linkedin = $user_social->linkedin;
                    $github = $user_social->github;
                    $instagram = $user_social->instagram;
                    } ?>
                    <li class="footer-item"><a href="<?=$instagram?>" class="nav-link"><img src="../assets/include/icons/instagram.svg"></a></li>
                    <li class="footer-item"><a href="<?=$linkedin?>" class="nav-link"><img src="../assets/include/icons/linkedin.svg"></a></li>
                    <li class="footer-item"><a href="<?=$github?>" class="nav-link"><img src="../assets/include/icons/github.svg"></a></li>
                <?php /* ---GJENSTÅR Å LAGE EN FUNKSJON SOM SJEKKER COMPANY_ID OPP MOT USER_ID---- 
                    } elseif($option == "company") { ?>
                    <li class="footer-item"><a href="#" class="nav-link"><img src="../assets/include/icons/instagram.svg"></a></li>
                    <li class="footer-item"><a href="#" class="nav-link"><img src="../assets/include/icons/linkedin.svg"></a></li>
                    <li class="footer-item"><a href="#" class="nav-link"><img src="../assets/include/icons/github.svg"></a></li>
                <?php } */  ?>
            </ul>
        </nav>
    </footer>
<?php } ?>
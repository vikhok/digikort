<!--
    Denne funksjonen blir brukt til å importere HTML elementer for footer.
    Importer denne der footer trengs, så ungår vi code dupliaction.

    Importeres slik: require_once("denne filen");
    Kalles på i php: footer() med parameter "profile" eller "company" for å få frem sosiale-media lenker.
-->
<?php
    require_once("../assets/include/db.inc.php");

    function footer($id = null, $option = null) {
        if($option == "user" && $social = get_user_socialmedia($id)) {
            $linkedin = $social->linkedin ?? false;
            $github = $social->github ?? false;
            $instagram = $social->instagram ?? false;
        } elseif($option == "company" && $social = get_company_socialmedia($id)) {
            $linkedin = $social->linkedin ?? false;
            $github = $social->github ?? false;
            $instagram = $social->instagram ?? false;
        }

        if($social): ?>
            <footer>
                <nav class="footer">
                    <ul class="footer-menu">
                        <?php if($instagram): ?>
                            <li class="footer-item"><a href="<?=$linkedin?>" class="nav-link"><img src="../assets/include/icons/instagram.svg"></a></li>
                        <?php endif; if($linkedin): ?>
                            <li class="footer-item"><a href="<?=$linkedin?>" class="nav-link"><img src="../assets/include/icons/linkedin.svg"></a></li>
                        <?php endif; if($github): ?>
                            <li class="footer-item"><a href="<?=$github?>" class="nav-link"><img src="../assets/include/icons/github.svg"></a></li>
                        <?php endif; ?>
                    </ul>
                </nav>
            </footer>
        <?php endif; ?> 
<?php } ?>
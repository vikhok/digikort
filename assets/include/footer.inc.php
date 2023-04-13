<!--
    Denne funksjonen blir brukt til å importere HTML elementer for footer.
    Importer denne der footer trengs, så ungår vi code dupliaction.

    Importeres slik: require_once("denne filen");
    Kalles på i php: footer() med parameter "profile" eller "company" for å få frem sosiale-media lenker.
-->
<?php function footer($option = null) { ?>
    <footer>
        <nav class="footer">
            <ul class="footer-menu">
                <?php if($option == "profile") { ?>
                    <li class="footer-item"><a href="#" class="nav-link"><img src="../assets/include/icons/instagram.svg"></a></li>
                    <li class="footer-item"><a href="#" class="nav-link"><img src="../assets/include/icons/linkedin.svg"></a></li>
                    <li class="footer-item"><a href="#" class="nav-link"><img src="../assets/include/icons/github.svg"></a></li>
                <?php } elseif($option == "company") { ?>
                    <li class="footer-item"><a href="#" class="nav-link"><img src="../assets/include/icons/instagram.svg"></a></li>
                    <li class="footer-item"><a href="#" class="nav-link"><img src="../assets/include/icons/linkedin.svg"></a></li>
                    <li class="footer-item"><a href="#" class="nav-link"><img src="../assets/include/icons/github.svg"></a></li>
                <?php } ?>
            </ul>
        </nav>
    </footer>
<?php } ?>
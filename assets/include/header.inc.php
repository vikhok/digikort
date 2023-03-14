<?php function banner($profile_picture = false) { ?>
    <header>
        <?php if($profile_picture) { ?>
            <img class="profile_picture" src="/digikort/profiles/profile1/profile_pic.png" alt="Profile picture">
        <?php } ?>
            <nav>
                <ul class="nav__links">
                    <?php if(isset($SESSION)/* && $ISLOGGEDIN == true */) { ?>
                        <li><a href="#">Visittkort</a></li>
                        <li><a href="#">Rediger profil</a></li>
                        <li><a href="#">Bedrift</a></li>
                        <li><a href="#">Logg ut</a></li>
                    <?php } else { ?>
                        <li><a href="#">Visittkort</a></li>
                        <li><a href="#">Bedrift</a></li>
                        <li><a href="#">Logg inn</a></li>
                    <?php } ?>
                </ul>
            </nav>
        </header>
<?php } ?>
<?php function banner($profile_picture = false) { ?>
    <?php if($profile_picture) { ?>
        <header>
            <img class="profile_picture" src="/digikort/profiles/profile1/profile_pic.png" alt="Profile picture">
            <nav>
                <ul class="nav__links">
                    <li><a href="#">Visittkort</a></li>
                    <li><a href="#">Rediger profil</a></li>
                    <li><a href="#">Bedrift</a></li>
                    <li><a href="#">Log ut</a></li>
                </ul>
            </nav>
        </header>
    <?php } ?>
<?php } ?>
<?php function banner($profile_picture = false) { ?>
    <header>
        <?php if($profile_picture) { ?>
            <img class="profile_picture" src="/digikort/profiles/profile1/profile_pic.png" alt="Profile picture">
        <?php } ?>
            <nav class="navbar">
                <ul class="nav-menu">
                    <?php if(isset($SESSION)/* && $ISLOGGEDIN == true */) { ?>
                        <li class="nav-item"><a href="#" class="nav-link">Visittkort</a></li>
                        <li class="nav-item"><a href="#" class="nav-link">Rediger profil</a></li>
                        <li class="nav-item"><a href="#" class="nav-link">Bedrift</a></li>
                        <li class="nav-item"><a href="#" class="nav-link">Logg ut</a></li>
                    <?php } else { ?>
                        <li class="nav-item"><a href="#" class="nav-link">Visittkort</a></li>
                        <li class="nav-item"><a href="#" class="nav-link">Bedrift</a></li>
                        <li class="nav-item"><a href="#" class="nav-link">Logg inn</a></li>
                    <?php } ?>
                </ul>
                <div class="hamburger">
                    <span class="bar"></span>
                    <span class="bar"></span>
                    <span class="bar"></span>
                </div>
            </nav>
        </header>
        <script src="/digikort/assets/include/menu.js"></script>
<?php } ?>
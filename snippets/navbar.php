<?php
    require_once("init.php");
?>

<nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
    <div class="container">
        <a class="navbar-brand js-scroll-trigger" href="<?php echo Database::INDEX; ?>"><img src="img/logo.png" alt="">  </a>
        <a class="navbar-brand js-scroll-trigger" href="<?php echo Database::INDEX; ?>">MeetAmour</a> 
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            Menu
            <i class="fas fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
                <?php
                if (isset($_SESSION[User::LOGGED_IN]) && $_SESSION[User::LOGGED_IN] == 1) {

                    if ($_SESSION[User::IS_ADMIN] == 1) { ?>
                        <li class="nav-item">
                            <a class="nav-link js-scroll-trigger" href="<?php echo Database::ADMIN_DASHBOARD; ?>">Admin Dashboard</a>
                        </li>
                    <?php
                    }
                    ?>

                    <li class="nav-item">
                        <a class="nav-link js-scroll-trigger" href="<?php echo Database::SEARCH_PROFILE; ?>">Search</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link js-scroll-trigger" href="<?php echo Database::SUGGEST_MATCH; ?>">Find Matches</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link js-scroll-trigger" href="<?php echo Database::VIEW_PROFILE; ?>">My Profile</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link js-scroll-trigger" href="<?php echo Database::LOGOUT; ?>">Log Out</a>
                    </li>
                    <?php include("notification_dropdown.php");
                } else { ?>
                    <li class="nav-item">
                        <a class="nav-link js-scroll-trigger" href="<?php echo Database::ABOUT_US; ?>">About Us</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link js-scroll-trigger" href="<?php echo Database::CONTACT_US; ?>">Contact</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link js-scroll-trigger" href="<?php echo Database::REGISTER; ?>">Register</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link js-scroll-trigger" href="<?php echo Database::LOGIN; ?>">Login</a>
                    </li>
                
                    <?php
                }
                
                ?>

            </ul>
        </div>
    </div>
</nav>
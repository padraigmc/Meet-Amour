<?php
    require_once("init.php");

    $databaseConnection_navbar = Database::connect();
    if ($notifications = Notification::get_unseen_user_notifications($databaseConnection_navbar, 3)) {
        $numUnseenNotifications = sizeof($notifications);
    } else {
        $numUnseenNotifications = 0;
    }

    $databaseConnection_navbar->close();

?>


<li class="nav-item dropdown">
    <a class="nav-link text-light" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fa fa-bell"><?php echo ($notifications) ? $numUnseenNotifications : ""; ?></i>
    </a>
    <ul class="dropdown-menu" id="notification">
        <li class="head text-light bg-primary">
            <div class="row">
                <div class="col-lg-12">
                    <span>Notifications (<?php echo $numUnseenNotifications; ?>)</span>
                </div>
            </div>
        </li>
        <?php if ($notifications) {
            foreach ($notifications as $key => $value) {
                $mark_as_seen_path = Database::MARK_NOTIFICATION_AS_SEEN;
                $mark_as_seen_path .=  "?" . Notification::FROM_USER_ID . "=" . $value[Notification::FROM_USER_ID];
                $mark_as_seen_path .=  "&" . Notification::REDIRECT_PAGE . "=" . $_SERVER['PHP_SELF']; ?>
                <li class="notification-box <?php echo ($key % 2 == 1) ? "bg-gray" : ""; ?>">
                    <div class="row"> 
                        <div class="offset-lg-1"></div>
                        <div class="col-lg-8">
                            <strong class="text-primary">
                                <a href="<?php echo Database::VIEW_PROFILE . "?" . User::USER_ID . "=" . $value[Notification::FROM_USER_ID] ; ?>"><?php echo $value[User::NAME]; ?></a>
                            </strong>
                            <div>
                                <?php echo $value[Notification::MESSAGE]; ?>
                            </div>
                            <small class="text-info"><?php echo $value[Notification::DATE_SENT]; ?></small>
                        </div>
                        <div class="col-lg-3">
                            <a href="<?php echo $mark_as_seen_path; ?>">Mark as read</a>
                        </div>     
                    </div>
                </li>
            <?php }
        } else {
            ?>
            <li class="notification-box">
                <div class="row"> 
                    <h6 class="mx-auto">Nothing to see here...</h6>
                </div>
            </li>
            <?php
        } ?>
        <li class="footer bg-primary text-center">
            <a href="<?php echo Database::NOTIFICATIONS; ?>" class="text-light">View All</a>
        </li>
    </ul>
</li>
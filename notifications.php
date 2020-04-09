<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" href="img/logoalt.png">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>MeetAmour - Revolutionary Dating Website</title>

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom fonts for this template -->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="vendor/simple-line-icons/css/simple-line-icons.css">
    <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Catamaran:100,200,300,400,500,600,700,800,900" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Muli" rel="stylesheet">

    <!-- Plugin CSS -->
    <link rel="stylesheet" href="vendor/device-mockups/device-mockups.min.css">

    <!-- Custom styles for this template -->
    <link href="css/new-age.min.css" rel="stylesheet">
    <link href="css/main.css" rel="stylesheet">

    <style>
        #footer {
            position: absolute;
            bottom: 0;
            width: 100%;
            padding-top: .5rem;
            padding-bottom: .5rem;
        }
    </style>

</head>

<body id="page-top">
		<?php

			require_once("init.php");
            $conn = Database::connect();

            $mark_all_as_seen_path = Database::MARK_ALL_NOTIFICATIONS_AS_SEEN;
            $mark_all_as_seen_path .=  "?" . Notification::REDIRECT_PAGE . "=" . $_SERVER['PHP_SELF'];
            
            $allNotifications = Notification::get_all_notifications($conn, 10);

			if ($unseenNotifications = Notification::get_unseen_user_notifications($conn, 3)) {
				$numUnseenNotifications = sizeof($unseenNotifications);
			} else {
				$numUnseenNotifications = 0;
			}

		?>

	<!-- Navigation -->
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
				<li class="nav-item dropdown">
					<a class="nav-link text-light" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<i class="fa fa-bell"><?php echo ($unseenNotifications) ? $numUnseenNotifications : ""; ?></i>
					</a>
					<ul class="dropdown-menu">
						<li class="head text-light bg-primary">
							<div class="row">
								<div class="col-lg-12">
									<span>Notifications (<?php echo $numUnseenNotifications; ?>)</span>
								</div>
							</div>
						</li>
						<?php
							if ($unseenNotifications) {
								foreach ($unseenNotifications as $key => $value) {
									$mark_as_seen_path = Database::MARK_NOTIFICATION_AS_SEEN;
									$mark_as_seen_path .=  "?" . Notification::FROM_USER_ID . "=" . $value[Notification::FROM_USER_ID];
									$mark_as_seen_path .=  "&" . Notification::REDIRECT_PAGE . "=" . $_SERVER['PHP_SELF'];
						?>
									<li class="notification-box <?php echo ($key % 2 == 1) ? "bg-gray" : ""; ?>">
										<div class="row"> 
											<div class="offset-lg-1"></div>
											<div class="col-lg-8">
												<strong class="text-primary">
													<a href="<?php echo Database::VIEW_PROFILE . "?username=" . $value[Notification::FROM_USERNAME] ; ?>"><?php echo $value[User::NAME]; ?></a>
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
						<?php
								}
							} else {
								?>
								<li class="notification-box">
									<div class="row"> 
										<h6 class="mx-auto">Nothing to see here...</h6>
									</div>
								</li>
								<?php
							}
						?>
						<li class="footer bg-primary text-center">
							<a href="#" class="text-light">View All</a>
						</li>
					</ul>
				</li>
			</ul>
		</div>
		</div>
	</nav>

	</br>
	</br>
	</br>
	</br>
	</br>

	<div class="container">

        <?php
            // if an error was found, display it and nothing else
            if (!empty($_SESSION[User::ERROR])) {
                echo "<h1>" . $_SESSION[User::ERROR][0] . "</h1></div>";
                $conn->close();
                exit();
            }
        ?>

        <div class="row bg-danger">
            <div class="col-lg-12">
                <span>Notifications</span>
                <a href="<?php echo $mark_all_as_seen_path ?>" class="float-right text-light">Mark all as read</a>
            </div>
        </div>
        <?php
            if ($allNotifications) {
                foreach ($allNotifications as $key => $value) {
                    $mark_as_seen_path = Database::MARK_NOTIFICATION_AS_SEEN;
                    $mark_as_seen_path .=  "?" . Notification::FROM_USER_ID . "=" . $value[Notification::FROM_USER_ID];
                    $mark_as_seen_path .=  "&" . Notification::REDIRECT_PAGE . "=" . $_SERVER['PHP_SELF'];
        ?>
                        <div class="row <?php echo ($key % 2 == 1) ? "bg-gray" : "bg-white"; ?>"> 
                            <div class="col-lg-10">
                                <strong class="text-primary">
                                    <a href="<?php echo Database::VIEW_PROFILE . "?username=" . $value[Notification::FROM_USERNAME] ; ?>"><?php echo $value[User::NAME]; ?></a>
                                </strong>
                                <div>
                                    <h6><?php echo $value[Notification::MESSAGE]; ?></h6>
                                </div>
                                <small class="text-info"><?php echo $value[Notification::DATE_SENT]; ?></small>
                            </div>
                        <?php
                            if ($value[Notification::SEEN] == 0) {
                                ?><div class="col-lg-2">
                                    <a href="<?php echo $mark_as_seen_path; ?>">Mark as read</a>
                                </div><?php   
                            }
                        ?>
                              
                        </div>
        <?php
                }
            } else {
                ?>
                <div class="row"> 
                    <h6 class="mx-auto">Nothing to see here...</h6>
                </div>
                <?php
            }
            ?>
    </div>

	<footer id="footer">
        <p>&copy; MeetAmour 2020. All Rights Reserved.</p>
        <ul class="list-inline">
            <li class="list-inline-item">
            <a href="#">Privacy</a>
            </li>
            <li class="list-inline-item">
            <a href="#">Terms</a>
            </li>
            <li class="list-inline-item">
            <a href="#">FAQ</a>
            </li>
            <li class="list-inline-item">
			<a href="<?php echo Database::ABOUT_US; ?>">About us</a>
			</li>
        </ul>
        </div>
    </footer>

		<!-- Bootstrap core JavaScript -->
	<script src="vendor/jquery/jquery.min.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

	<!-- Plugin JavaScript -->
	<script src="vendor/jquery-easing/jquery.easing.min.js"></script>

	<!-- Custom scripts for this template -->
	<script src="js/new-age.min.js"></script>

	<?php
        $conn->close();
    ?>
</body>

</html>
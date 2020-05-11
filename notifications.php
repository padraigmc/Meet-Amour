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
            
            $allNotifications = Notification::get_all_notifications($conn);
			
			include("snippets/navbar.php");

		?>

<?php
    
?>

	</br>
	</br>
	</br>
	</br>
	</br>

	<div class="container mb-5">

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
									<a href="<?php echo Database::VIEW_PROFILE . "?" . User::USER_ID . "=" . $value[Notification::FROM_USER_ID] ; ?>"><?php echo $value[User::NAME]; ?></a>
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

	<footer class="fixed-bottom">
		<div class="container">
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
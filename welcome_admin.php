<?php
// Initialize the session
session_start();
// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: welcome_admin.php");
    exit;
}
require "connection.php";
$sql = "SELECT COUNT(*) AS User_ID
FROM registered_user_info";
$result = mysqli_query($link, $sql);
$data = mysqli_fetch_assoc($result);
$sql1 = "SELECT COUNT(*) AS User_ID
FROM blood_bank_info";
$res = mysqli_query($link, $sql1);
$data1 = mysqli_fetch_assoc($res);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!----======== CSS ======== -->
    <link rel="stylesheet" href="assets/css/welcome-style.css">
    <link rel="icon" href="assets/icons/title_icon.png" sizes="320x320" type="image/png">
    <!----===== Boxicons CSS ===== -->
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>

    <title>Dashboard Sidebar Menu</title>
</head>

<body>
    <nav class="sidebar">
        <header>
            <div class="image-text">
                <a href="welcome_admin.php">
                    <span class="image">
                        <img src="assets/icons/title_icon.png" alt="">
                    </span>
                </a>

                <div class="text logo-text">
                    <!-- <span class="name">WELCOME</span> -->
                    <span class="name">WELCOME ADMIN</span>
                    <span class="profession">ID :
                        <?php echo htmlspecialchars($_SESSION["Admin_ID"]); ?>
                    </span>
                </div>
            </div>
            <i class='bx bxs-droplet iconDrop'></i>
        </header>

        <div class="menu-bar">
            <div class="menu">
                <ul class="menu-links">
                    <li class="nav-link">
                        <a href="see_admin_information.php">
                            <i class='bx bx-home-alt icon'></i>
                            <span class="text nav-text">Admin Info.</span>
                        </a>
                    </li>

                    <li class="nav-link">
                        <a href="public_info_from_admin_home.php">
                            <i class='bx bxs-user-pin icon'></i>
                            <span class="text nav-text">Public Info.</span>
                        </a>
                    </li>

                    <li class="nav-link">
                        <a href="bloodbank_info_from_admin_home.php">
                            <i class='bx bxs-bank icon'></i>
                            <span class="text nav-text">BloodBanks Info.</span>
                        </a>
                    </li>

                    <li class="nav-link">
                        <a href="bloodbank_info_verification_from_admin.php">
                            <i class='bx bx-check-double icon'></i>
                            <span class="text nav-text">VERIFICATION</span>
                        </a>
                    </li>
                    
                    <li class="nav-link">
                        <a href="user_pass_reset_request.php">
                            <i class='bx bx-reset icon'></i>
                            <span class="text nav-text">User Pass Recovery</span>
                        </a>
                    </li>

                    <li class="nav-link">
                        <a href="blood_bank_pass_reset_request.php">
                            <i class='bx bx-reset icon'></i>
                            <span class="text nav-text">BloodBank Pass Recovery</span>
                        </a>
                    </li>
                </ul>
            </div>

            <div class="bottom-content">
                <li class="">
                    <a href="reset-password-admin.php">
                        <i class='bx bx-key icon'></i>
                        <span class="text nav-text">RESET PASSWORD</span>
                    </a>
                </li>
                <li class="">
                    <a href="admin_logout.php">
                        <i class='bx bx-log-out icon'></i>
                        <span class="text nav-text">Logout</span>
                    </a>
                </li>
                <li class="mode">
                    <div class="sun-moon">
                        <i class='bx bx-moon icon moon'></i>
                        <i class='bx bx-sun icon sun'></i>
                    </div>
                    <span class="mode-text text">Dark mode</span>

                    <div class="toggle-switch">
                        <span class="switch"></span>
                    </div>
                </li>

            </div>
        </div>

    </nav>

    <section class="home">
        <div class="text">
            <nav class="navbar">
                <div class="navbar_content">
                    <h1>ADMIN DASHBOARD</h1>
                    <p>USERNAME : <b>
                    <?php echo htmlspecialchars($_SESSION["Name"]); ?>
                        </b></p>
                    
                    <img src="assets/icons/title_icon.png" alt="" class="profile" />
                </div>
            </nav>
            <div class="donorSection">
                <h2>USER AND BLOODBANK RELATED INFO.</h2>
                <p>Be a donor and save lives.</p>
                <div class="middle-content">
                <h2>TOTAL USER ACCOUNTS - <?php echo htmlspecialchars($data['User_ID']); ?></h2>
                <br>
                <br>
                <h2>TOTAL BLOOD BANK ACCOUNTS - <?php echo htmlspecialchars($data1['User_ID']); ?></h2>
                </div>
            </div>
        </div>

    </section>

    <script src="assets/js/script.js"></script>
</body>

</html>
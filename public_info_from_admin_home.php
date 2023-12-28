<?php
// Initialize the session
session_start();
// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: admin_login.php");
    exit;
}
require "connection.php";
$sql = "SELECT * FROM registered_user_info";
$get_data = mysqli_query($link, $sql);
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
            <div class="userInfo">
                <div class="container">
                    <h2>PUBLIC ACCOUNT INFORMATION</h2>

                    <div class="tableInfo">
                        <table align="center" border="1px"
                            style="width:1000px; line-height:40px; border-collapse: collapse; border: 2px solid black; margin-top: 10px;">
                            <tr>
                                <th colspan="11">PUBLIC ACCOUNT INFORMATION</h>
                                </th>
                            </tr>
                            <t>
                                <th> ID </th>
                                <th> Name</th>
                                <th> Blood Type</th>
                                <th> Age</th>
                                <th> Location</th>
                                <th> Phone</th>
                                <th> E-mail</th>
                                <th> Last Donation</th>
                                <th> UserType</th>
                                <th> Preferred Date</th>
                                <th> Health Problems</th>
                                <th> DELETE ACCOUNT USER ACCOUNT</th>
                            </t>
                            <?php
                            while ($row = mysqli_fetch_assoc($get_data)) {
                                echo '<tr>
                    <td> ' . $row['User_ID'] . '</td>
                    <td> ' . $row['Name'] . '</td>
                    <td> ' . $row['Blood_Type'] . '</td>
                    <td> ' . $row['Age'] . '</td>
                    <td> ' . $row['Location'] . '</td>
                    <td> ' . $row['Phone'] . '</td>
                    <td> ' . $row['E_mail'] . '</td>
                    <td> ' . $row['Last_Donation'] . '</td>
                    <td> ' . $row['UserType'] . '</td>
                    <td> ' . $row['Preferred_Date'] . '</td>
                    <td> ' . $row['Health_Problem'] . '</td>
                    <td> FOR ID <a href="delete_us_data_from_admin.php?id=' . urlencode($row['User_ID']) . '" target="_blank">' . $row['User_ID'] . '</a> </td>
                    </tr>';
                            }
                            ?>
                        </table>
                    </div>

                </div>
            </div>
        </div>

    </section>

    <script src="assets/js/script.js"></script>
</body>

</html>
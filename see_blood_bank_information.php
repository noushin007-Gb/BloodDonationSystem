<?php
// Initialize the session
session_start();
// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}
require "connection.php";
$sql = "SELECT * FROM blood_bank_info WHERE user_id =($_SESSION[user_id])";
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
                <a href="welcome_blood_bank.php">
                    <span class="image">
                        <img src="assets/icons/title_icon.png" alt="">
                    </span>
                </a>

                <div class="text logo-text">
                    <!-- <span class="name">WELCOME</span> -->
                    <span class="name">WELCOME</span>
                    <span class="profession">ID :
                        <?php echo htmlspecialchars($_SESSION["user_id"]); ?></b>
                    </span>
                </div>
            </div>
            <i class='bx bxs-droplet iconDrop'></i>
        </header>

        <div class="menu-bar">
            <div class="menu">
                <ul class="menu-links">
                    <li class="nav-link">
                        <a href="see_blood_bank_information.php">
                            <i class='bx bx-home-alt icon'></i>
                            <span class="text nav-text">BLOODBANK Info.</span>
                        </a>
                    </li>

                    <li class="nav-link">
                        <a href="edit_blood_bank_info.php">
                            <i class='bx bxs-edit-alt icon'></i>
                            <span class="text nav-text">Edit your info.</span>
                        </a>
                    </li>


                </ul>
            </div>

            <div class="bottom-content">
                <li class="">
                    <a href="delete_blood_bank_data_confirmation.php">
                        <i class='bx bxs-user-x icon'></i>
                        <span class="text nav-text">DELETE PROFILE</span>
                    </a>
                </li>
                <li class="">
                    <a href="reset-password-blood-bank.php">
                        <i class='bx bx-key icon'></i>
                        <span class="text nav-text">RESET PASSWORD</span>
                    </a>
                </li>
                <li class="">
                    <a href="blood_bank_logout.php">
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
                    <h1>BLOODBANK DASHBOARD</h1>
                    <p>USERNAME : <b>
                            <?php echo htmlspecialchars($_SESSION["Name"]); ?>
                        </b></p>
                    
                    <img src="assets/icons/title_icon.png" alt="" class="profile" />
                </div>
            </nav>
            <div class="userInfo">
                <div class="container">
                    <h2>See BloodBank information</h2>

                    <div class="tableInfo">
                        <table align="center" border="1px"
                            style="width:1000px; line-height:40px; border-collapse: collapse; border: 2px solid black; margin-top: 10px;">
                            <tr>
                                <th colspan="10">See BloodBank Info</h>
                                </th>
                            </tr>
                            <t>
                                <th> ID </th>
                                <th> Name</th>
                                <th> Security Code</th>
                                <th> Contact Number </th>
                                <th> E-mail</th>
                                <th> Location</th>
                                <th> Storage Capacity</th>
                                <th> Facilities </th>
                                <th> Verification </th>
                            </t>
                            <?php
                            while ($row = mysqli_fetch_assoc($get_data)) {
                                echo '<tr>
                    <td> ' . $row['user_id'] . '</td>
                    <td> ' . $row['Name'] . '</td>
                    <td> ' . $row['Security_code'] . '</td>
                    <td> ' . $row['Contact'] . '</td>
                    <td> ' . $row['Email'] . '</td>
                    <td> ' . $row['Location'] . '</td>
                    <td> ' . $row['Storage_capacity'] . '</td>
                    <td> ' . $row['facilities'] . '</td>
                    <td> ' . $row['Verification'] . '</td>
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
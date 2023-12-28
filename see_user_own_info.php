<?php
// Initialize the session
session_start();
// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: index.php");
    exit;
}
require "connection.php";
$sql = "SELECT * FROM registered_user_info WHERE User_ID =($_SESSION[User_ID])";
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

    <title>See own info.</title>
</head>

<body>
    <nav class="sidebar">
        <header>
            <div class="image-text">
                <a href="welcome.php">
                <span class="image">
                    <img src="assets/icons/title_icon.png" alt="">
                </span>
                </a>
                <div class="text logo-text">
                    <span class="name">WELCOME</span>
                    <span class="profession">ID :
                        <?php echo htmlspecialchars($_SESSION["User_ID"]); ?>
                    </span>
                </div>
            </div>
            <i class='bx bxs-droplet iconDrop'></i>
        </header>

        <div class="menu-bar">
            <div class="menu">
                <ul class="menu-links">
                    <li class="nav-link">
                        <a href="#">
                            <i class='bx bx-home-alt icon'></i>
                            <span class="text nav-text">See own info.</span>
                        </a>
                    </li>

                    <li class="nav-link">
                        <a href="edit_user_info.php">
                            <i class='bx bxs-edit-alt icon'></i>
                            <span class="text nav-text">Edit your info.</span>
                        </a>
                    </li>

                    <li class="nav-link">
                        <a href="become_a_donor.php">
                            <i class='bx bxs-donate-blood icon'></i>
                            <span class="text nav-text">Be a DONOR.</span>
                        </a>
                    </li>

                    <li class="nav-link">
                        <a href="blood_request_user.php">
                            <i class='bx bx-pie-chart-alt icon'></i>
                            <span class="text nav-text">Blood Requests.</span>
                        </a>
                    </li>

                    <li class="nav-link">
                        <a href="send_request.php">
                            <i class='bx bx-heart icon'></i>
                            <span class="text nav-text">Send Blood Req.</span>
                        </a>
                    </li>

                    <li class="nav-link">
                        <a href="delete_blood_request_user.php">
                            <i class='bx bx-wallet icon'></i>
                            <span class="text nav-text">Delete your Req.</span>
                        </a>
                    </li>

                </ul>
            </div>

            <div class="bottom-content">
                <li class="">
                    <a href="delete_user_data_confirmation.php">
                        <i class='bx bxs-user-x icon'></i>
                        <span class="text nav-text">DELETE PROFILE</span>
                    </a>
                </li>
                <li class="">
                    <a href="reset-password.php">
                        <i class='bx bx-key icon'></i>
                        <span class="text nav-text">RESET PASSWORD</span>
                    </a>
                </li>
                <li class="">
                    <a href="logout.php">
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
                    <h1>User information Dashboard</h1>
                    <p>USERNAME : <b>
                            <?php echo htmlspecialchars($_SESSION["username"]); ?>
                        </b></p>
                   
                    <img src="assets/icons/title_icon.png" alt="" class="profile" />
                </div>
            </nav>
            <div class="userInfo">
                <div class="container">
                    <h2>See User information</h2>

                    <div class="tableInfo">
                    <table align="center" border="1px" style="width:1000px; line-height:40px; border-collapse: collapse; border: 2px solid black; margin-top: 10px;">
                            <tr>
                                <th colspan="11">See
                                    <?php echo htmlspecialchars($_SESSION["username"]); ?>'s Info
                                    </h>
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
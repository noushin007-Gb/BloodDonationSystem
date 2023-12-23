<?php
// import the config file
$mysqli = new mysqli("localhost", "root", "", "blood_donation_system");
require_once "connection.php";

// Define variables and initialize with null string
$User_ID = "";
$User_ID_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (empty(trim($_POST["User_ID"]))) {
        $User_ID_err = "Enter your User ID.";
    } elseif (is_numeric(trim($_POST["User_ID"]))) {
        $User_ID = trim($_POST["User_ID"]);
    } else {
        $User_ID_err = "Please enter a valid USER ID <br>
                        AS EXAMPLE 2013130";
    }

    // Check input errors before inserting in database
    if (empty($User_ID_err)) {

        // Prepare an insert statement
        $sql = "INSERT INTO pass_req_wit_uid (User_ID) VALUES ( ?)";
        $data = "INSERT INTO user_pass_reset_request (User_ID,Username,Name,E_mail,Contact,UserType) 
                 SELECT User_ID,Username,Name,E_mail,Phone,UserType	
                 FROM registered_user_info
                 WHERE User_ID =ANY (SELECT User_ID
                                     FROM pass_req_wit_uid
                                     WHERE User_ID = ?)";
        $dataCheck = "SELECT User_ID FROM registered_user_info WHERE User_ID = ?";

        $stmt = $mysqli->prepare($dataCheck);
        $stmt->bind_param("i", $User_ID);



        mysqli_report(MYSQLI_REPORT_STRICT);
        if ($stmt->execute()) {
            mysqli_stmt_store_result($stmt);
            // updated successfully. Destroy the session, and redirect to login page
            if (mysqli_stmt_num_rows($stmt) == 1) {
                $stmt = $mysqli->prepare($sql);
                $stmt->bind_param("i", $User_ID);


                if ($stmt->execute()) {
                    // updated successfully. Destroy the session, and redirect to login page
                    echo '<h1 class="success"><center><b>"Requested for password recovery"</b>
                         <br><b>Wait for admin response and check your e-mail</b><br>
                         Redirecting you to the login page in 2 seconds...</center></h1>';


                } else {

                    echo '<h1 class="error"><center><b style="color:red">"You have already requested for reset password"</b>
                     <br><b style="color:red">Wait for admin response and check your e-mail</b><br>
                     <b style="color:red">Redirecting you to the login page in 2 seconds...</b></center></h1>';

                }
                $stmt = $mysqli->prepare($data);
                $stmt->bind_param("i", $User_ID);


                if ($stmt->execute()) {
                    // updated successfully. Destroy the session, and redirect to login page
                    header("refresh:2;url=index.php");
                    echo "";
                } else {
                    header("refresh:2;url=index.php");
                    echo "";
                }


            } else {
                header("refresh:2;url=index.php");
                echo '<h1><center><b style="color:red">"User ID not found which has been provided"</b>
                        <br>
                        <b style="color:red">redirecting you to login page in ..2...1 Seconds!!</b></center></h1>';
            }

        }
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);


        // Close statement
        $stmt->close();
        $mysqli->close();

    }




    // Close connection
    mysqli_close($link);
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Login</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="icon" href="assets/icons/title_icon.png" sizes="320x320" type="image/png">
    <script src="https://kit.fontawesome.com/2ea1850a25.js" crossorigin="anonymous"></script>
    <style>
        h1 {
            text-align: center;
            color: #333;
            background-color: rgba(0, 0, 0, 0);
        }

        /* Success message */
        .success {
            color: green;
        }

        /* Error message */
        .error {
            background-color: rgba(0, 0, 0, 0);
            color: red;
        }

        /* Redirect message */
        .redirect {
            color: blue;
        }
    </style>


</head>

<body>
    <div class="container">
        <div class="form-box" id="userLoginForm">



            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" id="userLogin">
                <div class="input-group">
                    <h2>PASSWORD RECOVERY</h2>
                    <br>
                    <br>
                    <p>Please provide valid User ID so Admin can aprove you password recovery</p>
                    <div class="input-field" id="userUsernameInput">
                        <i class="fa-solid fa-user fa-flip" style="color: #ff0000;"></i>
                        <input type="number" name="User_ID" class="form-control" value="<?php echo $User_ID; ?>">
                    </div>
                    <div class="btn-field">
                        <button type="submit" class="btn" id="userLoginButton">Submit</button>
                        <button type="button" class="btn" id="userRegisterBtn">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('userRegisterBtn').addEventListener('click', function () {
            window.location.href = 'index.php';
        });
    </script>

</body>

</html>

<?php
// Initialize the session
session_start();

// Check if the user is logged in, otherwise redirect to the login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: welcome.php");
    exit;
}

$a = 'delete_blood_request_user.php';

// Include config file
require_once "connection.php";

// Check if the user has already made a blood request
$check_sql = "SELECT * FROM blood_request_user WHERE User_ID = ?";
if ($check_stmt = mysqli_prepare($link, $check_sql)) {
    mysqli_stmt_bind_param($check_stmt, "i", $param_id);
    $param_id = $_SESSION["User_ID"];
    mysqli_stmt_execute($check_stmt);
    mysqli_stmt_store_result($check_stmt);

    if (mysqli_stmt_num_rows($check_stmt) > 0) {
        // User has already made a request, display a message and exit
        header("refresh:3;url=welcome.php");
        echo '<h1><center><b>You have already requested blood. Please <a href="delete_blood_request_user.php?link=$a">DELETE</a> it to continue.</b><br><b>Redirecting you in 3..2...1 seconds!</b></center></h1>';
        exit();
    }

    mysqli_stmt_close($check_stmt);
}

// Define variables and initialize with empty values
$Blood_Type = $Name = $Age = $Phone = $Location = $Time = $Preferred_Date = "";
$Blood_Type_err = $Name_err = $Age_err = $Phone_err = $Location_err = $Time_err = $Preferred_Date_err = "";

// Processing form data when the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validate new name
    if (empty(trim($_POST["Name"]))) {
        $Name_err = "Enter the Name.";
    } elseif (strlen(trim($_POST["Name"])) < 1) {
        $Name_err = "Name must be characters.";
    } else {
        $Name = trim($_POST["Name"]);
    }

    if (empty(trim($_POST["Blood_Type"]))) {
        $Blood_Type_err = "Enter the Blood Type.";
    } else {
        $Blood_Type = trim($_POST["Blood_Type"]);
    }

    if (empty(trim($_POST["Age"]))) {
        $Age_err = "Enter your Age.";
    } elseif ($_POST["Age"] < 18) {
        $Age_err = "You Must Be At Least 18 Years Old";
    } else {
        $Age = trim($_POST["Age"]);
    }

    if (empty(trim($_POST["Phone"]))) {
        $Phone_err = "Enter your Phone number.";
    } elseif (is_numeric(trim($_POST["Phone"])) && strlen(trim($_POST["Phone"])) == 11) {
        $Phone = trim($_POST["Phone"]);
    } else {
        $Phone_err = "You must provide a valid Phone number.";
    }

    if (empty(trim($_POST["Location"]))) {
        $Location_err = "Enter your Location.";
    } else {
        $Location = trim($_POST["Location"]);
    }

    if (empty(trim($_POST["Preferred_Date"]))) {
        $Preferred_Date_err = "Enter your Preferred_Date.";
    } else {
        $Preferred_Date = trim($_POST["Preferred_Date"]);
    }

    if (empty(trim($_POST["Time"]))) {
        $Time_err = "Enter the Time.";
    } else {
        $Time = trim($_POST["Time"]);
    }

    // Check input errors before updating the database
    if (empty($Name_err) && empty($Age_err) && empty($Phone_err) && empty($Location_err) && empty($Time_err) && empty($Blood_Type_err) && empty($Preferred_Date_err)) {
        // Prepare an update statement
        $sql = "INSERT INTO blood_request_user (Blood_Type, User_ID, Name, Location, Phone, Preferred_Date, Time, Age) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sisssssi", $param_Blood_Type, $param_id, $param_Name, $param_Location, $param_Phone, $param_Preferred_Date, $param_Time, $param_Age);

            // Set parameters
            $param_Name = $Name;
            $param_Age = $Age;
            $param_Phone = $Phone;
            $param_Location = $Location;
            $param_Time = $Time;
            $param_Blood_Type = $Blood_Type;
            $param_Preferred_Date = $Preferred_Date;
            $param_id = $_SESSION["User_ID"];

            // Attempt to execute the prepared statement
            mysqli_report(MYSQLI_REPORT_STRICT);

            if (mysqli_stmt_execute($stmt)) {
                // Inserted successfully. Destroy the session and redirect to the login page
                header("location: welcome.php");
                exit();
            } else {
                // Display an error message and redirect
                header("refresh:3;url=welcome.php");
                echo '<h1><center><b>Error inserting record. Redirecting you in 3..2...1 seconds!</b></center></h1>';
                die();
            }

            mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
}

// Close connection
mysqli_close($link);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>SEND BLOOD REQUEST</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style>
        body {
            background-color: #F6F5FF;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
            font: 14px sans-serif;
            scale: 0.95;
        }

        .wrapper {
            width: 350px;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
        }

        /* Make the submit button red */
        .btn-primary {
            background-color: red;
            color: white;
        }

        .btn-primary:hover {
            background-color: purple;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <h2>SEND BLOOD REQUEST</h2>
        <p>Please fill out this form to Edit User Info.</p>
        <h3>USER ID
            <?php echo htmlspecialchars($_SESSION["User_ID"]); ?>
        </h3>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <br>
            <div class="form-group <?php echo (!empty($Blood_Type_err)) ? 'has-error' : ''; ?>">
                <label for="Blood_Type">
                    <h4><b>Choose Blood Type:</b></h4>
                </label>
                <select id="Blood_Type" name="Blood_Type">
                    <option value="AB+">AB+</option>
                    <option value="AB-">AB-</option>
                    <option value="A+">A+</option>
                    <option value="A-">A-</option>
                    <option value="B+">B+</option>
                    <option value="B-">B-</option>
                    <option value="O+">O+</option>
                    <option value="O-">O-</option>
                </select><br><br>
                <span class="help-block">
                    <?php echo $Blood_Type_err; ?>
                </span>
            </div>
            <div class="form-group <?php echo (!empty($Name_err)) ? 'has-error' : ''; ?>">
                <label>Name</label>
                <input type="Text" name="Name" class="form-control" value="<?php echo $_SESSION["Name"]; ?>">
                <span class="help-block">
                    <?php echo $Name_err; ?>
                </span>
            </div>
            <div class="form-group <?php echo (!empty($Age_err)) ? 'has-error' : ''; ?>">
                <label>Age</label>
                <input type="number" name="Age" class="form-control" value="<?php echo $_SESSION["Age"]; ?>">
                <span class="help-block">
                    <?php echo $Age_err; ?>
                </span>
            </div>
            <div class="form-group <?php echo (!empty($Phone_err)) ? 'has-error' : ''; ?>">
                <label>Phone</label>
                <input type="Text" name="Phone" class="form-control" value="<?php echo $_SESSION["Phone"]; ?>">
                <span class="help-block">
                    <?php echo $Phone_err; ?>
                </span>
            </div>
            <div class="form-group <?php echo (!empty($Location_err)) ? 'has-error' : ''; ?>">
                <label>Location</label>
                <input type="Text" name="Location" class="form-control" value="<?php echo $_SESSION["Location"]; ?>">
                <span class="help-block">
                    <?php echo $Location_err; ?>
                </span>
            </div>
            <div class="form-group <?php echo (!empty($Time_err)) ? 'has-error' : ''; ?>">
                <label>Preferred Time</label>
                <input type="time" name="Time" class="form-control" value="<?php echo $Time; ?>">
                <span class="help-block">
                    <?php echo $Time_err; ?>
                </span>
            </div>
            <div class="form-group <?php echo (!empty($Preferred_Date_err)) ? 'has-error' : ''; ?>">
                <label>
                    Preferred Date:
                    <input type="date" name="Preferred_Date" placeholder="yyyy-mm-dd">
                    <span class="validity"></span>
                </label>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <a class="btn btn-link" href="welcome.php">Cancel</a>
            </div>
        </form>
    </div>
</body>

</html>
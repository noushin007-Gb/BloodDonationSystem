<?php
// import the config file
require_once "connection.php";
 
// Define variables and initialize with null string
$username = $password = $confirm_password = $Name = $Age = $Phone = $E_mail = $Location 
= $Last_Donation =$UserType = $Preferred_Date= $Blood_Type =$Health_Problem = "";
$username_err = $password_err = $confirm_password_err = $Name_err = $Age_err = $Phone_err = $E_mail_err = $Location_err 
= $Last_Donation_err = $UserType_err = $Preferred_Date_err = $Blood_Type_err = $Health_Problem_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate username
    if(empty(trim($_POST["username-input"]))){
        $username_err = "Please enter a Username.";
    } else{
        // Prepare a select statement
        $sql = "SELECT User_ID FROM registered_user_info WHERE Username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = trim($_POST["username-input"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username_err = "This Username is already taken.";
                } else{
                    $username = trim($_POST["username-input"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
        
    }
    
    // Validate password
    if(empty(trim($_POST["password-input"]))){
        $password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST["password-input"])) < 6){
        $password_err = "Password must have atleast 6 characters.";
    } else{
        $password = trim($_POST["password-input"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm-password-input"]))){
        $confirm_password_err = "Please confirm password.";     
    } else{
        $confirm_password = trim($_POST["confirm-password-input"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }
    if(empty(trim($_POST["name-input"]))){
        $Name_err = "Enter your Name.";     
    } elseif(strlen(trim($_POST["name-input"])) < 1){
        $Name_err = "Name must be characters.";
    } else{
        $Name = trim($_POST["name-input"]);
    }
    
    // Validate Email
    if(empty(trim($_POST["email-input"]))){
        $E_mail_err = "Please enter your E-mail.";
    } else{
        $E_mail = trim($_POST["email-input"]);
    }

    if(empty(trim($_POST["age-input"]))){
        $Age_err = "Enter your Age.";     
    }elseif($_POST["age-input"] < 18){
        $Age_err = "You Must Be At Least 18 Years Old";
    }else{
        $Age = trim($_POST["age-input"]);
    }

    if(empty(trim($_POST["phone-input"]))){
        $Phone_err = "Enter your Phone number.";     
    }elseif(is_numeric(trim($_POST["phone-input"])) && strlen(trim($_POST["phone-input"])) ==11){
        $Phone = trim($_POST["phone-input"]);
    }else{
        $Phone_err = "You must provide a valid Phone number.";
    }

    if(empty(trim($_POST["location-input"]))){
        $Location_err = "Enter your Location.";     
    }else{
        $Location = trim($_POST["location-input"]);
    }

    if(empty(trim($_POST["last-donation-input"]))){
        $Last_Donation_err = "Enter your Last Donation.";     
    }elseif(is_numeric(trim($_POST["last-donation-input"]))){
        $Last_Donation = trim($_POST["last-donation-input"]);
    }else{
        $Last_Donation_err = "Enter your Last Donation in Days.";
    }

    if(empty(trim($_POST["UserType"]))){
        $UserType_err = "Enter your UserType.";     
    }else{
        $UserType = trim($_POST["UserType"]);
    }

    if(empty(trim($_POST["Preferred_Date"]))){
        $Preferred_Date_err = "Enter your Preferred_Date.";     
    }else{
        $Preferred_Date = trim($_POST["Preferred_Date"]);
    }

    if(empty(trim($_POST["health-problems-input"]))){
        $Health_Problem_err = "Enter your Health Problem.";     
    }else{
        $Health_Problem = trim($_POST["health-problems-input"]);
    }
    
    $Blood_Type= trim($_POST["Blood_Type"]);
    
    
    
    // Check input errors before inserting in database
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err)&& empty($Name_err)&& empty($E_mail_err)&& empty($Age_err)&& empty($Phone_err)&& empty($Location_err)&& empty($Last_Donation_err)
    && empty($UserType_err)&& empty($Preferred_Date_err)&& empty($Health_Problem_err)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO registered_user_info (Username, Password,Name,Age,Phone,E_mail
        ,Location,Last_Donation,UserType,Preferred_Date,Blood_Type,Health_Problem) VALUES ( ?,?,?, 
        ?, ?,?,?, ?, ?,?,?,?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssssssssssss", $param_username, $param_password,$Name,$Age,
            $Phone,$E_mail,$Location,$Last_Donation,$UserType,$Preferred_Date,$Blood_Type,
            $Health_Problem);
            
            // Set parameters
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            $_SESSION["User_ID"] = $User_ID;
            $_SESSION["username-input"] = $username;                            
            $_SESSION["name-input"] = $Name;  
            $_SESSION["Blood_Type"] = $Blood_Type; 
            $_SESSION["age-input"] = $Age;   
            $_SESSION["last-donation-input"] = $Last_Donation;
            $_SESSION["location-input"] = $Location;
            $_SESSION["UserType"] = $UserType;
            $_SESSION["email-input"] = $E_mail;     
            $_SESSION["phone-input"] = $Phone;
            $_SESSION["health-problems-input"] = $Health_Problem; 
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                header("location: index.php");
            } else{
                echo "Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Close connection
    mysqli_close($link);
}
?>
<!DOCTYPE html>
<html>

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>User Register</title>
  <link rel="stylesheet" href="assets/css/register-style.css">
  <link rel="icon" href="assets/icons/title_icon.png" sizes="320x320" type="image/png">
  <script src="https://kit.fontawesome.com/2ea1850a25.js" crossorigin="anonymous"></script>
  <script>
    function resetForm() {
      // Get all input elements in the form
      var inputFields = document.querySelectorAll('#user-register-form input');

      // Loop through each input and set its value to an empty string
      inputFields.forEach(function(input) {
        input.value = '';
      });

      // Reset the dropdown to the default option
      document.getElementById('UserType').selectedIndex = 0;
      document.getElementById('Blood_Type').selectedIndex = 0;
    }
  </script>
</head>

<body>
  <div class="container" id="main-container">
    <div class="form-box" id="user-register-form">
      <h1>USER Register</h1>
      <form id="registration-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="input-group">
          <label>Please fill this form to create an account as User.</label>
          <div class="column">
            <div class="input-field" id="username-field">
              <i class="fa-solid fa-user fa-flip" style="color: #ff0000;"></i>
              <input type="text" placeholder="Username" id="username-input" name="username-input">    
            </div>
            <span class="help-block"><?php echo $username_err; ?></span>
            <div class="input-field" id="password-field">
              <i class="fa-solid fa-lock fa-beat-fade" style="color: #ff0000;"></i>
              <input type="password" placeholder="Password" id="password-input" name="password-input">
            </div>
            <span class="help-block"><?php echo $password_err; ?></span>
            <div class="input-field" id="confirm-password-field">
              <i class="fa-solid fa-lock fa-beat-fade" style="color: #ff0000;"></i>
              <input type="password" placeholder="Confirm Password" id="confirm-password-input" name="confirm-password-input">
            </div>
            <span class="help-block"><?php echo $confirm_password_err; ?></span>
            <div class="input-field" id="name-field">
              <input type="text" placeholder="Name" id="name-input" name="name-input">
            </div>
            <span class="help-block"><?php echo $Name_err; ?></span>
            <label for="Preferred_Date">Preferred Date:</label>
            <div class="input-field-date" id="preferred-date-field">
              <input type="date" name="Preferred_Date" placeholder="yyyy-mm-dd" id="preferred-date-input">
            </div>
            <span class="help-block"><?php echo $Preferred_Date_err; ?></span>
            <label>Health Problems:</label>
            <div class="input-field-2" id="health-problems-field">
              <input type="text" placeholder="Health Problems" id="health-problems-input" name="health-problems-input">
            </div>
            <span class="help-block"><?php echo $Health_Problem_err; ?></span>
          </div>
          <div class="column">
            <div class="input-field" id="email-field">
              <input type="email" placeholder="Enter your E-Mail" id="email-input" name="email-input">
            </div>
            <span class="help-block"><?php echo $E_mail_err; ?></span>
            <div class="input-field" id="phone-field">
              <input type="text" placeholder="Phone(+88)" id="phone-input" name="phone-input">
            </div>
            <span class="help-block"><?php echo $Phone_err; ?></span>
            <div class="input-field" id="location-field">
              <input type="text" placeholder="Location" id="location-input" name="location-input">
            </div>
            <span class="help-block"><?php echo $Location_err; ?></span>
            <div class="input-field" id="last-donation-field">
              <input type="text" placeholder="Last Donation(in Days)" id="last-donation-input" name="last-donation-input">
            </div>
            <span class="help-block"><?php echo $Last_Donation_err; ?></span>
            <div class="input-field" id="age-field">
              <input type="text" placeholder="Age" id="age-input" name="age-input">
            </div>
            <span class="help-block"><?php echo $Age_err; ?></span>
            <div class="dropdown-field" id="user-type-field">
              <label for="UserType">Choose UserType:</label>
              <select id="UserType" name="UserType">
                <option value="ACCEPTOR">ACCEPTOR</option>
                <option value="DONOR">DONOR</option>
              </select><br><br>
            </div>
            <div class="dropdown-field" id="blood-type-field">
              <label for="Blood_Type">Choose Blood Type:</label>
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
            </div>
          </div>
        </div>
        <div class="btn-field">
          <button type="submit" class="btn" id="submit-button" value="Submit">Submit</button>
          <button type="button" class="btn" onclick="resetForm()" id="reset-button">Reset</button>
        </div>
        <p>Already have an account? <a href="index.php">Login here.</a></p>
      </form>
    </div>
  </div>
</body>

</html>
<?php
// import the config file
require_once "connection.php";
 
// Define variables and initialize with null string
$user_id = $Bpassword= $confirm_Bpassword = $Name = $Security_code = $Contact = $Email = $Location = $Storage_capacity 
=$facilities = $Verififation = "";
$user_id_err = $Bpassword_err = $confirm_Bpassword_err = $Name_err = $Security_code_err = $Contact_err
 = $Email_err = $Location_err = $Storage_capacity_err 
=$facilities_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate username
    if(empty(trim($_POST["bloodBankName"]))){
        $Name_err = "Please enter a Name.";
    } else{
        // Prepare a select statement
        $sql = "SELECT User_ID FROM blood_bank_info WHERE Name = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $Name);
            
            // Set parameters
            $param_Name = trim($_POST["bloodBankName"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $Name_err = "This Blood Bank Name is already taken.";
                } else{
                    $Name = trim($_POST["bloodBankName"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
        
    }
    
    // Validate password
    if(empty(trim($_POST["password"]))){
        $Bpassword_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST["password"])) < 6){
        $Bpassword_err = "Password must have atleast 6 characters.";
    } else{
        $Bpassword = trim($_POST["password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirmPassword"]))){
        $confirm_Bpassword_err = "Please confirm password.";     
    } else{
        $confirm_Bpassword = trim($_POST["confirmPassword"]);
        if(empty($Bpassword_err) && ($Bpassword != $confirm_Bpassword)){
            $confirm_Bpassword_err = "Password did not match.";
        }
    }
    // Validate Email
    if(empty(trim($_POST["email"]))){
        $Email_err = "Please enter the E-mail.";
    } else{
        $Email = trim($_POST["email"]);
    }

    if(empty(trim($_POST["securityCode"]))){
        $Security_code_err = "Enter the Security code.";     
    }elseif(is_numeric(trim($_POST["securityCode"])) && strlen(trim($_POST["securityCode"])) ==10){
        $Security_code = trim($_POST["securityCode"]);
    }else{
        $Security_code_err = "you must enter a valid Security code";
    }

    if(empty(trim($_POST["contactNo"]))){
        $Contact_err = "Enter the Contact number.";     
    }elseif(is_numeric(trim($_POST["contactNo"])) && strlen(trim($_POST["contactNo"])) ==11){
        $Contact = trim($_POST["contactNo"]);
    }else{
        $Contact_err = "You must provide a valid Contact number.";
    }

    if(empty(trim($_POST["location"]))){
        $Location_err = "Enter the Location.";     
    }else{
        $Location = trim($_POST["location"]);
    }

    if(empty(trim($_POST["storageCapacity"]))){
        $Storage_capacity_err = "Enter the Storage_capacity.";     
    }elseif(is_numeric(trim($_POST["storageCapacity"]))){
        $Storage_capacity = trim($_POST["storageCapacity"]);
    }else{
        $Storage_capacity_err = "Enter your Storage capacity.";
    }

    if(empty(trim($_POST["facilities"]))){
        $facilities_err = "Enter the facilities.";     
    }else{
        $facilities = trim($_POST["facilities"]);
    }

    $Verification = trim($_POST["verify"]);
    
    
    
    // Check input errors before inserting in database
    if(empty($Name_err) && empty($Bpassword_err) && empty($Security_code_err) && empty($confirm_Bpassword_err)&& empty($Email_err)&& empty($Contact_err)&& empty($Location_err)
    && empty($Storage_capacity_err)&& empty($facilities_err)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO blood_bank_info (Name, Bpassword,Security_code,Contact,Email
        ,Location,Storage_capacity,facilities,Verification) VALUES ( ?,?,?, 
        ?, ?,?,?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssisssiss", $param_Name, $param_Bpassword,$Security_code,
            $Contact,$Email,$Location,$Storage_capacity,$facilities,$Verification);
            
            // Set parameters
            $param_Name = $Name;
            $param_Bpassword = password_hash($Bpassword, PASSWORD_DEFAULT); // Creates a password hash
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                header("location: blood_bank_login.php");
            } else{
                echo "Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Close connection
    //verification will be manage by admin
    mysqli_close($link);
}
?>
<!DOCTYPE html>
<html>

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Blood Bank Register</title>
  <link rel="stylesheet" href="assets/css/register-style.css">
  <link rel="icon" href="assets/icons/title_icon.png" sizes="320x320" type="image/png">
  <script src="https://kit.fontawesome.com/2ea1850a25.js" crossorigin="anonymous"></script>
  <script>
    function resetForm() {
      // Get all input elements in the form
      var inputFields = document.querySelectorAll('#bloodBankRegisterForm input');

      // Loop through each input and set its value to an empty string
      inputFields.forEach(function(input) {
        input.value = '';
      });

      // Reset the dropdown to the default option
      document.getElementById('verify').selectedIndex = 0;
    }
  </script>
</head>
<body>
  <div class="container">
    <div class="form-box" id="bloodBankRegisterForm">
      <h1 id="formTitle">Blood Bank Register</h1>
      <form id="registrationForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="input-group">
          <label for="bloodBankName">Please fill this form to create an account as BLOOD BANK.</label>
          <div class="column">
            <div class="input-field">
              <i class="fa-solid fa-user fa-flip" style="color: #ff0000;"></i>
              <input type="text" placeholder="Blood Bank Name" id="bloodBankName" name="bloodBankName">
            </div>
            <div class="input-field">
              <i class="fa-solid fa-lock fa-beat-fade" style="color: #ff0000;"></i>
              <input type="password" placeholder="Password" id="password" name="password">
            </div>
            <div class="input-field">
              <i class="fa-solid fa-lock fa-beat-fade" style="color: #ff0000;"></i>
              <input type="password" placeholder="Confirm Password" id="confirmPassword" name="confirmPassword">
            </div>
            <div class="input-field">
              <input type="text" placeholder="Storage Capacity" id="storageCapacity" name="storageCapacity">
            </div>
            <div class="input-field">
              <input type="text" placeholder="Security Code (10)" id="securityCode" name="securityCode">
            </div>
          </div>
          <div class="column">
            <div class="input-field">
              <input type="email" placeholder="Enter E-Mail" id="email" name="email">
            </div>
            <div class="input-field">
              <input type="text" placeholder="Contact No." id="contactNo" name="contactNo">
            </div>
            <div class="input-field">
              <input type="text" placeholder="Location" id="location" name="location">
            </div>
            <div class="input-field">
              <input type="text" placeholder="Facilities" id="facilities" name="facilities">
            </div>
            <div class="dropdown-field">
              <label for="verify">Declair:</label>
              <select id="verify" name="verify">
                <option value="NOT VERIFIED">NOT VERIFIED</option>
              </select><br><br>
            </div>
          </div>
        </div>
        <div class="btn-field">
          <button type="submit" class="btn" id="submitBtn" value="Submit">SUBMIT</button>
          <button type="button" class="btn" onclick="resetForm()" id="resetBtn">Reset</button>
        </div>
        <p>Already have an account? <a href="blood_bank_login.php" id="blood-bank-login-link">Login here.</a></p>
      </form>
    </div>
  </div>
</body>
</html>
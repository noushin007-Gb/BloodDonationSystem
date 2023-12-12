<!DOCTYPE html>
<html>

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Login</title>
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="icon" href="assets/icons/title_icon.png" sizes="320x320" type="image/png">
  <script src="https://kit.fontawesome.com/2ea1850a25.js" crossorigin="anonymous"></script>
</head>

<body>
  <div class="container">
    <div class="form-box" id="adminLoginForm"> 
      <h1>ADMIN LOGIN</h1>
      <form id="adminLogin">
        <div class="input-group">
          <div class="input-field" id="usernameInput"> 
            <i class="fa-solid fa-user fa-flip" style="color: #ff0000;"></i>
            <input type="text" placeholder="Username">
          </div>
          <div class="input-field" id="passwordInput"> 
            <i class="fa-solid fa-lock fa-beat-fade" style="color: #ff0000;"></i>
            <input type="password" placeholder="Password">
          </div>
          <p>Reset password <a href="#" id="resetPasswordLink">Click Here!</a></p> 
          <div class="btn-field" style="margin-left: 85px;">
            <button type="button" class="btn" id="loginButton">Login</button> 
          </div>
          <p>Login as <a href="index.php" id="userLoginLink">USER</a></p>
          <p>Login as <a href="blood_bank_login.php" id="bloodBankLoginLink">BLOOD BANK</a></p> 
        </div>
      </form>
    </div>
  </div>
</body>

</html>
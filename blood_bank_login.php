<!DOCTYPE html>
<html>

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Blood Bank Login</title>
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="icon" href="assets/icons/title_icon.png" sizes="320x320" type="image/png">
  <script src="https://kit.fontawesome.com/2ea1850a25.js" crossorigin="anonymous"></script>
</head>

<body>
  <div class="container">
    <div class="form-box" id="bloodBankLoginForm">
      
      <h1>BLOOD BANK LOGIN</h1>
      <form id="bloodBankLogin">
        <div class="input-group">
          <div class="input-field" id="bloodBankUsernameInput">
          
            <i class="fa-solid fa-user fa-flip" style="color: #ff0000;"></i>
            <input type="text" placeholder="Username">
          </div>
          <div class="input-field" id="bloodBankPasswordInput">
           
            <i class="fa-solid fa-lock fa-beat-fade" style="color: #ff0000;"></i>
            <input type="password" placeholder="Password">
          </div>
          <p>Reset password <a href="#" id="bloodBankResetPasswordLink">Click Here!</a></p>
       
          <div class="btn-field">
            <button type="button" class="btn" id="registerBtn">Register</button>
            <button type="button" class="btn" id="bloodBankLoginButton">Login</button>
           
          </div>
          <p>Login as <a href="admin_login.php" id="adminLoginLink">ADMIN</a></p>
      
          <p>Login as <a href="index.php" id="userLoginLink">USER</a></p> 
        </div>
      </form>
    </div>
  </div>

  <script>
    document.getElementById('registerBtn').addEventListener('click', function() {
      window.location.href = 'register_blood_bank.php';
    });
  </script>
</body>

</html>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>LIbro || Login Form</title>
  <link rel="stylesheet" href="assets/css/index.css">
  <!--- google font link-->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&display=swap" rel="stylesheet" />
  
</head>

<body onload="preloader()">
  <style>
    .input-field .error {
      color: #FF3333;
      font-size: 14px;
    }
  </style>

  <section class="login">
    <form class="login-form" action="pages/login.php" method="POST">
      <h4>Librarian Login</h4>

      <div class="input-form">
        <div class="input-field">
          <label for="email">Email *</label>
          <input type="email" name="email" id="email" placeholder="Your Email">
        </div>
        <div class="input-field">
          <label for="password">Password *</label>
          <input type="password" name="password" id="password" placeholder="Password">
        </div>
        <input type="submit" name="lib-login" value="Login">
        <p>Don't Have an Account ? <a href="registrationPage.php">Signup Now</a></p>
      </div>
    </form>
  </section>
</body>

</html>
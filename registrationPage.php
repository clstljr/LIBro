<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>LIbro || Register Form</title>
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

  <section class="registration">
    <div class="registration-form">
      <h4>Register</h4>
      <form class="input-form" action="pages/register.php" method="POST">
        <?php
        if (isset($error['lib-msg'])) {
        ?>
          <p>
            <?php echo $error['lib-msg']; ?>
          </p>
        <?php
        }
        ?>
        <div class="input-field">
          <label for="name">Username *</label>
          <input type="text" name="username" placeholder="Your Name" required>
        </div>

        <div class="input-field">
          <label for="email">Email *</label>
          <input type="text" name="email" id="email" placeholder="Your Email" required>
        </div>
        <div class="input-field">
          <label for="address">Address *</label>
          <input type="text" name="address" id="address" placeholder="Address">
        </div>
        <div class="input-field">
          <label for="phone">Mobile No. *</label>
          <input type="text" maxlength="10" name="phone" id="phone" placeholder="Mobile No.">
        </div>
        <div class="input-field">
          <label for="password">Password *</label>
          <input type="password" name="password" id="password" placeholder="Password" required>
        </div>
        <div class="input-field">
          <label for="cpassword">Confirm Password *</label>
          <input type="password" name="cpassword" id="cpassword" placeholder="Confirm Password" required>
        </div>
        <input type="submit" name="register" id="signup" value="Register">
        <p>Already Have an Account ? <a href="loginPage.php">Login Now</a></p>
      </form>
    </div>
  </section>


</body>

</html>
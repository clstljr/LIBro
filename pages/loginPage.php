<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>LIbro || Login Form</title>
  
  <!-- Correct CSS paths -->
  <link rel="stylesheet" href="../assets/style.css">
  <link rel="stylesheet" href="../assets/index.css">
  
  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&display=swap" rel="stylesheet" />
  
  <!-- FontAwesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" />
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>

<body>
  <header>
    <nav class="navbar">
      <div class="logo">
        <div class="icon">
          <img src="../assets/image/LIBroLogo.png" alt="Library Management System Logo"> <!-- Correct path to logo -->
        </div>
        <div class="logo-details">
          <h5>LIbro</h5>
        </div>
      </div>
      <ul class="nav-list">
        <li><a href="../index.php">Home</a></li> <!-- Correct path to home -->
        <li><a href="#about">About</a></li>
        <li><a href="#contact">Contact Us</a></li>
      </ul>
      <div class="hamburger">
        <div class="line"></div>
        <div class="line"></div>
        <div class="line"></div>
      </div>
    </nav>
  </header>

  <style>
    .input-field .error {
      color: #FF3333;
      font-size: 14px;
    }
  </style>

  <section class="login">
    <form class="login-form" action="../include/login.php" method="POST"> <!-- Correct form action -->
      <h4>Login</h4>
      <?php
      if (isset($_GET['error'])) {
          echo "<p class='error'>" . htmlspecialchars($_GET['error']) . "</p>";
      }
      if (isset($_GET['message'])) {
          echo "<p class='success'>" . htmlspecialchars($_GET['message']) . "</p>";
      }
      ?>
      <div class="input-form">
        <div class="input-field">
          <label for="email">Email *</label>
          <input type="email" name="email" id="email" placeholder="Your Email" required>
        </div>
        <div class="input-field">
          <label for="password">Password *</label>
          <input type="password" name="password" id="password" placeholder="Password" required>
        </div>
        <input type="submit" name="lib-login" value="Login">
        <p>Don't Have an Account? <a href="registerPage.php">Signup Now</a></p> <!-- Correct path to registration -->
      </div>
    </form>
  </section>

  <footer>
    <div class="container">
      <div class="logo-description">
        <div class="logo">
          <div class="img">
            <i class='bx bx-book-reader'></i>
          </div>
          <div class="title">
            <h4>LIbro</h4>
          </div>
        </div>
        <div class="logo-body">
<<<<<<< HEAD:loginPage.php
          <p>
            Feed Your Mind, Anytime, Anywhere.
          </p>
=======
          <p>LIbro is a library management system designed to simplify book borrowing and management.</p>
>>>>>>> a20b3da9405b13ec3a44c1ef740a446bcb40adc4:pages/loginPage.php
        </div>
        <div class="social-links">
          <h4>Follow Us</h4>
          <ul class="links">
            <li><a href="#"><i class="fa-brands fa-facebook-f"></i></a></li>
            <li><a href="#"><i class="fa-brands fa-youtube"></i></a></li>
            <li><a href="#"><i class="fa-brands fa-twitter"></i></a></li>
            <li><a href="#"><i class="fa-brands fa-linkedin"></i></a></li>
            <li><a href="#"><i class="fa-brands fa-instagram"></i></a></li>
          </ul>
        </div>
      </div>
<<<<<<< HEAD:loginPage.php
=======
      <div class="categories list">
        <h4>Book Categories</h4>
        <ul>
          <li><a href="#">Fiction</a></li>
          <li><a href="#">Non-Fiction</a></li>
          <li><a href="#">Science</a></li>
          <li><a href="#">History</a></li>
          <li><a href="#">Biography</a></li>
          <li><a href="#">Fantasy</a></li>
        </ul>
      </div>
>>>>>>> a20b3da9405b13ec3a44c1ef740a446bcb40adc4:pages/loginPage.php
      <div class="quick-links list">
        <h4>Quick Links</h4>
        <ul>
          <li><a href="../index.php">Home</a></li> <!-- Correct path to home -->
          <li><a href="#contact">Contact Us</a></li>
          <li><a href="#about">About Us</a></li>
          <li><a href="../include/login.php">Login</a></li> <!-- Correct path to login -->
          <li><a href="#book">Find Books</a></li>
        </ul>
      </div>
      <div class="our-store list">
        <h4>Our Library</h4>
        <div class="map" style="margin-top: 1rem">
          <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d4810.766469366541!2d121.03795693070802!3d14.41434032224864!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3397d04c18edb14d%3A0xb5414d4cc0f9245!2sFEU%20Alabang!5e0!3m2!1sen!2sph!4v1748524901852!5m2!1sen!2sph" height="70" style="width: 100%; border: none; border-radius: 5px" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
        <ul>
          <li>
            <a href="#"><i class="fa-solid fa-location-dot"></i>C26Q+545 Wood District, Corporate Woods cor. South Corporate Avenues, Filinvest City, Muntinlupa City, 1781, Metro Manila, Philippines</a>
          </li>
          <li>
            <a href="#"><i class="fa-solid fa-phone"></i>+63 945 524 9264</a>
          </li>
          <li>
            <a href="#"><i class="fa-solid fa-envelope"></i>jaimin@masel.com</a>
          </li>
        </ul>
      </div>
    </div>
  </footer>

  <script>
    let hamburgerbtn = document.querySelector(".hamburger");
    let nav_list = document.querySelector(".nav-list");
    if (hamburgerbtn && nav_list) {
      hamburgerbtn.addEventListener("click", () => {
        nav_list.classList.add("active");
      });
    }
  </script>
</body>

</html>
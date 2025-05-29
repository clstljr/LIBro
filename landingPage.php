<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Library Management System(L.M.S) is simple Library system that is used by librarian for manageing records of books and perform some operations on it.">
  <meta name="keywords" content="LMS,lms,library management system,library software,library management" />
  <title>LIbro || Make Easy to Manage Records of Books</title>
  <link rel="stylesheet" href="assets/css/index.css">
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <!--- google font link-->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&display=swap" rel="stylesheet" />
  <!-- Fontawesome Link for Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" />
</head>

<body onload="preloader()">
  <!-- ?php include 'assets/loader/loader.php' ? -->
  <header>
    <nav class="navbar">
      <div class="logo">
        <div class="icon">
          <!-- <i class='bx bx-book-reader'></i> -->
          <img src="assets/images/LOGO.png" alt="Library Management System Logo">
        </div>
        <div class="logo-details">
          <h5>LIbro</h5>
        </div>
      </div>
      <ul class="nav-list">
        <div class="logo">
          <div class="title">
            <div class="icon">
            <img src="assets/images/LOGO.png" alt="Library Management System Logo">
            </div>
            <div class="logo-header">
              <h4>LIbro</h4>
              <small>Library System</small>
            </div>
          </div>
          <button class="close"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <li><a href="">Home</a></li>
        <li><a href="#about">About</a></li>
        <li><a href="#contact">Contact Us</a></li>
        <div class="login">
          <?php
          if (isset($_SESSION['loggedin'])) {
          ?>
            <a href="assets/panel/admin/dashboard.php" type="button" class="loginbtn">Dashboard</a>
          <?php
          } else if (isset($_SESSION['stdloggedin'])) {
          ?>
            <a href="assets/panel/student/std-dashboard.php">Dashboard</a>

          <?php
          } else {
          ?>
            <a href="pages/login.php" type="button" class="loginbtn">Log In</a>
          <?php
          }
          ?>
        </div>
      </ul>
      <div class="hamburger">
        <div class="line"></div>
        <div class="line"></div>
        <div class="line"></div>
      </div>
    </nav>
  </header>

  <section class="home">
    <div class="title">
      <h2>Welcome To <span>LIbro</span></h2>
      <p>Explore and Borrow Books Through Online</p>
      <div class="btns">
        <?php
        if (isset($_SESSION['loggedin'])) {
        ?>
          <button><a href="assets/panel/admin/dashboard.php">Dashboard</a></button>
        <?php
        } else if (isset($_SESSION['stdloggedin'])) {
        ?>
          <button><a href="assets/panel/student/std-dashboard.php">Dashboard</a></button>

        <?php
        } else {
        ?>
          <button><a href="pages/register.php">GET STARTED</a></button>

        <?php
        }
        ?>

        <button><a href="#book">Browse Books</a></button>
      </div>
    </div>
  </section>

  
  <section class="about-us" id="about">
    <div class="main">
      <div class="img">
        <img src="https://i.pinimg.com/originals/a7/4e/56/a74e56ce6107f0367195ea16e60bdd78.png" alt="About Us Image">
      </div>
      <div class="about-content">
        <h4>About Us</h4>
        <p>LIbro is a TODO TODO TODO TODO TODO TODO TODO TODO TODO TODO TODO TODO TODO TODO TODO TODO TODO TODO TODO TODO TODO TODO TODO TODO TODO TODO TODO TODO TODO TODO TODO TODO TODO TODO TODO TODO TODO TODO TODO TODO TODO TODO TODO TODO TODO TODO TODO TODO</p>
      </div>
    </div>
  </section>
  <section class="contact" id="contact">
    <h3>Contact Us</h3>
    <div class="main">
      <div class="map">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d4810.766469366541!2d121.03795693070802!3d14.41434032224864!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3397d04c18edb14d%3A0xb5414d4cc0f9245!2sFEU%20Alabang!5e0!3m2!1sen!2sph!4v1748524901852!5m2!1sen!2sph" width="100%" height="70" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
      </div>
      <div class="contact-form">
        <h4>Contact Us</h4>
        <p>Get in touch with us</p>
        <form class="input-form" method="POST" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>">
          <div class="input-field">
            <label for="name">Full Name *</label>
            <input type="text" name="name" id="name" placeholder="Full Name" />
            <?php
            if (isset($error['name'])) {
            ?>
              <p class="error-msg">
                <?php echo $error['name']; ?>
              </p>
            <?php
            }
            ?>
          </div>
          <div class="input-field">
            <label for="email">E-mail *</label>
            <input type="email" name="email" id="email" placeholder="Email Address" />
            <?php
            if (isset($error['email'])) {
            ?>
              <p class="error-msg">
                <?php echo $error['email']; ?>
              </p>
            <?php
            }
            ?>
          </div>
          <div class="input-field">
            <label for="phone">Phone No. *</label>
            <input type="text" name="mobile" id="phone" placeholder="Phone Number" />
            <?php
            if (isset($error['mobile'])) {
            ?>
              <p class="error-msg">
                <?php echo $error['mobile']; ?>
              </p>
            <?php
            }
            ?>
          </div>
          <div class="message">
            <label for="message">Message *</label>
            <textarea placeholder="Message" name="message" id="message"></textarea>
            <?php
            if (isset($error['message'])) {
            ?>
              <p class="error-msg">
                <?php echo $error['message']; ?>
              </p>
            <?php
            }
            ?>
          </div>
          <input type="submit" name="contact" value="SUBMIT">
          <!-- <button name="contact">SUBMIT</button> -->
        </form>
      </div>
      
    </div>
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
          <p>
            LIbro is a TODO
          </p>
        </div>
        <div class="social-links">
          <h4>Follow Us</h4>
          <ul class="links">
            <li>
              <a href=""><i class="fa-brands fa-facebook-f"></i></a>
            </li>
            <li>
              <a href=""><i class="fa-brands fa-youtube"></i></a>
            </li>
            <li>
              <a href=""><i class="fa-brands fa-twitter"></i></a>
            </li>
            <li>
              <a href=""><i class="fa-brands fa-linkedin"></i></a>
            </li>
            <li>
              <a href=""><i class="fa-brands fa-instagram"></i></a>
            </li>
          </ul>
        </div>
      </div>
      <div class="categories list">
        <h4>Book Categories</h4>
        <ul>
          <li><a href="#">TODO</a></li>
          <li><a href="#">TODO</a></li>
          <li><a href="#">TODO</a></li>
          <li><a href="#">TODO</a></li>
          <li><a href="#">TODO</a></li>
          <li><a href="#">TODO</a></li>
        </ul>
      </div>
      <div class="quick-links list">
        <h4>Quick Links</h4>
        <ul>
          <li><a href="index.php">Home</a></li>
          <li><a href="#contact">Contact Us</a></li>
          <li><a href="#about">About Us</a></li>
          <li><a href="pages/login.php">Login</a></li>
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
            <a href=""><i class="fa-solid fa-location-dot"></i>C26Q+545 Wood District, Corporate Woods cor. South Corporate Avenues, Filinvest City, Muntinlupa City, 1781, Metro Manila, Philippines</a>
          </li>
          <li>
            <a href=""><i class="fa-solid fa-phone"></i>+63 945 524 9264</a>
          </li>
          <li>
            <a href=""><i class="fa-solid fa-envelope"></i>jaimin@masel.com</a>
          </li>
        </ul>
      </div>
    </div>
  </footer>
  <script>
    let hamburgerbtn = document.querySelector(".hamburger");
    let nav_list = document.querySelector(".nav-list");
    let closebtn = document.querySelector(".close");
    hamburgerbtn.addEventListener("click", () => {
      nav_list.classList.add("active");
    });
    closebtn.addEventListener("click", () => {
      nav_list.classList.remove("active");
    });
  </script>
</body>

</html>
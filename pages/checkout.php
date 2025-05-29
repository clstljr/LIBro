<?php
session_start();
require 'config.php';

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION["user_id"];

// Get user info (username, email, address, phone)
$stmt = $conn->prepare("SELECT username, email, address, phone FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$userResult = $stmt->get_result();
if ($userResult->num_rows > 0) {
    $userInfo = $userResult->fetch_assoc();
} else {
    die("User not found.");
}
$stmt->close();

// Get cart items with book info
$stmt = $conn->prepare("
    SELECT b.id, b.title, b.author, b.price, b.image, ci.quantity
    FROM cart_items ci
    JOIN books b ON ci.book_id = b.id
    WHERE ci.user_id = ?
");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$cartResult = $stmt->get_result();

if ($cartResult->num_rows === 0) {
    die("Your cart is empty.");
}

// Handle checkout
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm_checkout'])) {
    // Update user information
    $new_address = trim($_POST['address']);
    $new_phone = trim($_POST['phone']);

    $stmtUpdate = $conn->prepare("UPDATE users SET address = ?, phone = ? WHERE id = ?");
    $stmtUpdate->bind_param("ssi", $new_address, $new_phone, $user_id);
    $stmtUpdate->execute();
    $stmtUpdate->close();

    // Insert purchases with address and phone
    $stmtInsert = $conn->prepare("INSERT INTO purchases (user_id, book_id, quantity, address, phone) VALUES (?, ?, ?, ?, ?)");

    while ($item = $cartResult->fetch_assoc()) {
        $stmtInsert->bind_param("iiiss", $user_id, $item['id'], $item['quantity'], $new_address, $new_phone);
        $stmtInsert->execute();
    }
    $stmtInsert->close();

    // Clear cart
    $stmtClear = $conn->prepare("DELETE FROM cart_items WHERE user_id = ?");
    $stmtClear->bind_param("i", $user_id);
    $stmtClear->execute();
    $stmtClear->close();

    // Redirect to dashboard with success message
    header("Location: dashboard.php?checkout=success");
    exit;
}

// Reset cartResult pointer to reuse for display
$cartResult->data_seek(0);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LIbro || Checkout</title>
    <link rel="stylesheet" href="../assets/css/index.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" />
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&display=swap" rel="stylesheet" />
    <style>
      .checkout-section {
        display: flex;
        flex-direction: row;
        align-items: flex-start;
        justify-content: center;
        min-height: 70vh;
        background: #f8f9fa;
        gap: 32px;
        padding: 40px 0 0 0;
      }
      .checkout-form {
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 4px 24px rgba(0,0,0,0.08);
        padding: 32px 32px 24px 32px;
        max-width: 350px;
        width: 100%;
        margin-bottom: 0;
      }
      .checkout-form h2 {
        margin-bottom: 18px;
        font-size: 2rem;
        color: #2d3a4b;
        text-align: center;
      }
      .checkout-form label {
        font-weight: 500;
        color: #2d3a4b;
      }
      .checkout-form input[type="text"] {
        width: 100%;
        padding: 10px 12px;
        border: 1px solid #d1d5db;
        border-radius: 6px;
        margin-bottom: 18px;
        font-size: 1rem;
        background: #f5f6fa;
      }
      .checkout-form .info-row {
        margin-bottom: 10px;
      }
      .order-summary {
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 4px 24px rgba(0,0,0,0.08);
        padding: 28px 28px 18px 28px;
        max-width: 420px;
        width: 100%;
        margin-bottom: 32px;
        display: flex;
        flex-direction: column;
        align-items: center;
      }
      .order-summary h3 {
        margin-bottom: 16px;
        color: #2d3a4b;
        font-size: 1.3rem;
      }
      .order-summary-list {
        width: 100%;
        display: flex;
        flex-direction: column;
        gap: 18px;
      }
      .order-item {
        display: flex;
        align-items: flex-start;
        gap: 16px;
        background: #f7f7fa;
        border-radius: 10px;
        padding: 14px 16px;
        box-shadow: 0 1px 4px rgba(108,93,212,0.04);
        position: relative;
      }
      .order-item-img img {
        width: 60px;
        height: 80px;
        object-fit: cover;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.06);
      }
      .order-item-details {
        flex: 1;
        display: flex;
        flex-direction: column;
        gap: 4px;
      }
      .order-item-title {
        font-size: 1.08rem;
        font-weight: 600;
        color: #2d3a4b;
      }
      .order-item-author {
        font-size: 0.95rem;
        color: #6c5dd4;
        font-style: italic;
      }
      .order-item-meta {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 6px;
        font-size: 0.98rem;
        color: #444;
      }
      .order-item-subtotal {
        font-weight: 600;
        color: #2d3a4b;
      }
      .order-summary-total {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 1.15rem;
        font-weight: 700;
        color: #2d3a4b;
        border-top: 2px solid #ececec;
        padding-top: 16px;
        margin-top: 10px;
      }
      .checkout-btn-wrapper {
        display: flex;
        justify-content: center;
        align-items: center;
        margin: 32px 0 48px 0;
      }
      .checkout-btn {
        background: #6c5dd4;
        color: #fff;
        border: none;
        border-radius: 6px;
        padding: 14px 48px;
        font-size: 1.1rem;
        font-weight: 600;
        cursor: pointer;
        transition: background 0.2s;
        box-shadow: 0 2px 8px rgba(0,0,0,0.07);
      }
      .checkout-btn:hover {
        background:rgb(103, 36, 226);
      }
      .back-link {
        display: inline-block;
        margin-bottom: 18px;
        color: #2d3a4b;
        text-decoration: none;
        font-weight: 500;
        transition: color 0.2s;
      }
      .back-link:hover {
        color:rgb(125, 57, 233);
      }
      /* Footer Styles */
      footer {
        background:rgb(255, 255, 255);
        color: #fff;
        padding: 32px 0 16px 0;
        margin-top: 40px;
      }
      .logo-description {
        display: flex;
        flex-direction: column;
        align-items: center;
        margin-bottom: 24px;
      }
      .logo {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 8px;
      }
      .logo .img {
        font-size: 2.5rem;
        color: #a084e8;
      }
      .logo .title h4 {
        margin: 0;
        font-size: 1.8rem;
        font-weight: 700;
        color: #fff;
      }
      .logo-body {
        text-align: center;
        margin-bottom: 16px;
      }
      .logo-body p {
        margin: 0;
        font-size: 0.95rem;
        color: #e0e7ff;
      }
      .social-links {
        margin-top: 8px;
      }
      .social-links h4 {
        margin: 0 0 8px 0;
        font-size: 1rem;
        color: #fff;
        text-align: center;
      }
      .social-links .links {
        display: flex;
        gap: 12px;
        justify-content: center;
        list-style: none;
        padding: 0;
        margin: 0;
      }
      .social-links .links li a {
        color: #a084e8;
        font-size: 1.2rem;
        transition: color 0.2s;
      }
      .social-links .links li a:hover {
        color: #fff;
      }
      .categories, .quick-links, .our-store {
        max-width: 300px;
        width: 100%;
        margin: 0 auto 24px auto;
      }
      .categories h4, .quick-links h4, .our-store h4 {
        margin-bottom: 12px;
        font-size: 1.2rem;
        color: #fff;
        text-align: center;
      }
      .categories ul, .quick-links ul, .our-store ul {
        list-style: none;
        padding: 0;
        margin: 0;
        color: #e0e7ff;
        font-size: 0.9rem;
      }
      .categories ul li, .quick-links ul li, .our-store ul li {
        margin-bottom: 8px;
      }
      .categories ul li a, .quick-links ul li a, .our-store ul li a {
        color: #a084e8;
        text-decoration: none;
        transition: color 0.2s;
      }
      .categories ul li a:hover, .quick-links ul li a:hover, .our-store ul li a:hover {
        color: #fff;
      }
      .our-store .map {
        width: 100%;
        border-radius: 8px;
        overflow: hidden;
        margin-bottom: 12px;
      }
      .our-store ul {
        display: flex;
        flex-direction: column;
        gap: 8px;
      }
      .our-store ul li {
        display: flex;
        align-items: center;
        gap: 8px;
        color: #e0e7ff;
      }
      .our-store ul li i {
        color: #a084e8;
      }
      .footer-copy {
        margin-top: 10px;
        font-size: 0.95rem;
        color: #bfc9d1;
        text-align: center;
      }
      @media (max-width: 900px) {
        .checkout-section {
          flex-direction: column;
          align-items: center;
          gap: 24px;
        }
        .checkout-form, .order-summary {
          max-width: 95vw;
        }
        .checkout-btn-wrapper {
          margin: 24px 0 32px 0;
        }
        .footer-container {
          padding: 0 10px;
        }
        .logo-description {
          text-align: center;
        }
        .categories, .quick-links, .our-store {
          max-width: 100%;
        }
      }
    </style>
</head>
<body onload="preloader()">
  <header>
    <nav class="navbar">
      <div class="logo">
        <div class="icon">
          <img src="../assets/images/LIBroLogo.png" alt="Library Management System Logo">
        </div>
        <div class="logo-details">
          <h5>LIbro</h5>
        </div>
      </div>
      <div class="hamburger">
        <div class="line"></div>
        <div class="line"></div>
        <div class="line"></div>
      </div>
    </nav>
  </header>
  <section class="checkout-section split-layout">
    <form class="checkout-form" method="post">
      <h2>Checkout</h2>
      <a href="cart.php" class="back-link"><i class="fa fa-arrow-left"></i> Back to Cart</a>
      <div class="info-row"><label><strong>Name:</strong></label> <?= htmlspecialchars($userInfo['username']) ?></div>
      <div class="info-row"><label><strong>Email:</strong></label> <?= htmlspecialchars($userInfo['email']) ?></div>
      <div class="info-row">
        <label for="address"><strong>Address:</strong></label>
        <input type="text" name="address" id="address" value="<?= htmlspecialchars($userInfo['address']) ?>" required>
      </div>
      <div class="info-row">
        <label for="phone"><strong>Phone:</strong></label>
        <input type="text" name="phone" id="phone" value="<?= htmlspecialchars($userInfo['phone']) ?>" required>
      </div>
    </form>
    <div class="order-summary">
      <h3>Order Summary</h3>
      <div class="order-summary-list">
        <?php
        $total = 0;
        $cartResult->data_seek(0);
        while ($row = $cartResult->fetch_assoc()):
            $subtotal = $row['price'] * $row['quantity'];
            $total += $subtotal;
        ?>
        <div class="order-item">
          <div class="order-item-img">
            <img src="/LIBro/uploads/<?= htmlspecialchars($row['image']) ?>" alt="<?= htmlspecialchars($row['title']) ?>">
          </div>
          <div class="order-item-details">
            <div class="order-item-title"><?= htmlspecialchars($row['title']) ?></div>
            <div class="order-item-author">by <?= htmlspecialchars($row['author']) ?></div>
            <div class="order-item-meta">
              <span>₱<?= number_format($row['price'], 2) ?> x <?= $row['quantity'] ?></span>
              <span class="order-item-subtotal">₱<?= number_format($subtotal, 2) ?></span>
            </div>
          </div>
        </div>
        <?php endwhile; ?>
        <div class="order-summary-total">
          <span>Total</span>
          <span>₱<?= number_format($total, 2) ?></span>
        </div>
      </div>
    </div>
  </section>
  <div class="checkout-btn-wrapper">
    <form method="post" style="display:inline;">
      <button type="submit" name="confirm_checkout" class="checkout-btn">Confirm and Checkout</button>
    </form>
  </div>
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
      <div class="quick-links list">
        <h4>Quick Links</h4>
        <ul>
          <li><a href="../index.php">Home</a></li>
          <li><a href="#contact">Contact Us</a></li>
          <li><a href="#about">About Us</a></li>
          <li><a href="login.php">Login</a></li>
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
    if(hamburgerbtn && nav_list) {
      hamburgerbtn.addEventListener("click", () => {
        nav_list.classList.add("active");
      });
    }
  </script>
</body>
</html>

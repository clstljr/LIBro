<?php
session_start();
require 'config.php';

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

// Fetch books
$books = [];
$result = $conn->query("SELECT * FROM books ORDER BY id DESC");
while ($row = $result->fetch_assoc()) {
    $books[] = $row;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Library Management System || Dashboard</title>
  <link rel="stylesheet" href="../assets/css/main.css" />
  <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&display=swap" rel="stylesheet" />
  <style>
    .dashboard-books {
      margin-top: 2.5rem;
      background: #fff;
      border-radius: 16px;
      box-shadow: 0 4px 24px rgba(0,0,0,0.08);
      padding: 32px 24px;
      max-width: 1100px;
      margin-left: auto;
      margin-right: auto;
    }
    .dashboard-books h3 {
      color: #6c5dd4;
      font-size: 1.5rem;
      margin-bottom: 1.5rem;
      border-bottom: 2px solid #ececec;
      padding-bottom: 8px;
      text-align: left;
    }
    .dashboard-book-list {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
      gap: 28px;
    }
    .dashboard-book-item {
      background: #f7f7fa;
      border-radius: 12px;
      box-shadow: 0 2px 8px rgba(108,93,212,0.04);
      padding: 18px 14px 16px 14px;
      display: flex;
      flex-direction: column;
      align-items: center;
      transition: box-shadow 0.2s, transform 0.2s;
      border: 1px solid #ececec;
    }
    .dashboard-book-item:hover {
      box-shadow: 0 8px 24px rgba(108,93,212,0.10);
      transform: translateY(-4px) scale(1.03);
    }
    .dashboard-book-item img {
      width: 110px;
      height: 150px;
      object-fit: cover;
      border-radius: 8px;
      margin-bottom: 10px;
      background: #fff;
      box-shadow: 0 2px 8px rgba(0,0,0,0.06);
    }
    .dashboard-book-title {
      font-size: 1.08rem;
      font-weight: 600;
      color: #2d3a4b;
      margin-bottom: 2px;
      text-align: center;
    }
    .dashboard-book-author {
      font-size: 0.97rem;
      color: #6c5dd4;
      font-style: italic;
      margin-bottom: 6px;
      text-align: center;
    }
    .dashboard-book-price {
      font-size: 1.05rem;
      color: #444;
      margin-bottom: 10px;
      font-weight: 500;
    }
    .dashboard-book-item form {
      width: 100%;
      display: flex;
      justify-content: center;
      margin-top: 16px; /* Add gap above the button */
    }
    .dashboard-book-item button {
      background: #6c5dd4;
      color: #fff;
      border: none;
      border-radius: 6px;
      padding: 8px 18px;
      font-size: 1rem;
      font-weight: 500;
      cursor: pointer;
      transition: background 0.2s;
    }
    .dashboard-book-item button:hover {
      background: #4b3bbd;
    }
    .dashboard-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 1.5rem;
      gap: 1rem;
      margin-top: 32px;
      margin-left: 32px;
    }
    .dashboard-header h2 {
      color: #6c5dd4;
      font-size: 2rem;
      margin: 0;
    }
    .dashboard-header .dashboard-links {
      display: flex;
      gap: 1.2rem;
      flex-wrap: wrap;
    }
    .dashboard-header .dashboard-links a {
      background: #f7f7fa;
      color: #6c5dd4;
      border-radius: 6px;
      padding: 8px 16px;
      font-weight: 500;
      text-decoration: none;
      border: 1px solid #ececec;
      transition: background 0.2s, color 0.2s;
    }
    .dashboard-header .dashboard-links a:hover {
      background: #6c5dd4;
      color: #fff;
    }
    .notification {
      background: #e6ffe6;
      color: #1a7f37;
      border: 1px solid #b2f2b2;
      border-radius: 6px;
      padding: 12px 18px;
      margin: 18px auto 0 auto;
      max-width: 500px;
      text-align: center;
      font-size: 1.1rem;
    }
  </style>
</head>
<body onload="preloader()">
<?php include 'includes/sidebar.php'; ?>
<section class="home-section">
  <div class="dashboard-header" style="margin-top: 32px;">
    <h2>Welcome, <?= htmlspecialchars($_SESSION["user_name"]) ?>!</h2>
    <div class="dashboard-links">
      <a href="../LIBro/addBookPage.php">Publish a Book</a>
      <a href="orders.php">My Purchases</a>
      <a href="cart.php">My Cart</a>
      <a href="logout.php">Logout</a>
    </div>
  </div>
  <div class="dashboard-books">
    <h3>Available Books</h3>
    <?php if (empty($books)) : ?>
      <p>No books available yet.</p>
    <?php else : ?>
      <div class="dashboard-book-list">
        <?php foreach ($books as $book): ?>
          <div class="dashboard-book-item">
            <?php if ($book['image']): ?>
              <img src="/LIBro/uploads/<?= htmlspecialchars($book['image']) ?>" alt="<?= htmlspecialchars($book['title']) ?>">
            <?php endif; ?>
            <div class="dashboard-book-title"><?= htmlspecialchars($book['title']) ?></div>
            <div class="dashboard-book-author">by <?= htmlspecialchars($book['author']) ?></div>
            <div class="dashboard-book-price">₱<?= number_format($book['price'], 2) ?></div>
            <form method="post" action="add_to_cart.php">
              <input type="hidden" name="book_id" value="<?= $book['id'] ?>">
              <button type="submit">Add to Cart</button>
            </form>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>
  <?php if (isset($_GET['added'])): ?>
    <p style="color: green;">Book added to cart successfully!</p>
  <?php endif; ?>
  <?php if (isset($_GET['checkout']) && $_GET['checkout'] === 'success'): ?>
    <div class="notification">
      <p>Your order has been placed successfully and will arrive soon!</p>
    </div>
  <?php endif; ?>
</section>
<script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
</body>
</html>

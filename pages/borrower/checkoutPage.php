<!DOCTYPE html>
<html lang="en">
<head>
    <title>Checkout</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../assets/style.css">
    <link rel="stylesheet" href="../../assets/index.css">
    <link rel="stylesheet" href="../../assets/dashboardBorrowerPage.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" />
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <style>
      .book-list {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(340px, 1fr));
        gap: 32px;
        align-items: stretch;
        margin-bottom: 2rem;
      }

      .book-item {
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 4px 16px rgba(108,93,212,0.08);
        padding: 32px 24px;
        display: flex;
        flex-direction: row;
        align-items: center;
        border: 1px solid #ececec;
        min-height: 220px;
        height: 100%;
        box-sizing: border-box;
        overflow: hidden;
      }

      .book-item img {
        width: 120px;
        height: 180px;
        object-fit: cover;
        border-radius: 12px;
        margin-right: 32px;
        background: #fff;
        box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        flex-shrink: 0;
      }

      .book-info {
        flex: 1 1 0;
        display: flex;
        flex-direction: column;
        justify-content: center;
      }
    </style>
</head>
<body>
  <div class="dashboard-container">
    <aside class="sidebar">
      <div class="sidebar-logo">
        <img src="../../assets/image/LIBroLogo.png" alt="LIbro Logo" style="width:40px; height:40px; object-fit:contain;" />
        <span>LIbro</span>
      </div>
      <ul class="sidebar-links">
        <li><a href="dashboardBorrowerPage.php"><i class="fa-solid fa-book"></i> Dashboard</a></li>
        <li><a href="myshelfPage.php"><i class="fa-solid fa-book"></i> My Shelf</a></li>
        <li><a href="rules.php"><i class="fa-solid fa-gavel"></i> Rules</a></li>
        <li><a href="../../include/logout.php"><i class="fa-solid fa-right-from-bracket"></i> Logout</a></li>
      </ul>
    </aside>
    <main class="main-section">
      <h2>Checkout</h2>
      <?php include '../../include/borrower/checkout.php'; ?>
      <div style="margin-bottom:2rem;">
        <p><strong>Name:</strong> <?php echo htmlspecialchars($user['first_name'] . ' ' . $user['last_name']); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
      </div>
      <h3>Books in Your Cart:</h3>
      <div class="book-list">
        <?php while ($book = $cart->fetch_assoc()) { ?>
          <div class="book-item">
            <img src="../../uploads/<?php echo htmlspecialchars($book['image']); ?>" alt="<?php echo htmlspecialchars($book['title']); ?>">
            <div class="book-info">
              <h4><?php echo htmlspecialchars($book['title']); ?></h4>
              <p><?php echo htmlspecialchars($book['author']); ?></p>
            </div>
          </div>
        <?php } ?>
      </div>
      <div style="display: flex; flex-direction: column; align-items: center; margin-top: 2rem; gap: 16px;">
        <form action="../../include/borrower/confirmBorrow.php" method="POST" style="margin:0; width: 100%; display: flex; justify-content: center;">
          <button type="submit" name="confirm_checkout" style="background:#6c5dd4; color:#fff; border:none; border-radius:8px; padding:12px 36px; font-size:1.1rem; font-weight:600; cursor:pointer; transition:background 0.2s;">Yes, I Agree</button>
        </form>
      </div>
    </main>
  </div>
</body>
</html>
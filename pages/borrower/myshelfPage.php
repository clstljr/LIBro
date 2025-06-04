<!DOCTYPE html>
<html lang="en">
<head>
    <title>My Shelf</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../assets/style.css">
    <link rel="stylesheet" href="../../assets/index.css">
    <link rel="stylesheet" href="../../assets/dashboardBorrowerPage.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" />
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
</head>
<body>
  <div class="dashboard-container">
    <aside class="sidebar">
      <div class="sidebar-logo">
        <img src="../../assets/image/LIBroLogo.png" alt="LIbro Logo" style="width:40px; height:40px; object-fit:contain;" />
        <span>LIbro</span>
      </div>
      <ul class="sidebar-links">
        <li><a href="myshelfPage.php" class="active"><i class="fa-solid fa-book"></i> My Shelf</a></li>
        <li><a href="rules.php"><i class="fa-solid fa-gavel"></i> Rules</a></li>
        <li><a href="../../include/logout.php"><i class="fa-solid fa-right-from-bracket"></i> Logout</a></li>

      </ul>
    </aside>
    <main class="main-section">
      <a href="dashboardBorrowerPage.php" style="color:#6c5dd4; font-weight:600; text-decoration:none; display:inline-block; margin-bottom:1.5rem;"><i class="fa fa-arrow-left"></i> Back to Dashboard</a>
      <h2>My Shelf</h2>
      <?php if (isset($_GET['error'])) { ?>
        <p class="success-message" style="color: red;"><?php echo htmlspecialchars($_GET['error']); ?></p>
      <?php } ?>
      <div class="book-list">
        <?php include '../../include/borrower/myshelf.php'; ?>
        <?php while ($book = $result->fetch_assoc()) { ?>
          <div class="book-item">
            <img src="../../uploads/<?php echo htmlspecialchars($book['image']); ?>" alt="<?php echo htmlspecialchars($book['title']); ?>">
            <div class="book-info">
              <h4><?php echo htmlspecialchars($book['title']); ?></h4>
              <p><?php echo htmlspecialchars($book['author']); ?></p>
              <div class="stock">Quantity: <?php echo htmlspecialchars($book['quantity']); ?></div>
              <div style="display:flex; gap:12px; margin-top:10px;">
                <form action="../../include/borrower/removeFromShelf.php" method="POST" style="margin:0;">
                  <input type="hidden" name="book_id" value="<?php echo htmlspecialchars($book['book_id']); ?>">
                  <button type="submit">Remove</button>
                </form>
              </div>
            </div>
          </div>
        <?php } ?>
      </div>
      <form action="checkoutPage.php" method="GET" style="margin:0; width: 100%; display: flex; justify-content: center;">
        <input type="hidden" name="book_id" value="<?php echo htmlspecialchars($book['book_id']); ?>">
        <button type="submit" name="confirm_checkout">Check Out</button>
        </form>
    </main>
  </div>
</body>
</html>
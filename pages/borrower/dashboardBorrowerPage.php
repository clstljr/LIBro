<!DOCTYPE html>
<html lang="en">
<head>
    <title>Borrower Dashboard</title>
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
        <li><a href="myshelfPage.php"><i class="fa-solid fa-book"></i> My Shelf</a></li>
        <li><a href="../../include/logout.php"><i class="fa-solid fa-right-from-bracket"></i> Logout</a></li>
      </ul>
    </aside>
    <main class="main-section">
      <?php include '../../include/borrower/dashboardBorrower.php'; ?>
      <!-- Display success message -->
      <?php if (isset($_GET['message'])) { ?>
          <p class="success-message"><?php echo htmlspecialchars($_GET['message']); ?></p>
      <?php } ?>

      <h2>Available Books</h2>
      <?php if (!empty($booksByCategory)) { ?>
          <?php foreach ($booksByCategory as $category => $books) { ?>
              <h3 class="<?php echo strtolower($category) === 'fiction' ? 'fiction-title' : ''; ?><?php echo strtolower($category) === 'biography' ? ' biography-title' : ''; ?>">
                  <?php echo htmlspecialchars($category); ?>
              </h3>
              <div class="book-list<?php echo strtolower($category) === 'fiction' ? ' fiction-list' : ''; ?><?php echo strtolower($category) === 'biography' ? ' biography-list' : ''; ?>">
                  <?php foreach ($books as $book) { ?>
                      <div class="book-item">
                          <img src="../../uploads/<?php echo htmlspecialchars($book['image']); ?>" alt="<?php echo htmlspecialchars($book['title']); ?>">
                          <div class="book-info">
                              <h4><?php echo htmlspecialchars($book['title']); ?></h4>
                              <p><?php echo htmlspecialchars($book['author']); ?></p>
                              <div class="stock">Stock: <?php echo htmlspecialchars($book['stock']); ?></div>
                              <form action="../../include/borrower/borrowBook.php" method="POST">
                                  <input type="hidden" name="book_id" value="<?php echo htmlspecialchars($book['id']); ?>">
                                  <button type="submit" <?php echo $book['stock'] == 0 ? 'disabled' : ''; ?>>Borrow Now</button>
                              </form>
                          </div>
                      </div>
                  <?php } ?>
              </div>
          <?php } ?>
      <?php } else { ?>
          <p class="no-books">No books available at the moment.</p>
      <?php } ?>
    </main>
  </div>
</body>
</html>
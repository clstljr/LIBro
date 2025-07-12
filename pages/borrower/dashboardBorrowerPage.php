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
    <style>
        .book-list {
          display: flex;
          flex-wrap: wrap;
          gap: 32px;
          justify-content: flex-start; /* Add this line */
        }

        .book-item {
          background: #fff;
          border-radius: 16px;
          box-shadow: 0 4px 16px rgba(108,93,212,0.08);
          padding: 32px 24px;
          display: flex;
          flex-direction: column;
          align-items: stretch;
          border: 1px solid #ececec;
          min-height: 600px; /* Adjust as needed */
          width: 400px;      /* Adjust as needed for uniform width */
          box-sizing: border-box;
        }

        .book-item img {
          width: 150px;
          height: 240px;
          object-fit: cover;
          border-radius: 12px;
          margin: 0 auto 16px auto;
          background: #fff;
          box-shadow: 0 2px 8px rgba(0,0,0,0.06);
          display: block;
        }

        .book-item .description {
          overflow: hidden;
          text-overflow: ellipsis;
          display: -webkit-box;
          -webkit-line-clamp: 3; /* Show 3 lines */
          -webkit-box-orient: vertical;
          min-height: 60px; /* Adjust for consistent height */
        }
        .styled-select {
  background: #6c5dd4;
  color: #fff;
  border: none;
  border-radius: 8px;
  padding: 10px 28px;
  font-size: 1.08rem;
  font-weight: 600;
  cursor: pointer;
  transition: background 0.2s;
  appearance: none;
  -webkit-appearance: none;
  -moz-appearance: none;
}
.styled-select:focus {
  outline: 2px solid #4b3bbd;
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
        <li><a href="dashboardBorrowerPage.php" class="active"><i class="fa-solid fa-book"></i> Dashboard</a></li>
        <li><a href="myshelfPage.php"><i class="fa-solid fa-book"></i> My Shelf</a></li>
        <li><a href="rules.php"><i class="fa-solid fa-gavel"></i> Rules</a></li>
        <li><a href="../../include/logout.php"><i class="fa-solid fa-right-from-bracket"></i> Logout</a></li>
      </ul>
    </aside>
    <main class="main-section">
      <?php include '../../include/borrower/dashboardBorrower.php'; ?>
      <!-- Display success message -->
      <?php if (isset($_GET['message'])) { ?>
          <p class="success-message"><?php echo htmlspecialchars($_GET['message']); ?></p>
      <?php } ?>

      <?php
$selectedCategory = isset($_GET['category']) ? $_GET['category'] : '';
if ($selectedCategory && isset($booksByCategory[$selectedCategory])) {
    $categoriesToShow = [$selectedCategory => $booksByCategory[$selectedCategory]];
} else {
    $categoriesToShow = $booksByCategory;
}
?>
<h2>Available Books</h2>

<form method="GET" id="categoryFilterForm" style="margin-bottom: 1.5rem; display: flex; align-items: center; gap: 16px; max-width: 420px;">
  <label for="categoryFilter" style="font-weight:600; color:#6c5dd4; white-space:nowrap;">Filter by Category:</label>
  <select name="category" id="categoryFilter" class="styled-select" style="min-width: 160px; max-width: 220px; padding: 10px 18px;" onchange="this.form.submit()">
    <option value="">All Categories</option>
    <?php foreach (array_keys($booksByCategory) as $cat): ?>
      <option value="<?php echo htmlspecialchars($cat); ?>" <?php if(isset($_GET['category']) && $_GET['category'] === $cat) echo 'selected'; ?>>
        <?php echo htmlspecialchars($cat); ?>
      </option>
    <?php endforeach; ?>
  </select>
</form>
<?php if (!empty($categoriesToShow)) { ?>
    <?php foreach ($categoriesToShow as $category => $books) { ?>
        <h3><?php echo htmlspecialchars($category); ?></h3>
        <div class="book-list">
            <?php foreach ($books as $book) { ?>
                <div class="book-item">
                    <img src="../../uploads/<?php echo htmlspecialchars($book['image']); ?>" alt="<?php echo htmlspecialchars($book['title']); ?>">
                    <div class="book-info">
                        <h4><?php echo htmlspecialchars($book['title']); ?></h4>
                        <p><?php echo htmlspecialchars($book['author']); ?></p>
                        <div class="description">Description: <?php echo htmlspecialchars($book['description']); ?></div>
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
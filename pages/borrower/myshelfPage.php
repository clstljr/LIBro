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
    <style>
      .book-list {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
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
        align-items: stretch;
        border: 1px solid #ececec;
        min-height: 260px;
        box-sizing: border-box;
        overflow: hidden;
      }

      .book-item img {
        width: 120px;
        height: 220px;
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

      .book-item h4 {
        font-size: 1.25rem;
        font-weight: 700;
        color: #2d3a4b;
        margin-bottom: 4px;
      }

      .book-item p {
        font-size: 1.08rem;
        color: #6c5dd4;
        font-style: italic;
        margin-bottom: 6px;
      }

      .book-item .description {
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        min-height: 60px;
      }

      .book-item form {
        display: flex;
        justify-content: flex-end;
        margin-top: 10px;
      }

      .book-item button {
        background: #6c5dd4;
        color: #fff;
        border: none;
        border-radius: 8px;
        padding: 10px 28px;
        font-size: 1.08rem;
        font-weight: 600;
        cursor: pointer;
        transition: background 0.2s;
      }
      .book-item button:hover {
        background: #4b3bbd;
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
        <li><a href="myshelfPage.php" class="active"><i class="fa-solid fa-book"></i> My Shelf</a></li>
        <li><a href="rules.php"><i class="fa-solid fa-gavel"></i> Rules</a></li>
        <li><a href="../../include/logout.php"><i class="fa-solid fa-right-from-bracket"></i> Logout</a></li>

      </ul>
    </aside>
    <main class="main-section">
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
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Library Rules</title>
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
        <li><a href="dashboardBorrowerPage.php"><i class="fa-solid fa-book"></i> Dashboard</a></li>
        <li><a href="myshelfPage.php"><i class="fa-solid fa-book"></i> My Shelf</a></li>
        <li><a href="rules.php" class="active"><i class="fa-solid fa-gavel"></i> Rules</a></li>
        <li><a href="../../include/logout.php"><i class="fa-solid fa-right-from-bracket"></i> Logout</a></li>
      </ul>
    </aside>
    <main class="main-section">
      <h2>Library Borrowing Rules</h2>
      <div class="rules-list" style="margin-top: 20px; background: #f9f9f9; padding: 20px; border-radius: 8px; box-shadow: 0 2px 6px rgba(0,0,0,0.1);">
        <ul style="line-height: 1.8; font-size: 1.05rem;">
          <li><strong>One copy of a book per borrower:</strong> You are only allowed to borrow one copy of one book at a time.</li>
          <li><strong>Maximum borrowing period:</strong> You may borrow a book for up to <strong>2 weeks</strong> (14 days).</li>
          <li><strong>Late return penalty:</strong> If the book is not returned on time, a fee of <strong>₱50 per day</strong> will be charged.</li>
          <li><strong>Damaged books:</strong> Any damage to a book will result in a fine of <strong>₱500–₱1000</strong> depending on the severity and value of the book.</li>
          <li><strong>Further violations:</strong> Repeated offenses may lead to suspension of borrowing privileges.</li>
        </ul>
      </div>
    </main>
  </div>
</body>
</html>

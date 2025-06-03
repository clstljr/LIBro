<?php include '../../include/librarian/dashboardLibrarian.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Librarian Dashboard</title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../../assets/style.css" />
    <link rel="stylesheet" href="../../assets/main.css" />
    <link rel="stylesheet" href="../../assets/dashboardBorrowerPage.css" />
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" />
</head>
<body>
  <div class="dashboard-container" style="display:flex; min-height:100vh;">
    <aside class="sidebar" style="width:220px; min-width:220px; background:#fff; box-shadow:2px 0 16px rgba(108,93,212,0.07); display:flex; flex-direction:column;">
      <div class="sidebar-logo" style="display:flex; align-items:center; gap:0.7rem; padding:2rem 1.5rem 1.2rem 1.5rem;">
        <img src="../../assets/image/LIBroLogo.png" alt="LIbro Logo" style="width:40px; height:40px; object-fit:contain;" />
        <span style="font-size:1.3rem; font-weight:700; color:#6c5dd4; letter-spacing:1px;">LIbro</span>
      </div>
      <ul class="sidebar-links" style="list-style:none; padding:0; margin:0; display:flex; flex-direction:column; gap:0.5rem;">
        <li><a href="dashboardLibrarianPage.php" class="sidebar-link active"><i class="fa-solid fa-chart-line"></i> Dashboard</a></li>
        <li><a href="addbookPage.php" class="sidebar-link"><i class="fa-solid fa-plus"></i> Add Book</a></li>
        <li><a href="addlibrarianPage.php" class="sidebar-link"><i class="fa-solid fa-user-plus"></i> Add Librarian</a></li>
        <li><a href="../../include/logout.php" class="sidebar-link"><i class="fa-solid fa-right-from-bracket"></i> Logout</a></li>
      </ul>
    </aside>
    <main class="main-section" style="flex:1; padding:2.5rem 2.5rem 2.5rem 2rem; background:#faf9fb; min-height:100vh;">
      <h2 style="color:#6c5dd4; margin-left: 250px; font-size:2rem; font-weight:700; margin-bottom:2rem;">Borrowed Books</h2>
      <?php if (isset($_GET['message'])) { ?>
        <p style="color: green; text-align: center;"><?php echo htmlspecialchars($_GET['message']); ?></p>
      <?php } ?>
      <?php if (isset($_GET['error'])) { ?>
        <p style="color: red; text-align: center;"><?php echo htmlspecialchars($_GET['error']); ?></p>
      <?php } ?>
      <div style="overflow-x:auto; display:flex; justify-content:center;">
      <table style="width:80%; max-width:800px; margin:0 auto; background:#fff; border-radius:12px; box-shadow:0 2px 12px rgba(108,93,212,0.07); border-collapse:separate; border-spacing:0;">
        <thead style="background:#f3f0fd; color:#6c5dd4;">
            <tr>
                <th style="padding:16px 8px;">Title</th>
                <th>Borrower</th>
                <th>Borrow Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr style="text-align:center; border-bottom:1px solid #f0f0f0;">
                    <td style="padding:12px 8px;"><?php echo htmlspecialchars($row['title']); ?></td>
                    <td><?php echo htmlspecialchars($row['first_name'] . ' ' . $row['last_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['borrow_date']); ?></td>
                    <td>
                        <form action="../../include/librarian/returnBook.php" method="POST" style="display: inline;">
                            <input type="hidden" name="borrow_id" value="<?php echo htmlspecialchars($row['id']); ?>">
                            <input type="hidden" name="book_id" value="<?php echo htmlspecialchars($row['book_id']); ?>">
                            <button type="submit" style="background-color: #6c5dd4; color: white; border: none; padding: 7px 16px; border-radius:6px; cursor: pointer; font-weight:600;">Return</button>
                        </form>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
      </table>
      </div>
    </main>
  </div>
</body>
</html>
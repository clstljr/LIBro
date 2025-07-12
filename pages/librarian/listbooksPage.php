<?php
require '../../include/db_connection.php';

$query = "SELECT * FROM books WHERE stock > 0 ORDER BY id DESC";
$result = $conn->query($query);
?>
<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Library Management System || Book List</title>
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
<div class="dashboard-container">
<aside class="sidebar">
  <div class="sidebar-logo">
    <img src="../../assets/image/LIBroLogo.png" alt="LIbro Logo" style="width:40px; height:40px; object-fit:contain;" />
    <span>LIbro</span>
  </div>
  <ul class="sidebar-links">
    <li><a href="dashboardLibrarianPage.php" class="sidebar-link<?php if(basename($_SERVER['PHP_SELF']) == 'dashboardLibrarianPage.php') ?>"> <i class="fa-solid fa-chart-line"></i> Dashboard</a></li>
    <li><a href="addbookPage.php" class="sidebar-link<?php if(basename($_SERVER['PHP_SELF']) == 'addbookPage.php') echo ' active'; ?>"> <i class="fa-solid fa-plus"></i> Add Book</a></li>
    <li><a href="listBooksPage.php" class="sidebar-link<?php if(basename($_SERVER['PHP_SELF']) == 'listBooksPage.php') echo ' active'; ?>"> <i class="fas fa-book"></i> Book List</a></li>
    <li><a href="addlibrarianPage.php" class="sidebar-link<?php if(basename($_SERVER['PHP_SELF']) == 'addlibrarianPage.php') ?>"> <i class="fa-solid fa-user-plus"></i> Add Librarian</a></li>
    <li><a href="../../include/logout.php" class="sidebar-link"> <i class="fa-solid fa-right-from-bracket"></i> Logout</a></li>
  </ul>
</aside>

<main class="main-section">
  <div style="display:flex; flex-direction:column; align-items:flex-start; gap:0.2rem; margin-bottom:1.5rem;">
    <h2 style="margin-left:200px; color:#6c5dd4; font-size:2rem; font-weight:700;">Books in Stock</h2>
  </div>

  <?php
  if (isset($_GET['error'])) {
      echo '<p class="error" style="color:red; text-align:center;">' . htmlspecialchars($_GET['error']) . '</p>';
  }
  if (isset($_GET['message'])) {
      echo '<p class="success" style="color:green; text-align:center;">' . htmlspecialchars($_GET['message']) . '</p>';
  }
  ?>

  <div class="control-panel" style="width:70%; margin:0 auto;">
    <table style="width:100%; border-collapse:collapse; margin-top:1rem;">
      <thead style="background:#f3f0fd; color:#6c5dd4;">
        <tr style="background:#f3f0fd;">
          <th style="padding:16px 8px; border:1px solid #ccc;">ID</th>
          <th style="padding:16px 8px; border:1px solid #ccc;">Image</th> <!-- Add this line -->
          <th style="padding:16px 8px; border:1px solid #ccc;">Title</th>
          <th style="padding:16px 8px; border:1px solid #ccc;">Author</th>
          <th style="padding:16px 8px; border:1px solid #ccc;">Description</th>
          <th style="padding:16px 8px; border:1px solid #ccc;">Category</th>
          <th style="padding:16px 8px; border:1px solid #ccc;">Stock</th>
          <th style="padding:16px 8px; border:1px solid #ccc;">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($book = $result->fetch_assoc()) { ?>
          <tr style="text-align:center;">
            <td style="padding:16px 8px; border:1px solid #ccc;"><?php echo htmlspecialchars($book['id']); ?></td>
            <td style="padding:16px 8px; border:1px solid #ccc;">
              <img src="../../uploads/<?php echo htmlspecialchars($book['image']); ?>" alt="Book Cover" style="width:60px; height:90px; object-fit:cover; border-radius:6px;">
            </td>
            <td style="padding:16px 8px; border:1px solid #ccc;"><?php echo htmlspecialchars($book['title']); ?></td>
            <td style="padding:16px 8px; border:1px solid #ccc;"><?php echo htmlspecialchars($book['author']); ?></td>
            <td style="padding:16px 8px; border:1px solid #ccc;"><?php echo htmlspecialchars($book['description']); ?></td>
            <td style="padding:16px 8px; border:1px solid #ccc;"><?php echo htmlspecialchars($book['category']); ?></td>
            <td style="padding:16px 8px; border:1px solid #ccc;"><?php echo htmlspecialchars($book['stock']); ?></td>
            <td style="padding:16px 8px; border:1px solid #ccc; text-align:center;">
            <div style="display:inline-flex; gap:6px;">
                <a href="updatebookPage.php?id=<?php echo $book['id']; ?>"
                style="background:#6c5dd4; color:white; padding:6px 12px; text-decoration:none; border-radius:4px; display:inline-block;">
                Edit
                </a>
                <form action="../../include/librarian/removebook.php" method="POST"
                    style="margin:0;" onsubmit="return confirmDelete();">
                <input type="hidden" name="id" value="<?php echo $book['id']; ?>">
                <button type="submit"
                        style="background:#CA3433; color:white; padding:6px 12px; text-decoration:none; border:none; border-radius:4px; cursor:pointer;">
                    Remove
                </button>
                </form>
            </div>
            </td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>

</main>
</div>
<script>
    function confirmDelete() {
        return confirm("Are you sure you want to remove this book?");
    }
</script>
</body>
</html>

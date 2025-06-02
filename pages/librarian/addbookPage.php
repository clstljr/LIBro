<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Library Management System || Add Book</title>
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
        <li><a href="dashboardLibrarianPage.php" class="sidebar-link"><i class="fa-solid fa-chart-line"></i> Dashboard</a></li>
        <li><a href="addbookPage.php" class="sidebar-link<?php if(basename($_SERVER['PHP_SELF']) == 'addbookPage.php') echo ' active'; ?>"><i class="fa-solid fa-plus"></i> Add Book</a></li>
        <li><a href="addlibrarianPage.php" class="sidebar-link<?php if(basename($_SERVER['PHP_SELF']) == 'addlibrarianPage.php') echo ' active'; ?>"><i class="fa-solid fa-user-plus"></i> Add Librarian</a></li>
        <li><a href="../../include/logout.php" class="sidebar-link"><i class="fa-solid fa-right-from-bracket"></i> Logout</a></li>
      </ul>
    </aside>
    <main class="main-section">
      <div style="display:flex; flex-direction:column; align-items:flex-start; gap:0.2rem; margin-bottom:1.5rem;">
        <h2 style="margin-left:200px ; color:#6c5dd4; font-size:2rem; font-weight:700;">Publish a book</h2>
      </div>
      <?php
      if (isset($_GET['error'])) {
          echo '<p class="error" style="color:red; text-align:center;">' . htmlspecialchars($_GET['error']) . '</p>';
      }
      if (isset($_GET['message'])) {
          echo '<p class="success" style="color:green; text-align:center;">' . htmlspecialchars($_GET['message']) . '</p>';
      }
      ?>
      <div class="book-list" style="display:flex; flex-wrap:wrap; gap:40px; justify-content:center; align-items:flex-start;">
        <div class="book-item" style="max-width:340px; min-width:260px; flex-direction:column; align-items:center; padding:32px 24px;">
          <img src="https://wordpress.library-management.com/wp-content/themes/library/img/259x340.png" alt="Book Cover Image" id="img-preview" style="width:180px; height:240px; object-fit:cover; border-radius:12px; margin-bottom:18px;" />
          <div style="font-size:1rem; color:#888; text-align:center;">Book Cover Preview</div>
<body onload="preloader()">
  <?php include '../../pages/sidebar.php'; ?> <!-- Include the sidebar -->
  
  <section class="home-section">
    <div class="home-content">
      <i class="fa-solid fa-bars"></i>
      <div class="logout">
        <button><a href="../../include/logout.php">Log Out</a></button> <!-- Correct logout path -->
      </div>
    </div>
    
    <!-- Back to Dashboard Button -->
    <div class="back-to-dashboard"> 
      <a href="dashboardLibrarianPage.php" class="btn-dashboard" role="button" aria-label="Back to Dashboard">
        <i class="fa-solid fa-arrow-left"></i> Back to Dashboard
      </a>
    </div>

    <?php
    if (isset($_GET['error'])) {
        echo '<p class="error">' . htmlspecialchars($_GET['error']) . '</p>';
    }
    if (isset($_GET['message'])) {
        echo '<p class="success">' . htmlspecialchars($_GET['message']) . '</p>';
    }
    ?>
    
    <div class="control-panel">
      <h4>Add Book</h4>
      <div class="container">
        <div class="book-cover-img">
          <img src="https://wordpress.library-management.com/wp-content/themes/library/img/259x340.png" alt="Book Cover Image" id="img-preview" />
        </div>
        <div class="book-item" style="flex:1; min-width:320px; max-width:600px;">
          <h4 style="margin-bottom:1.5rem; color:#6c5dd4;">Book Details</h4>
          <form class="input-form" action="../../include/librarian/addbook.php" method="POST" enctype="multipart/form-data" style="display:flex; flex-direction:column; gap:1.2rem;">
            <div style="display:flex; gap:1rem; flex-wrap:wrap;">
              <div style="flex:1; min-width:180px;">
                <label for="title">Book Title *</label>
                <input type="text" name="title" id="title" placeholder="Enter Book Title" required />
              </div>
              <div style="flex:1; min-width:180px;">
                <label for="author">Author Name *</label>
                <input type="text" name="author" id="author" placeholder="Enter Author Name" required />
              </div>
            </div>
            <div>
              <label for="description">Book Description *</label>
              <textarea rows="5" placeholder="Enter Book Description" id="desc" name="description" required></textarea>
            </div>
            <div style="display:flex; gap:1rem; flex-wrap:wrap; align-items:center;">
              <div style="flex:1; min-width:180px;">
                <label for="image">Upload Book Img *</label>
                <input type="file" name="image" id="image" accept=".jpg,.png" required />
              </div>
            </div>
            <div style="display:flex; gap:1rem; flex-wrap:wrap;">
              <div style="flex:1; min-width:180px;">
                <label for="category">Category *</label>
                <select name="category" id="category" required>
                  <option value="" disabled selected>Select a Category</option>
                  <option value="Comedy">Comedy</option>
                  <option value="Sci-Fi">Sci-Fi</option>
                  <option value="Horror">Horror</option>
                  <option value="Fantasy">Fantasy</option>
                  <option value="Biography">Biography</option>
                </select>
              </div>
              <div style="flex:1; min-width:180px;">
                <label for="stock">Stock *</label>
                <input type="number" name="stock" id="stock" placeholder="Enter Stock Quantity" required />
              </div>
            </div>
            <input type="submit" value="Add Book" name="add-book" style="background:#6c5dd4; color:#fff; border:none; border-radius:8px; padding:12px 36px; font-size:1.1rem; font-weight:600; cursor:pointer; transition:background 0.2s; align-self:flex-end;" />
          </form>
        </div>
      </div>
    </main>
  </div>
  <script>
    let imgpreview = document.querySelector("#img-preview");
    let fileinput = document.getElementById("image");
    if (fileinput) {
      fileinput.onchange = () => {
        let reader = new FileReader();
        reader.readAsDataURL(fileinput.files[0]);
        reader.onload = () => {
          let fileURL = reader.result;
          imgpreview.src = fileURL;
        }
      }
    }
  </script>
  <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
  <script src="../../js/main.js"></script>
</body>

</html>
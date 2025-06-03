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
        <li><a href="dashboardLibrarianPage.php" class="sidebar-link<?php if(basename($_SERVER['PHP_SELF']) == 'dashboardLibrarianPage.php') echo ' active'; ?>"><i class="fa-solid fa-chart-line"></i> Dashboard</a></li>
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
      <div class="addbook-flex-row" style="justify-content: center;">
        <div class="book-cover-img">
          <img src="https://wordpress.library-management.com/wp-content/themes/library/img/259x340.png" alt="Book Cover Image" id="img-preview" />
          <div class="cover-preview-label">Book Cover Preview</div>
        </div>
        <div class="book-item">
          <h4>Book Details</h4>
          <form class="input-form" action="../../include/librarian/addbook.php" method="POST" enctype="multipart/form-data">
            <div class="form-row">
              <div>
                <label for="title">Book Title *</label>
                <input type="text" name="title" id="title" placeholder="Enter Book Title" required />
              </div>
              <div>
                <label for="author">Author Name *</label>
                <input type="text" name="author" id="author" placeholder="Enter Author Name" required />
              </div>
            </div>
            <div>
              <label for="description">Book Description *</label>
              <textarea rows="5" placeholder="Enter Book Description" id="desc" name="description" required></textarea>
            </div>
            <div class="form-row">
              <div>
                <label for="image">Upload Book Img *</label>
                <input type="file" name="image" id="image" accept=".jpg,.png" required />
              </div>
            </div>
            <div class="form-row">
              <div>
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
              <div>
                <label for="stock">Stock *</label>
                <input type="number" name="stock" id="stock" placeholder="Enter Stock Quantity" required />
              </div>
            </div>
            <input type="submit" value="Add Book" name="add-book" class="addbook-btn" />
          </form>
        </div>
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
  <style>
.addbook-flex-row {
  display: flex;
  flex-direction: row;
  gap: 40px;
  align-items: flex-start;
  justify-content: flex-start;
  width: 100%;
  margin-top: 1.5rem;
  flex-wrap: nowrap;
}
.book-cover-img {
  max-width: 340px;
  min-width: 260px;
  flex: 0 0 260px;
  display: flex;
  flex-direction: column;
  align-items: center;
  background: #fff;
  border-radius: 12px;
  box-shadow: 0 2px 12px rgba(108,93,212,0.07);
  padding: 32px 24px;
}
.book-cover-img img {
  width: 180px;
  height: 240px;
  object-fit: cover;
  border-radius: 12px;
  margin-bottom: 18px;
  background: #f3f0fd;
  border: 2px solid #e0e0e0;
}
.cover-preview-label {
  font-size: 1rem;
  color: #888;
  text-align: center;
}
.book-item {
  flex: 1;
  min-width: 320px;
  max-width: 600px;
}
.book-item h4 {
  margin-bottom: 1.5rem;
  color: #6c5dd4;
}
.input-form {
  display: flex;
  flex-direction: column;
  gap: 1.2rem;
}
.form-row {
  display: flex;
  gap: 1rem;
  flex-wrap: wrap;
}
.form-row > div {
  flex: 1;
  min-width: 180px;
}
.addbook-btn {
  background: #6c5dd4;
  color: #fff;
  border: none;
  border-radius: 8px;
  padding: 12px 36px;
  font-size: 1.1rem;
  font-weight: 600;
  cursor: pointer;
  transition: background 0.2s;
  align-self: flex-end;
}
@media (max-width: 900px) {
  .addbook-flex-row {
    flex-direction: column;
    gap: 24px;
    align-items: stretch;
  }
  .book-cover-img {
    margin-bottom: 0;
    align-self: center;
  }
}
</style>
</body>

</html>
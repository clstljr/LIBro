<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Library Management System || Add Book</title>
  
  <!-- Correct CSS paths -->
  <link rel="stylesheet" href="../../assets/style.css" />
  <link rel="stylesheet" href="../../assets/main.css" />
  <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
  
  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&display=swap" rel="stylesheet" />
  
  <!-- FontAwesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" />
</head>

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
      <a href="dashboardLibrarianPage.php" class="btn-dashboard">
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
        <div class="add-book-form data-form">
          <h4>Book Details</h4>
          <form class="input-form" action="../../include/librarian/addbook.php" method="POST" enctype="multipart/form-data"> <!-- Correct form action -->
            <div class="input-field input-group">
              <div class="input-1">
                <label for="title">Book Title *</label>
                <input type="text" name="title" id="title" placeholder="Enter Book Title" required />
              </div>
              <div class="input-2">
                <label for="author">Author Name *</label>
                <input type="text" name="author" id="author" placeholder="Enter Author Name" required />
              </div>
            </div>
            <div class="book-desc">
              <label for="description">Book Description *</label>
              <textarea rows="5" placeholder="Enter Book Description" id="desc" name="description" required></textarea>
            </div>
            <div class="input-field upload-file">
              <div class="input-1">
                <label for="image">Upload Book Img *</label>
                <input type="file" name="image" id="image" accept=".jpg,.png" required />
              </div>
            </div>
            <div class="input-field input-group">
              <div class="input-1">
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
              <div class="input-2">
                <label for="stock">Stock *</label>
                <input type="number" name="stock" id="stock" placeholder="Enter Stock Quantity" required />
              </div>
            </div>
            <input type="submit" value="Add Book" name="add-book">
          </form>
        </div>
      </div>
    </div>
  </section>

  <script>
    let imgpreview = document.querySelector(".book-cover-img #img-preview");
    let fileinput = document.getElementById("image");

    fileinput.onchange = () => {
      let reader = new FileReader();
      reader.readAsDataURL(fileinput.files[0]);
      reader.onload = () => {
        let fileURL = reader.result;
        imgpreview.src = fileURL;
      }
    }
  </script>

  <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
  <script src="../../js/main.js"></script> <!-- Correct JavaScript path -->
</body>

</html>
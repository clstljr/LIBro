<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Library Management System || Add Book</title>
  <link rel="stylesheet" href="assets/css/main.css" />
  <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
  <!--- google font link-->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&display=swap" rel="stylesheet" />

  <!-- Fontawesome Link for Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" />
</head>

<body onload="preloader()">
  <?php include 'pages/includes/sidebar.php'; ?>
  <section class="home-section">
    <div class="home-content">
      <i class="fa-solid fa-bars"></i>
      <div class="logout">
      </div>
    </div>
    <?php
    if (isset($error['book-msg'])) {
    ?>
      <p class="error">
        <?php echo $error['book-msg']; ?>
      </p>
    <?php
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
          <form class="input-form" action="pages/add_book.php" method="POST" enctype="multipart/form-data">
            <div class="input-field input-group">
              <div class="input-1">
                <label for="title">Book Title *</label>
                <input type="text" name="title" id="title" placeholder="Enter Book Title" required />
              </div>
              <div class="input-2">
                <label for="author">Author Name *</label>
                <input type="text" name="author" id="author" placeholder="Enter Author Name" />
              </div>
            </div>
            <div class="book-desc">
              <label for="description">Book Description *</label>
              <textarea rows="5" placeholder="Enter Book Description" id="desc" name="description"></textarea>
            </div>

            <div class="input-field upload-file">
              <div class="input-1">
                <label for="image">Upload Book Img *</label>
                <input type="file" name="image" id="image" accept=".jpg,.png" required />
              </div>
            </div>
            <div class="input-field input-group">
              <div class="input-1">
                <label for="price">Price *</label>
                <input type="text" name="price" id="price" placeholder="Enter Book Price" />
                <?php
                if (isset($error['price'])) {
                ?>
                  <p class="error-msg">
                    <?php echo $error['price']; ?>
                  </p>
                <?php
                }
                ?>
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
        // let imgTag = `<img src="${fileURL}" alt="image">`;
        // dropArea.innerHTML = imgTag;
      }
    }
  </script>

  <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>

  <script src="../../js/main.js"></script>
</body>

</html>
<?php
require '../../include/db_connection.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Book ID is required.");
}

$book_id = (int)$_GET['id'];

$stmt = $conn->prepare("SELECT * FROM books WHERE id = ?");
$stmt->bind_param("i", $book_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Book not found.");
}

$book = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Library Management System || Update Book</title>
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
    <li><a href="addbookPage.php" class="sidebar-link<?php if(basename($_SERVER['PHP_SELF']) == 'addbookPage.php') ?>"> <i class="fa-solid fa-plus"></i> Add Book</a></li>
    <li><a href="listBooksPage.php" class="sidebar-link<?php if(basename($_SERVER['PHP_SELF']) == 'listBooksPage.php') ?>"> <i class="fas fa-book"></i> Book List</a></li>
    <li><a href="addlibrarianPage.php" class="sidebar-link<?php if(basename($_SERVER['PHP_SELF']) == 'addlibrarianPage.php') ?>"> <i class="fa-solid fa-user-plus"></i> Add Librarian</a></li>
    <li><a href="../../include/logout.php" class="sidebar-link"> <i class="fa-solid fa-right-from-bracket"></i> Logout</a></li>
  </ul>
</aside>

<main class="main-section">
<div style="display:flex; flex-direction:column; align-items:flex-start; gap:0.2rem; margin-bottom:1.5rem;">
  <h2 style="margin-left:200px; color:#6c5dd4; font-size:2rem; font-weight:700;">Update Book</h2>
</div>

<?php
if (isset($_GET['error'])) {
    echo '<p class="error" style="color:red; text-align:center;">' . htmlspecialchars($_GET['error']) . '</p>';
}
if (isset($_GET['message'])) {
    echo '<p class="success" style="color:green; text-align:center;">' . htmlspecialchars($_GET['message']) . '</p>';
}
?>
<div class="update-book-container">
  <div class="book-cover">
    <img src="../../uploads/<?php echo htmlspecialchars($book['image']); ?>" alt="Book Cover" id="img-preview" />
    <div class="cover-label">Book Cover Preview</div>
  </div>

  <div class="book-form">
    <h4>Book Details</h4>
    <form action="../../include/librarian/updatebook.php" method="POST" enctype="multipart/form-data">
      <input type="hidden" name="id" value="<?php echo htmlspecialchars($book['id']); ?>">

      <div class="form-row">
        <div>
          <label>Book Title *</label>
          <input type="text" name="title" value="<?php echo htmlspecialchars($book['title']); ?>" required>
        </div>
        <div>
          <label>Author Name *</label>
          <input type="text" name="author" value="<?php echo htmlspecialchars($book['author']); ?>" required>
        </div>
      </div>

      <div>
        <label>Book Description *</label>
        <textarea name="description" rows="5" required><?php echo htmlspecialchars($book['description']); ?></textarea>
      </div>

      <div class="form-row">
        <div>
          <label>Upload Book Cover Image</label>
          <input type="file" name="image" accept=".jpg,.png">
        </div>
      </div>

      <div class="form-row">
        <div>
          <label>Category *</label>
          <select name="category" required>
            <option value="" disabled>Select a Category</option>
            <?php
            $categories = ["Comedy", "Sci-Fi", "Horror", "Fantasy", "Biography"];
            foreach ($categories as $cat) {
              $selected = ($book['category'] === $cat) ? 'selected' : '';
              echo "<option value=\"$cat\" $selected>$cat</option>";
            }
            ?>
          </select>
        </div>
        <div>
          <label>Stock *</label>
          <input type="number" name="stock" value="<?php echo htmlspecialchars($book['stock']); ?>" required>
        </div>
      </div>

      <button type="submit" name="update-book" class="btn-purple">Update Book</button>
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
      imgpreview.src = reader.result;
    }
  }
}
</script>
<style>
    .update-book-container {
  display: flex;
  gap: 40px;
  align-items: flex-start;
  justify-content: center;
  margin-top: 2rem;
}

.book-cover {
  max-width: 260px;
  flex: 0 0 260px;
  background: #fff;
  border-radius: 8px;
  box-shadow: 0 2px 12px rgba(0, 0, 0, 0.05);
  padding: 20px;
  text-align: center;
}

.book-cover img {
  width: 100%;
  max-width: 180px;
  height: auto;
  border-radius: 8px;
  background: #f3f0fd;
  border: 1px solid #ddd;
  margin-bottom: 8px;
}

.cover-label {
  font-size: 0.9rem;
  color: #888;
}

.book-form {
  flex: 1;
  max-width: 600px;
  background: #fff;
  border-radius: 8px;
  padding: 20px;
  box-shadow: 0 2px 12px rgba(0, 0, 0, 0.05);
}

.book-form h4 {
  color: #6c5dd4;
  margin-bottom: 1rem;
  font-size: 1.2rem;
}

.book-form label {
  font-weight: 500;
  display: block;
  margin-bottom: 0.2rem;
  color: #333;
}

.book-form input,
.book-form select,
.book-form textarea {
  width: 100%;
  padding: 8px 10px;
  margin-bottom: 1rem;
  border: 1px solid #ccc;
  border-radius: 4px;
  font-family: inherit;
}

.book-form textarea {
  resize: vertical;
}

.form-row {
  display: flex;
  gap: 1rem;
  flex-wrap: wrap;
}

.form-row > div {
  flex: 1;
  min-width: 150px;
}

.btn-purple {
  background: #6c5dd4;
  color: white;
  border: none;
  border-radius: 6px;
  padding: 10px 30px;
  font-weight: 600;
  cursor: pointer;
  transition: 0.2s ease;
}

.btn-purple:hover {
  background: #5a4dcf;
}
</style>
</body>
</html>
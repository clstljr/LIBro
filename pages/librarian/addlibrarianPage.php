<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>LIbro || Add Librarian</title>
  
  <!-- Correct CSS paths -->
  <link rel="stylesheet" href="../../assets/style.css">
  <link rel="stylesheet" href="../../assets/index.css">
  <link rel="stylesheet" href="../../assets/main.css">
  
  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&display=swap" rel="stylesheet" />
  
  <!-- FontAwesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" />
  <style>
      .sidebar-links a {
        display: flex;
        align-items: center;
        gap: 0.7rem;
        padding: 0.8rem 1.5rem;
        color: #222;
        text-decoration: none;
        font-weight: 500;
        border-radius: 8px;
        transition: background 0.18s, color 0.18s;
        font-size: 1.08rem;
      }
      .sidebar-links a:hover {
        background: #6c5dd4 !important;
        color: #fff !important;
      }
      .sidebar-links a.active, .sidebar-links a.active:visited {
        background: #6c5dd4 !important;
        color: #fff !important;
        font-weight: 600;
      }
      .sidebar-links a i {
        color: #6c5dd4;
        transition: color 0.18s;
        font-size: 1.15rem;
      }
      .sidebar-links a.active i, .sidebar-links a:hover i {
        color: #fff !important;
      }
      .sidebar {
        height: 100vh;
        min-width: 220px;
        background: #fff;
        box-shadow: 2px 0 16px rgba(108,93,212,0.07);
        display: flex;
        flex-direction: column;
      }
      .sidebar-logo {
        display: flex;
        align-items: center;
        gap: 0.7rem;
        padding: 2rem 1.5rem 1.2rem 1.5rem;
      }
      .sidebar-logo span {
        font-size: 1.3rem;
        font-weight: 700;
        color: #6c5dd4;
        letter-spacing: 1px;
      }
      .main-section {
        flex: 1;
        padding: 2.5rem 2.5rem 2.5rem 2rem;
        background: #faf9fb;
        min-height: 100vh;
      }
    </style>
</head>

<body>
  <div class="dashboard-container" style="display:flex; min-height:100vh;">
    <aside class="sidebar" style="width:220px; min-width:220px; background:#fff; box-shadow:2px 0 16px rgba(108,93,212,0.07); display:flex; flex-direction:column;">
      <div class="sidebar-logo" style="display:flex; align-items:center; gap:0.7rem; padding:2rem 1.5rem 1.2rem 1.5rem;">
        <img src="../../assets/image/LIBroLogo.png" alt="LIbro Logo" style="width:40px; height:40px; object-fit:contain;" />
        <span style="font-size:1.3rem; font-weight:700; color:#6c5dd4; letter-spacing:1px;">LIbro</span>
      </div>
      <ul class="sidebar-links" style="list-style:none; padding:0; margin:0; display:flex; flex-direction:column; gap:0.5rem;">
        <li><a href="dashboardLibrarianPage.php" class="sidebar-link"><i class="fa-solid fa-chart-line"></i> Dashboard</a></li>
        <li><a href="addbookPage.php" class="sidebar-link"><i class="fa-solid fa-plus"></i> Add Book</a></li>
        <li><a href="addlibrarianPage.php" class="sidebar-link active"><i class="fa-solid fa-user-plus"></i> Add Librarian</a></li>
        <li><a href="../../include/logout.php" class="sidebar-link"><i class="fa-solid fa-right-from-bracket"></i> Logout</a></li>
      </ul>
    </aside>
    <main class="main-section" style="flex:1; padding:2.5rem 2.5rem 2.5rem 2rem; background:#faf9fb; min-height:100vh;">
      <div style="display:flex; flex-direction:column; align-items:flex-start; gap:0.2rem; margin-bottom:1.5rem;">
        <h2 style="color:#6c5dd4;margin-left: 250px; font-size:2rem; font-weight:700;">Add librarian account</h2>
      </div>
      <section class="registration">
        <div class="registration-form">
          <form class="input-form" action="../../include/librarian/addlibrarian.php" method="POST"> <!-- Correct form action -->
            <?php
            if (isset($_GET['error'])) {
              echo "<p class='error'>" . htmlspecialchars($_GET['error']) . "</p>";
            }
            if (isset($_GET['message'])) {
              echo "<p class='success'>" . htmlspecialchars($_GET['message']) . "</p>";
            }
            ?>
            <div class="input-field">
              <label for="first_name">First Name *</label>
              <input type="text" name="first_name" id="first_name" placeholder="First Name" required>
            </div>
            <div class="input-field">
              <label for="last_name">Last Name *</label>
              <input type="text" name="last_name" id="last_name" placeholder="Last Name" required>
            </div>
            <div class="input-field">
              <label for="email">Email *</label>
              <input type="email" name="email" id="email" placeholder="Your Email" required>
            </div>
            <!-- Address fields: Region, Province, City, Barangay -->
            <div class="input-field">
              <label for="region">Region *</label>
              <select name="region" id="region" required>
                <option value="">Select Region</option>
                <?php
                include __DIR__ . '/../../include/db_connection.php';
                $regions = mysqli_query($conn, "SELECT * FROM refregion");
                while ($region = mysqli_fetch_assoc($regions)) {
                  echo "<option value='{$region['regCode']}'>{$region['regDesc']}</option>";
                }
                ?>
              </select>
            </div>
            <div class="input-field">
              <label for="province">Province *</label>
              <select name="province" id="province" required disabled>
                <option value="">Select Province</option>
              </select>
            </div>
            <div class="input-field">
              <label for="city">City/Municipality *</label>
              <select name="city" id="city" required disabled>
                <option value="">Select City</option>
              </select>
            </div>
            <div class="input-field">
              <label for="barangay">Barangay *</label>
              <select name="barangay" id="barangay" required disabled>
                <option value="">Select Barangay</option>
              </select>
            </div>
            <div class="input-field">
              <label for="phone">Mobile No. *</label>
              <input type="text" maxlength="10" name="phone" id="phone" placeholder="Mobile No." required>
            </div>
            <div class="input-field">
              <label for="password">Password *</label>
              <input type="password" name="password" id="password" placeholder="Password" required>
            </div>
            <input type="submit" name="register" id="signup" value="Add Librarian">
          </form>
        </div>
      </section>
    </main>
  </div>

  <script>
    let hamburgerbtn = document.querySelector(".hamburger");
    let nav_list = document.querySelector(".nav-list");
    if (hamburgerbtn && nav_list) {
      hamburgerbtn.addEventListener("click", () => {
        nav_list.classList.add("active");
      });
    }

    document.getElementById('region').addEventListener('change', function() {
        let region = this.value;
        let provinceSelect = document.getElementById('province');
        let citySelect = document.getElementById('city');
        let barangaySelect = document.getElementById('barangay');
        provinceSelect.innerHTML = '<option value="">Select Province</option>';
        citySelect.innerHTML = '<option value="">Select City</option>';
        barangaySelect.innerHTML = '<option value="">Select Barangay</option>';
        citySelect.disabled = true;
        barangaySelect.disabled = true;
        if(region) {
            fetch('../../include/others/getProvinces.php?region=' + region)
                .then(response => response.text())
                .then(data => {
                    provinceSelect.innerHTML = data;
                    provinceSelect.disabled = false;
                });
        } else {
            provinceSelect.disabled = true;
        }
    });

    document.getElementById('province').addEventListener('change', function() {
        let province = this.value;
        let citySelect = document.getElementById('city');
        let barangaySelect = document.getElementById('barangay');
        citySelect.innerHTML = '<option value="">Select City</option>';
        barangaySelect.innerHTML = '<option value="">Select Barangay</option>';
        barangaySelect.disabled = true;
        if(province) {
            fetch('../../include/others/getCities.php?province=' + province)
                .then(response => response.text())
                .then(data => {
                    citySelect.innerHTML = data;
                    citySelect.disabled = false;
                });
        } else {
            citySelect.disabled = true;
        }
    });

    document.getElementById('city').addEventListener('change', function() {
        let city = this.value;
        let barangaySelect = document.getElementById('barangay');
        barangaySelect.innerHTML = '<option value="">Select Barangay</option>';
        if(city) {
            fetch('../../include/others/getBarangays.php?city=' + city)
                .then(response => response.text())
                .then(data => {
                    barangaySelect.innerHTML = data;
                    barangaySelect.disabled = false;
                });
        } else {
            barangaySelect.disabled = true;
        }
    });
  </script>
</body>

</html>
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once('include/config.php');
require_once('include/checklogin.php');
check_login();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>User | Dashboard</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Fonts & Icons -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">

  <style>
    /* === Global === */
    body {
      font-family: 'Poppins', sans-serif;
      background: #f6f7fb;
      margin: 0;
      display: flex;
      height: 100vh;
      overflow: hidden;
    }

    /* === Sidebar === */
    .sidebar {
      width: 220px;
      background: linear-gradient(180deg, #2563eb, #38bdf8);
      color: #fff;
      display: flex;
      flex-direction: column;
      position: fixed;
      top: 0;
      bottom: 0;
      left: 0;
      box-shadow: 2px 0 10px rgba(0,0,0,0.08);
      z-index: 1000;
    }

    .sidebar h2 {
      font-weight: 500;
      text-align: center;
      padding: 18px 0;
      font-size: 18px;
      border-bottom: 1px solid rgba(255,255,255,0.2);
      margin: 0;
    }

    .sidebar ul {
      list-style: none;
      margin: 0;
      padding: 10px 0;
    }

    .sidebar a {
      display: flex;
      align-items: center;
      gap: 10px;
      color: #e0e7ff;
      padding: 10px 22px;
      text-decoration: none;
      font-size: 14px;
      transition: all 0.25s ease;
    }

    .sidebar a:hover,
    .sidebar a.active {
      background: rgba(255,255,255,0.18);
      color: #fff;
      padding-left: 28px;
    }

    .sidebar i {
      font-size: 16px;
    }

    /* === Main Content === */
    .main-content {
      flex: 1;
      margin-left: 220px;
      display: flex;
      flex-direction: column;
      height: 100vh;
      overflow-y: auto;
    }

    /* === Header === */
    header {
      background: #fff;
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 10px 25px;
      box-shadow: 0 1px 6px rgba(0,0,0,0.08);
      position: sticky;
      top: 0;
      z-index: 10;
    }

    header h1 {
      font-size: 17px;
      font-weight: 500;
      color: #2563eb;
      margin: 0;
    }

    .user-dropdown {
      position: relative;
      display: flex;
      align-items: center;
      gap: 8px;
      cursor: pointer;
    }

    .user-dropdown img {
      width: 38px;
      height: 38px;
      border-radius: 50%;
      border: 2px solid #2563eb;
      object-fit: cover;
    }

    .user-dropdown span {
      font-size: 14px;
      color: #333;
      font-weight: 400;
    }

    .user-menu {
      display: none;
      position: absolute;
      right: 0;
      top: 48px;
      background: #fff;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
      border-radius: 8px;
      overflow: hidden;
      width: 160px;
      animation: fadeIn 0.3s ease;
    }

    .user-menu.active {
      display: block;
    }

    .user-menu a {
      display: block;
      padding: 8px 15px;
      text-decoration: none;
      font-size: 13px;
      color: #333;
      transition: background 0.2s;
    }

    .user-menu a:hover {
      background: #f3f5f8;
    }

    /* === Main Body === */
    main {
      padding: 25px;
      flex: 1;
      background: #f6f7fb;
    }

    .welcome {
      font-weight: 500;
      font-size: 18px;
      color: #1e3a8a;
      margin-bottom: 25px;
    }

    .dashboard-cards {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
      gap: 20px;
    }

    .dash-card {
      background: #fff;
      border-radius: 12px;
      padding: 22px 15px;
      text-align: center;
      box-shadow: 0 2px 8px rgba(0,0,0,0.05);
      transition: all 0.3s ease;
    }

    .dash-card:hover {
      transform: translateY(-4px);
      box-shadow: 0 6px 18px rgba(0,0,0,0.1);
    }

    .dash-card i {
      font-size: 38px;
      color: #2563eb;
      margin-bottom: 12px;
    }

    .dash-card h3 {
      font-size: 15px;
      font-weight: 400;
      color: #1e3a8a;
      margin-bottom: 10px;
    }

    .dash-card a {
      display: inline-block;
      padding: 4px 14px;
      font-size: 13px;
      font-weight: 400;
      color: #2563eb;
      border: 1px solid #2563eb;
      border-radius: 5px;
      text-decoration: none;
      transition: all 0.25s ease;
    }

    .dash-card a:hover {
      background: #2563eb;
      color: #fff;
    }

    footer {
      background: #fff;
      text-align: center;
      padding: 10px;
      font-size: 13px;
      color: #777;
      border-top: 1px solid #e5e7eb;
    }

    @keyframes fadeIn {
      from {opacity: 0; transform: translateY(-5px);}
      to {opacity: 1; transform: translateY(0);}
    }

    ::-webkit-scrollbar { width: 6px; }
    ::-webkit-scrollbar-thumb { background-color: rgba(0,0,0,0.2); border-radius: 4px; }
  </style>
</head>

<body>

  <!-- Sidebar -->
  <aside class="sidebar">
    <h2>HMS Panel</h2>
    <ul>
      <li><a href="dashboard.php" class="active"><i class="fa-solid fa-house"></i> Dashboard</a></li>
      <li><a href="book-appointment.php"><i class="fa-solid fa-pen-to-square"></i> Book Appointment</a></li>
      <li><a href="appointment-history.php"><i class="fa-solid fa-calendar-check"></i> Appointment History</a></li>
      <li><a href="manage-medhistory.php"><i class="fa-solid fa-file-medical"></i> Medical History</a></li>
    </ul>
  </aside>

  <!-- Main Content -->
  <div class="main-content">
    <header>
      <h1>Hospital Management System</h1>
      <div class="user-dropdown">
        <img src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png" alt="User">
        <span>
          <?php
          $query = mysqli_query($con, "SELECT fullName FROM users WHERE id='".$_SESSION['id']."'");
          $row = mysqli_fetch_array($query);
          echo htmlspecialchars($row['fullName']);
          ?>
        </span>
        <div class="user-menu">
          <a href="edit-profile.php"><i class="fa fa-user me-2"></i> My Profile</a>
          <a href="change-password.php"><i class="fa fa-key me-2"></i> Change Password</a>
          <a href="logout.php"><i class="fa fa-sign-out-alt me-2"></i> Logout</a>
        </div>
      </div>
    </header>

    <main>
      <h2 class="welcome">Welcome to Your Dashboard</h2>

      <div class="dashboard-cards">
        <div class="dash-card">
          <i class="fa-solid fa-user-circle"></i>
          <h3>My Profile</h3>
          <a href="edit-profile.php">Update</a>
        </div>

        <div class="dash-card">
          <i class="fa-solid fa-calendar-check"></i>
          <h3>My Appointments</h3>
          <a href="appointment-history.php">View</a>
        </div>

        <div class="dash-card">
          <i class="fa-solid fa-plus-square"></i>
          <h3>Book Appointment</h3>
          <a href="book-appointment.php">Book</a>
        </div>

        <div class="dash-card">
          <i class="fa-solid fa-file-medical"></i>
          <h3>Medical History</h3>
          <a href="manage-medhistory.php">Manage</a>
        </div>
      </div>
    </main>

    <footer>
      &copy; <?php echo date('Y'); ?> Hospital Management System. All Rights Reserved.
    </footer>
  </div>

  <script>
  document.addEventListener("DOMContentLoaded", function() {
    const dropdown = document.querySelector(".user-dropdown");
    const menu = document.querySelector(".user-menu");

    dropdown.addEventListener("click", function(event) {
      event.stopPropagation();
      menu.classList.toggle("active");
    });

    document.addEventListener("click", function(event) {
      if (!dropdown.contains(event.target)) {
        menu.classList.remove("active");
      }
    });
  });
  </script>

</body>
</html>

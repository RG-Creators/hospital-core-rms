<?php
session_start();
error_reporting(0);
include('include/config.php');
include('include/checklogin.php');
check_login();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>User | View Medical History</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Fonts & Icons -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">

  <style>
    /* Global Layout */
    body {
      font-family: 'Poppins', sans-serif;
      background: #f4f6f9;
      margin: 0;
      display: flex;
      height: 100vh;
      overflow: hidden;
    }

    /* Sidebar */
    .sidebar {
      width: 250px;
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
      padding: 25px 0;
      font-size: 20px;
      letter-spacing: 0.5px;
      border-bottom: 1px solid rgba(255,255,255,0.2);
      margin: 0;
    }

    .sidebar ul {
      list-style: none;
      margin: 0;
      padding: 15px 0;
    }

    .sidebar a {
      display: flex;
      align-items: center;
      gap: 12px;
      color: #e0e7ff;
      padding: 10px 25px;
      text-decoration: none;
      transition: all 0.25s ease;
      font-weight: 400;
      font-size: 14px;
    }

    .sidebar a:hover,
    .sidebar a.active {
      background: rgba(255,255,255,0.15);
      color: #fff;
      padding-left: 30px;
    }

    .sidebar i {
      font-size: 16px;
    }

    /* Main Area */
    .main-content {
      flex: 1;
      margin-left: 250px;
      display: flex;
      flex-direction: column;
      height: 100vh;
      overflow-y: auto;
    }

    /* Header */
    header {
      background: #fff;
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 10px 30px;
      box-shadow: 0 2px 6px rgba(0,0,0,0.08);
      position: sticky;
      top: 0;
      z-index: 10;
    }

    header h1 {
      font-size: 18px;
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
      width: 36px;
      height: 36px;
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
      top: 45px;
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
      padding: 10px 15px;
      text-decoration: none;
      color: #333;
      font-size: 13px;
      transition: background 0.2s;
    }

    .user-menu a:hover {
      background: #f2f4f8;
    }

    /* Main Body */
    main {
      padding: 40px 30px;
      flex: 1;
      background: #f4f6f9;
    }

    .card {
      background: #fff;
      border-radius: 16px;
      box-shadow: 0 6px 16px rgba(0,0,0,0.05);
      padding: 35px;
      max-width: 1100px;
      margin: 0 auto;
    }

    .card h2 {
      font-size: 18px;
      font-weight: 500;
      color: #2563eb;
      border-bottom: 1px solid #e5e7eb;
      padding-bottom: 12px;
      margin-bottom: 25px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      font-size: 14px;
    }

    th, td {
      border: 1px solid #e5e7eb;
      padding: 10px 14px;
      text-align: left;
    }

    th {
      background: #f3f4f6;
      color: #2563eb;
      font-weight: 500;
    }

    tr:hover {
      background: #f9fafb;
    }

    footer {
      background: #fff;
      text-align: center;
      padding: 12px;
      font-size: 13px;
      color: #666;
      border-top: 1px solid #e5e7eb;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(-5px); }
      to { opacity: 1; transform: translateY(0); }
    }
  </style>
</head>

<body>

  <!-- Sidebar -->
  <aside class="sidebar">
    <h2>HMS Panel</h2>
    <ul>
      <li><a href="dashboard.php"><i class="fa-solid fa-house"></i> Dashboard</a></li>
      <li><a href="book-appointment.php"><i class="fa-solid fa-pen-to-square"></i> Book Appointment</a></li>
      <li><a href="appointment-history.php"><i class="fa-solid fa-calendar-check"></i> Appointment History</a></li>
      <li><a href="manage-medhistory.php" class="active"><i class="fa-solid fa-file-medical"></i> Medical History</a></li>
    </ul>
  </aside>

  <!-- Main Content -->
  <div class="main-content">
    <!-- Header -->
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

    <!-- Main -->
    <main>
      <div class="card">
        <h2>View Medical History</h2>
        <table>
          <thead>
            <tr>
              <th>#</th>
              <th>Patient Name</th>
              <th>Contact</th>
              <th>Gender</th>
              <th>Created</th>
              <th>Updated</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $uid = $_SESSION['id'];
            $sql = mysqli_query($con, "SELECT tblpatient.* FROM tblpatient 
              JOIN users ON users.email = tblpatient.PatientEmail WHERE users.id='$uid'");
            $cnt = 1;
            while ($row = mysqli_fetch_array($sql)) {
            ?>
            <tr>
              <td><?php echo $cnt; ?></td>
              <td><?php echo $row['PatientName']; ?></td>
              <td><?php echo $row['PatientContno']; ?></td>
              <td><?php echo $row['PatientGender']; ?></td>
              <td><?php echo $row['CreationDate']; ?></td>
              <td><?php echo $row['UpdationDate']; ?></td>
              <td>
                <a href="view-medhistory.php?viewid=<?php echo $row['ID'];?>" 
                   class="btn btn-outline-primary btn-sm">View Details</a>
              </td>
            </tr>
            <?php 
            $cnt++;
            } ?>
          </tbody>
        </table>
      </div>
    </main>

    <!-- Footer -->
    <footer>
      &copy; <?php echo date('Y'); ?> Hospital Management System. All Rights Reserved.
    </footer>
  </div>

  <script>
    // Toggle dropdown
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

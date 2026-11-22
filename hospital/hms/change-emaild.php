<?php
session_start();
include('include/config.php');
include('include/checklogin.php');
check_login();

if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $sql = mysqli_query($con, "UPDATE users SET email='$email' WHERE id='" . $_SESSION['id'] . "'");
    if ($sql) {
        $msg = "Your email has been updated successfully!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Change Email | HMS</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <!-- Tailwind + Font -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <script src="https://cdn.tailwindcss.com"></script>

  <style>
    body {
      font-family: 'Inter', sans-serif;
      background: #f7f9fc;
      margin: 0;
      display: flex;
      height: 100vh;
      overflow: hidden;
    }

    /* Sidebar */
    .sidebar {
      width: 240px;
      background: linear-gradient(180deg, #2563eb, #38bdf8);
      color: #fff;
      display: flex;
      flex-direction: column;
      position: fixed;
      top: 0; bottom: 0; left: 0;
      box-shadow: 2px 0 8px rgba(0, 0, 0, 0.08);
    }

    .sidebar h2 {
      font-weight: 500;
      text-align: center;
      padding: 22px 0;
      font-size: 19px;
      border-bottom: 1px solid rgba(255,255,255,0.2);
    }

    .sidebar a {
      display: flex;
      align-items: center;
      gap: 10px;
      color: #e0e7ff;
      padding: 10px 22px;
      text-decoration: none;
      transition: all 0.25s ease;
      font-size: 15px;
    }

    .sidebar a:hover,
    .sidebar a.active {
      background: rgba(255,255,255,0.15);
      color: #fff;
      padding-left: 28px;
    }

    .main-content {
      flex: 1;
      margin-left: 240px;
      display: flex;
      flex-direction: column;
      height: 100vh;
      overflow: hidden;
    }

    header {
      background: #fff;
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 12px 28px;
      box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    }

    header h1 {
      font-size: 18px;
      font-weight: 500;
      color: #2563eb;
    }

    footer {
      background: #fff;
      text-align: center;
      padding: 10px;
      font-size: 13px;
      color: #666;
      border-top: 1px solid #e5e7eb;
    }

    .user-dropdown img {
      width: 38px; height: 38px;
      border-radius: 50%;
      border: 1.5px solid #2563eb;
    }

    .user-dropdown span { font-size: 15px; }
  </style>
</head>

<body class="text-gray-700">

  <!-- Sidebar -->
  <aside class="sidebar">
    <h2>HMS Panel</h2>
    <a href="dashboard.php"><i class="fa-solid fa-house"></i> Dashboard</a>
    <a href="book-appointment.php"><i class="fa-solid fa-pen-to-square"></i> Book Appointment</a>
    <a href="appointment-history.php"><i class="fa-solid fa-calendar-check"></i> Appointment History</a>
    <a href="manage-medhistory.php"><i class="fa-solid fa-file-medical"></i> Medical History</a>
    <!-- <a href="edit-profile.php"><i class="fa-solid fa-user"></i> Edit Profile</a>
    <a href="change-password.php"><i class="fa-solid fa-lock"></i> Change Password</a> -->
    <a href="change-emaild.php" class="active"><i class="fa-solid fa-envelope"></i> Change Email</a>
  </aside>

  <!-- Main Content -->
  <div class="main-content">
    <header>
      <h1>Hospital Management System</h1>
      <div class="user-dropdown flex items-center gap-2">
        <img src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png" alt="User">
        <span>
          <?php
          $query = mysqli_query($con, "SELECT fullName FROM users WHERE id='" . $_SESSION['id'] . "'");
          $row = mysqli_fetch_array($query);
          echo htmlspecialchars($row['fullName']);
          ?>
        </span>
      </div>
    </header>

    <!-- Page Body -->
    <main class="flex items-center justify-center flex-1 px-4">
      <div class="bg-white rounded-xl shadow-md border border-gray-100 w-full max-w-3xl flex overflow-hidden h-[380px]">

        <!-- Left Panel -->
        <div class="w-1/2 bg-blue-50 flex flex-col items-center justify-center p-6">
          <img src="https://cdn-icons-png.flaticon.com/512/732/732200.png"
               alt="Email Icon" class="w-24 h-24 mb-3 opacity-90">
          <h3 class="text-blue-700 font-medium text-lg">Update Your Email</h3>
          <p class="text-gray-500 text-sm mt-2 text-center px-6">
            Keep your account secure and up-to-date with your latest contact email.
          </p>
        </div>

        <!-- Right Panel -->
        <div class="w-1/2 p-8 flex flex-col justify-center">
          <h2 class="text-xl font-medium text-blue-700 mb-5 text-center">
            <i class="fa-solid fa-envelope-circle-check"></i> Change Email
          </h2>

          <?php if (!empty($msg)): ?>
            <div class="bg-green-100 text-green-700 border border-green-300 rounded-md text-sm px-3 py-2 mb-4 text-center">
              <?= htmlentities($msg); ?>
            </div>
          <?php endif; ?>

          <form method="post" id="updatemail" class="space-y-4 text-sm">
            <div>
              <label for="email" class="block text-gray-700 mb-1 font-medium">New Email</label>
              <input type="email" name="email" id="email" placeholder="Enter new email"
                     class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                     required>
              <span id="user-availability-status1" class="text-xs text-gray-500"></span>
            </div>

            <div class="text-right">
              <button type="submit" name="submit"
                      class="bg-blue-600 text-white px-6 py-2 rounded-md text-sm font-medium hover:bg-blue-700 transition-all">
                Update Email
              </button>
            </div>
          </form>
        </div>
      </div>
    </main>

    <footer>
      &copy; <?= date('Y'); ?> Hospital Management System — All Rights Reserved.
    </footer>
  </div>

  <!-- jQuery for email check -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
    function userAvailability() {
      $.ajax({
        url: "check_availability.php",
        data: 'email=' + $("#email").val(),
        type: "POST",
        success: function(data) {
          $("#user-availability-status1").html(data);
        }
      });
    }
    $("#email").on("blur", userAvailability);
  </script>
</body>
</html>

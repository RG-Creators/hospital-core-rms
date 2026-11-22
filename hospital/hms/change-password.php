<?php
session_start();
include('include/config.php');
include('include/checklogin.php');
check_login();

date_default_timezone_set('Asia/Kolkata');
$currentTime = date('d-m-Y h:i:s A', time());

if (isset($_POST['submit'])) {
    $sql = mysqli_query($con, "SELECT password FROM users WHERE password='" . md5($_POST['cpass']) . "' && id='" . $_SESSION['id'] . "'");
    $num = mysqli_fetch_array($sql);
    if ($num > 0) {
        mysqli_query($con, "UPDATE users SET password='" . md5($_POST['npass']) . "', updationDate='$currentTime' WHERE id='" . $_SESSION['id'] . "'");
        $_SESSION['msg1'] = "Password changed successfully!";
        $_SESSION['msg_type'] = "success";
    } else {
        $_SESSION['msg1'] = "Old password does not match!";
        $_SESSION['msg_type'] = "error";
    }

    // Redirect after setting message (Prevents resubmission + stops toast from reappearing)
    header("Location: change-password.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Change Password | HMS</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Fonts & Icons -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <script src="https://cdn.tailwindcss.com"></script>

  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background: #f4f6f9;
      margin: 0;
      display: flex;
      height: 100vh;
      overflow: hidden;
    }

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
      font-weight: 600;
      text-align: center;
      padding: 25px 0;
      font-size: 22px;
      border-bottom: 1px solid rgba(255,255,255,0.2);
      margin: 0;
    }

    .sidebar a {
      display: flex;
      align-items: center;
      gap: 12px;
      color: #e0e7ff;
      padding: 12px 25px;
      text-decoration: none;
      transition: all 0.25s ease;
      font-weight: 500;
    }

    .sidebar a:hover, .sidebar a.active {
      background: rgba(255,255,255,0.15);
      color: #fff;
      padding-left: 30px;
    }

    .main-content {
      flex: 1;
      margin-left: 250px;
      display: flex;
      flex-direction: column;
      height: 100vh;
      overflow-y: auto;
    }

    header {
      background: #fff;
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 15px 30px;
      box-shadow: 0 2px 6px rgba(0,0,0,0.08);
      position: sticky;
      top: 0;
      z-index: 10;
    }

    header h1 {
      font-size: 20px;
      font-weight: 600;
      color: #2563eb;
      margin: 0;
    }

    .user-dropdown {
      position: relative;
      display: flex;
      align-items: center;
      gap: 10px;
      cursor: pointer;
    }

    .user-dropdown img {
      width: 42px;
      height: 42px;
      border-radius: 50%;
      border: 2px solid #2563eb;
      object-fit: cover;
    }

    .user-dropdown span {
      font-weight: 500;
      color: #333;
    }

    .user-menu {
      display: none;
      position: absolute;
      right: 0;
      top: 55px;
      background: #fff;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
      border-radius: 10px;
      overflow: hidden;
      width: 180px;
      animation: fadeIn 0.3s ease;
    }

    .user-menu.active {
	  display: block;
	}	


    .user-menu a {
      display: block;
      padding: 10px 20px;
      text-decoration: none;
      color: #333;
      transition: background 0.2s;
    }

    .user-menu a:hover {
      background: #f2f4f8;
    }

    footer {
      background: #fff;
      text-align: center;
      padding: 15px;
      font-size: 14px;
      color: #666;
      border-top: 1px solid #e5e7eb;
    }

    .change-card {
      background: #ffffff;
      border-radius: 18px;
      overflow: hidden;
      box-shadow: 0 8px 25px rgba(0,0,0,0.05);
      display: flex;
      max-width: 820px;
      height: 420px;
      width: 100%;
    }

    .change-card-left {
      background: linear-gradient(135deg, #2563eb, #38bdf8);
      color: white;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      padding: 40px;
      text-align: center;
    }

    .change-card-left img {
      width: 95px;
      margin-bottom: 10px;
    }

    .change-card-left h2 {
      font-size: 20px;
      font-weight: 600;
    }

    .change-card-left p {
      font-size: 13px;
      margin-top: 6px;
      max-width: 230px;
      color: #e0f2ff;
    }

    .change-card-right {
      flex: 1;
      background: #f9fafb;
      padding: 40px 50px;
      display: flex;
      flex-direction: column;
      justify-content: center;
    }

    .toast {
      position: fixed;
      bottom: 25px;
      left: 50%;
      transform: translateX(-50%);
      background: #fff;
      padding: 14px 20px;
      border-radius: 10px;
      box-shadow: 0 8px 20px rgba(0,0,0,0.1);
      display: flex;
      align-items: center;
      gap: 10px;
      font-weight: 500;
      opacity: 0;
      pointer-events: none;
      transition: all 0.4s ease;
      z-index: 10000;
    }

    .toast.show {
      opacity: 1;
      bottom: 40px;
      pointer-events: all;
    }

    .toast.success {
      border-left: 5px solid #16a34a;
      color: #166534;
    }

    .toast.error {
      border-left: 5px solid #dc2626;
      color: #991b1b;
    }

    @keyframes fadeIn {
      from {opacity: 0; transform: translateY(-5px);}
      to {opacity: 1; transform: translateY(0);}
    }
  </style>
</head>

<body class="text-gray-800">
  <!-- Sidebar -->
  <aside class="sidebar">
    <h2>HMS Panel</h2>
    <ul>
      <li><a href="dashboard.php"><i class="fa-solid fa-house"></i> Dashboard</a></li>
      <li><a href="book-appointment.php"><i class="fa-solid fa-pen-to-square"></i> Book Appointment</a></li>
      <li><a href="appointment-history.php"><i class="fa-solid fa-calendar-check"></i> Appointment History</a></li>
      <li><a href="manage-medhistory.php"><i class="fa-solid fa-file-medical"></i> Medical History</a></li>
      <li><a href="change-password.php" class="active"><i class="fa-solid fa-lock"></i> Change Password</a></li>
    </ul>
  </aside>

  <div class="main-content">
    <header>
      <h1>Hospital Management System</h1>
      <div class="user-dropdown">
        <img src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png" alt="User">
        <span>
          <?php
          $query = mysqli_query($con, "SELECT fullName FROM users WHERE id='" . $_SESSION['id'] . "'");
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

    <main class="flex items-center justify-center bg-gray-50 min-h-screen -mt-[70px] -mb-[70px]">
      <div class="change-card">
        <div class="change-card-left">
          <img src="https://cdn-icons-png.flaticon.com/512/484/484167.png" alt="Security Icon">
          <h2>Secure Your Account</h2>
          <p>Keep your account safe by updating your password regularly.</p>
        </div>

        <div class="change-card-right">
          <h2 class="text-xl font-semibold text-blue-700 mb-4 flex items-center gap-2">
            <i class="fa-solid fa-lock"></i> Change Password
          </h2>

          <form name="chngpwd" method="post" onSubmit="return valid();" class="space-y-3">
            <div>
              <label class="block text-gray-700 font-medium mb-1">Current Password</label>
              <input type="password" name="cpass" placeholder="Enter Current Password"
                     class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none">
            </div>

            <div>
              <label class="block text-gray-700 font-medium mb-1">New Password</label>
              <input type="password" name="npass" placeholder="Enter New Password"
                     class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none">
            </div>

            <div>
              <label class="block text-gray-700 font-medium mb-1">Confirm Password</label>
              <input type="password" name="cfpass" placeholder="Confirm New Password"
                     class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none">
            </div>

            <div class="text-right mt-2">
              <button type="submit" name="submit"
                      class="bg-blue-600 text-white px-4 py-1.5 rounded-md text-sm font-medium shadow-md hover:bg-blue-700 transition-all">
                <i class="fa-solid fa-rotate"></i> Update
              </button>
            </div>
          </form>
        </div>
      </div>
    </main>

    <?php if (!empty($_SESSION['msg1'])): ?>
      <div id="toast" class="toast <?= $_SESSION['msg_type'] == 'success' ? 'success' : 'error'; ?>">
        <i class="fa-solid <?= $_SESSION['msg_type'] == 'success' ? 'fa-circle-check' : 'fa-circle-xmark'; ?>"></i>
        <?= htmlentities($_SESSION['msg1']); ?>
      </div>
      <script>
        setTimeout(() => document.getElementById('toast').classList.add('show'), 300);
        setTimeout(() => document.getElementById('toast').classList.remove('show'), 3500);
      </script>
      <?php
        unset($_SESSION['msg1']);
        unset($_SESSION['msg_type']);
      ?>
    <?php endif; ?>

    <footer>
      &copy; <?= date('Y'); ?> Hospital Management System. All Rights Reserved.
    </footer>
  </div>

  <script>
    function valid() {
      if (document.chngpwd.cpass.value == "") { alert("Current Password field is empty!"); return false; }
      if (document.chngpwd.npass.value == "") { alert("New Password field is empty!"); return false; }
      if (document.chngpwd.cfpass.value == "") { alert("Confirm Password field is empty!"); return false; }
      if (document.chngpwd.npass.value != document.chngpwd.cfpass.value) {
        alert("Password and Confirm Password do not match!"); return false;
      }
      return true;
    }
  </script>

  <!-- ✅ Corrected Dropdown Script -->
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

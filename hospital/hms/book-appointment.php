<?php
session_start();
include('include/config.php');
include('include/checklogin.php');
check_login();

if (isset($_POST['submit'])) {
  $specilization = $_POST['Doctorspecialization'];
  $doctorid = $_POST['doctor'];
  $userid = $_SESSION['id'];
  $fees = $_POST['fees'];
  $appdate = $_POST['appdate'];
  $time = $_POST['apptime'];
  $userstatus = 1;
  $docstatus = 1;
  $query = mysqli_query($con, "INSERT INTO appointment(doctorSpecialization,doctorId,userId,consultancyFees,appointmentDate,appointmentTime,userStatus,doctorStatus) VALUES('$specilization','$doctorid','$userid','$fees','$appdate','$time','$userstatus','$docstatus')");
  if ($query) {
    echo "<script>alert('Your appointment has been booked successfully!');</script>";
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Book Appointment | HMS</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Fonts & Tailwind -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500&display=swap" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <!-- Include Flatpickr CSS & JS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/litepicker/dist/css/litepicker.css" />
  <script src="https://cdn.jsdelivr.net/npm/litepicker/dist/bundle.js"></script>  

  <style>
    body {
      font-family: 'Inter', sans-serif;
      background-color: #f5f8fb;
      margin: 0;
      display: flex;
      height: 100vh;
      overflow: hidden;
    }

    .sidebar {
      width: 230px;
      background: linear-gradient(180deg, #2563eb, #38bdf8);
      color: #fff;
      display: flex;
      flex-direction: column;
      position: fixed;
      top: 0; bottom: 0; left: 0;
      box-shadow: 2px 0 8px rgba(0,0,0,0.08);
    }

    .sidebar h2 {
      font-weight: 500;
      text-align: center;
      padding: 22px 0;
      font-size: 18px;
      border-bottom: 1px solid rgba(255,255,255,0.2);
    }

    .sidebar a {
      display: flex;
      align-items: center;
      gap: 10px;
      color: #e0e7ff;
      padding: 9px 20px;
      text-decoration: none;
      transition: all 0.25s ease;
      font-size: 14px;
    }

    .sidebar a:hover,
    .sidebar a.active {
      background: rgba(255,255,255,0.15);
      color: #fff;
      padding-left: 26px;
    }

    .main-content {
      flex: 1;
      margin-left: 230px;
      display: flex;
      flex-direction: column;
      height: 100vh;
    }

    header {
      background: #fff;
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 12px 26px;
      box-shadow: 0 2px 5px rgba(0,0,0,0.05);
    }

    header h1 {
      font-size: 17px;
      font-weight: 500;
      color: #2563eb;
    }

    footer {
      background: #fff;
      text-align: center;
      padding: 8px;
      font-size: 13px;
      color: #666;
      border-top: 1px solid #e5e7eb;
    }

    .user-dropdown img {
      width: 36px;
      height: 36px;
      border-radius: 50%;
      border: 1.5px solid #2563eb;
    }
  </style>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
    function getdoctor(val) {
      $.ajax({
        type: "POST",
        url: "get_doctor.php",
        data: 'specilizationid=' + val,
        success: function(data) {
          $("#doctor").html(data);
        }
      });
    }
    function getfee(val) {
      $.ajax({
        type: "POST",
        url: "get_doctor.php",
        data: 'doctor=' + val,
        success: function(data) {
          $("#fees").html(data);
        }
      });
    }
  </script>

  <style>
    header {
      background: #fff;
      padding: 15px 30px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      box-shadow: 0 2px 6px rgba(0,0,0,0.08);
    }
    header h1 {
      font-size: 18px;
      color: #2563eb;
      font-weight: 500;
    }
    .user-dropdown img {
      width: 40px; height: 40px; border-radius: 50%; border: 2px solid #2563eb;
    }
    .user-menu { display: none; position: absolute; top: 55px; right: 0; background: white; border-radius: 10px; box-shadow: 0 4px 12px rgba(0,0,0,0.1);}
    .user-menu.active { display: block; }
    .user-menu a { display: block; padding: 10px 15px; color: #333; font-size: 14px; text-decoration: none; }
    .user-menu a:hover { background: #f2f4f8; }
  </style>
</head>

<body>
  <!-- Sidebar -->
  <aside class="sidebar">
    <h2>HMS Panel</h2>
    <a href="dashboard.php"><i class="fa-solid fa-house"></i> Dashboard</a>
    <a href="book-appointment.php" class="active"><i class="fa-solid fa-calendar-plus"></i> Book Appointment</a>
    <a href="appointment-history.php"><i class="fa-solid fa-clock-rotate-left"></i> Appointment History</a>
    <!-- <a href="edit-profile.php"><i class="fa-solid fa-user"></i> Edit Profile</a>
    <a href="change-password.php"><i class="fa-solid fa-lock"></i> Change Password</a> -->
    <a href="logout.php"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
  </aside>

  <!-- Main Content -->
  <div class="main-content">
      <header class="bg-white flex justify-between items-center px-8 py-3 shadow-sm border-b">
  <h1 class="text-blue-600 text-lg font-medium">Hospital Management System</h1>

  <div class="relative flex items-center gap-3 cursor-pointer user-dropdown">
    <img
      src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png"
      alt="User"
      class="w-9 h-9 rounded-full border-2 border-blue-500 object-cover"
    />
    <span class="text-gray-700 text-sm font-normal select-none">
      <?php
        $query = mysqli_query($con, "SELECT fullName FROM users WHERE id='" . $_SESSION['id'] . "'");
        $row = mysqli_fetch_array($query);
        echo htmlspecialchars($row['fullName']);
      ?>
    </span>

    <div
      class="user-menu absolute right-0 top-11 bg-white rounded-lg shadow-lg w-40 hidden flex-col overflow-hidden text-sm border border-gray-100"
    >
      <a href="edit-profile.php" class="px-4 py-2 hover:bg-gray-100 flex items-center gap-2">
        <i class="fa fa-user text-gray-500 text-xs"></i> My Profile
      </a>
      <a href="change-password.php" class="px-4 py-2 hover:bg-gray-100 flex items-center gap-2">
        <i class="fa fa-key text-gray-500 text-xs"></i> Change Password
      </a>
      <a href="logout.php" class="px-4 py-2 hover:bg-gray-100 flex items-center gap-2">
        <i class="fa fa-sign-out-alt text-gray-500 text-xs"></i> Logout
      </a>
    </div>
  </div>
</header>

<script>
    document.addEventListener("DOMContentLoaded", function() {
      const dropdown = document.querySelector(".user-dropdown");
      const menu = document.querySelector(".user-menu");
      dropdown.addEventListener("click", function(e) {
        e.stopPropagation();
        menu.classList.toggle("active");
      });
      document.addEventListener("click", function(e) {
        if (!dropdown.contains(e.target)) menu.classList.remove("active");
      });
    });
  </script>

    <main class="flex items-center justify-center flex-1 px-5">
      <div class="bg-white rounded-xl shadow-md border border-gray-100 w-full max-w-5xl flex overflow-hidden">

        <!-- Left Panel -->
        <div class="w-5/12 bg-gradient-to-b from-blue-600 to-cyan-400 text-white flex flex-col items-center justify-center p-6">
		<img src="https://cdn-icons-png.flaticon.com/512/8662/8662427.png"
		     alt="Check-Up Icon"
		     class="w-28 h-28 mb-3 drop-shadow-md">
		
          <h3 class="text-xl font-medium">Book Appointment</h3>
          <p class="text-blue-50 text-sm mt-2 text-center px-5 leading-relaxed">
            Schedule your visit quickly with our specialists. Choose your doctor, date, and time — all in one click.
          </p>
        </div>

        <!-- Right Panel -->
        <div class="w-7/12 p-8 flex flex-col justify-center">
          <h2 class="text-lg text-blue-700 mb-5 text-center">
            <i class="fa-solid fa-calendar-check mr-1"></i> Appointment Form
          </h2>

          <form method="post" class="grid grid-cols-2 gap-4 text-sm">
            <!-- Specialization -->
            <div>
              <label class="block text-gray-700 mb-1">Specialization</label>
              <select name="Doctorspecialization"
                      onChange="getdoctor(this.value);" required
                      class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                <option value="">Select</option>
                <?php
                $ret = mysqli_query($con, "SELECT * FROM doctorspecilization");
                while ($row = mysqli_fetch_array($ret)) {
                  echo '<option value="' . htmlentities($row['specilization']) . '">' . htmlentities($row['specilization']) . '</option>';
                }
                ?>
              </select>
            </div>

            <!-- Doctor -->
            <div>
              <label class="block text-gray-700 mb-1">Doctor</label>
              <select name="doctor" id="doctor"
                      onChange="getfee(this.value);" required
                      class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                <option value="">Select Doctor</option>
              </select>
            </div>

            <!-- Fees -->
            <div>
              <label class="block text-gray-700 mb-1">Fees</label>
              <select name="fees" id="fees"
                      class="w-full border border-gray-300 rounded-lg px-3 py-2 bg-gray-50 focus:outline-none">
              </select>
            </div>

            <!-- Date -->
            <div>
              <label class="block text-gray-700 mb-1">Date</label>
              <input id="appdate" name="appdate"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    required>
            </div>
            
                        
            <script>
              const picker = new Litepicker({
                element: document.getElementById('appdate'),
                format: 'YYYY-MM-DD',
                minDate: new Date(),
                singleMode: true,
                autoApply: true,
              });
            </script>
            
            <!-- Time -->
            <div>
              <label class="block text-gray-700 mb-1">Time</label>
              <input type="time" name="apptime"
                     class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                     required>
            </div>

            <!-- Submit -->
            <div class="col-span-2 text-right mt-3">
              <button type="submit" name="submit"
                      class="bg-blue-600 text-white px-6 py-2 rounded-md font-medium hover:bg-blue-700 transition-all">
                Submit
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
</body>
</html>

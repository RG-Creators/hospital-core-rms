<?php
session_start();
error_reporting(0);
include('include/config.php');
if (strlen($_SESSION['id'] == 0)) {
    header('location:logout.php');
} else {
    if (isset($_GET['cancel'])) {
        mysqli_query($con, "UPDATE appointment SET userStatus='0' WHERE id = '" . $_GET['id'] . "'");
        $_SESSION['msg'] = "Your appointment canceled !!";
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>User | Appointment History</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Fonts & Icons -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <!-- Tailwind CSS CDN -->
  <script src="https://cdn.tailwindcss.com"></script>

  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background-color: #f4f6f9;
    }
    .sidebar {
      width: 250px;
      background: linear-gradient(180deg, #2563eb, #38bdf8);
      color: #fff;
      position: fixed;
      top: 0; bottom: 0; left: 0;
      display: flex;
      flex-direction: column;
      box-shadow: 2px 0 8px rgba(0,0,0,0.1);
      z-index: 50;
    }
    .sidebar h2 {
      font-weight: 600;
      font-size: 20px;
      padding: 20px;
      text-align: center;
      border-bottom: 1px solid rgba(255,255,255,0.2);
    }
    .sidebar a {
      display: flex;
      align-items: center;
      gap: 10px;
      padding: 12px 25px;
      color: #e0e7ff;
      text-decoration: none;
      font-size: 14px;
      transition: all 0.2s;
    }
    .sidebar a:hover, .sidebar a.active {
      background: rgba(255,255,255,0.15);
      color: #fff;
      padding-left: 30px;
    }
    .main-content {
      margin-left: 250px;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
    }
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

<body class="overflow-x-hidden">

  <!-- Sidebar -->
  <aside class="sidebar">
    <h2>HMS Panel</h2>
    <nav>
      <a href="dashboard.php"><i class="fa-solid fa-house"></i> Dashboard</a>
      <a href="book-appointment.php"><i class="fa-solid fa-pen-to-square"></i> Book Appointment</a>
      <a href="appointment-history.php" class="active"><i class="fa-solid fa-calendar-check"></i> Appointment History</a>
      <a href="manage-medhistory.php"><i class="fa-solid fa-file-medical"></i> Medical History</a>
    </nav>
  </aside>

  <!-- Main -->
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


    <main class="p-8 bg-[#f4f6f9] flex-1">
      <h2 class="text-xl text-blue-700 mb-6 font-medium">Appointment History</h2>

      <!-- Session message -->
      <?php if ($_SESSION['msg']) { ?>
        <div class="bg-blue-100 text-blue-800 p-3 rounded-md text-sm mb-4 border border-blue-300">
          <?php echo htmlentities($_SESSION['msg']); $_SESSION['msg'] = ""; ?>
        </div>
      <?php } ?>

      <!-- Table -->
      <div class="bg-white shadow-md rounded-xl overflow-hidden">
        <div class="overflow-x-auto">
          <table class="min-w-full text-sm text-gray-700">
            <thead class="bg-blue-600 text-white">
              <tr>
                <th class="py-3 px-4 text-left">#</th>
                <th class="py-3 px-4 text-left">Doctor Name</th>
                <th class="py-3 px-4 text-left">Specialization</th>
                <th class="py-3 px-4 text-left">Fee</th>
                <th class="py-3 px-4 text-left">Date / Time</th>
                <th class="py-3 px-4 text-left">Created On</th>
                <th class="py-3 px-4 text-left">Status</th>
                <th class="py-3 px-4 text-left">Action</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
              <?php
              $sql = mysqli_query($con, "SELECT doctors.doctorName AS docname, appointment.* FROM appointment JOIN doctors ON doctors.id=appointment.doctorId WHERE appointment.userId='" . $_SESSION['id'] . "'");
              $cnt = 1;
              while ($row = mysqli_fetch_array($sql)) {
              ?>
              <tr class="hover:bg-blue-50 transition-all">
                <td class="py-3 px-4"><?php echo $cnt; ?>.</td>
                <td class="py-3 px-4"><?php echo htmlentities($row['docname']); ?></td>
                <td class="py-3 px-4"><?php echo htmlentities($row['doctorSpecialization']); ?></td>
                <td class="py-3 px-4"><?php echo htmlentities($row['consultancyFees']); ?></td>
                <td class="py-3 px-4"><?php echo htmlentities($row['appointmentDate']); ?> / <?php echo htmlentities($row['appointmentTime']); ?></td>
                <td class="py-3 px-4"><?php echo htmlentities($row['postingDate']); ?></td>
                <td class="py-3 px-4">
                  <?php
                    if (($row['userStatus'] == 1) && ($row['doctorStatus'] == 1)) echo '<span class="text-green-600 font-medium">Active</span>';
                    else if (($row['userStatus'] == 0) && ($row['doctorStatus'] == 1)) echo '<span class="text-red-500 font-medium">Canceled by You</span>';
                    else if (($row['userStatus'] == 1) && ($row['doctorStatus'] == 0)) echo '<span class="text-red-500 font-medium">Canceled by Doctor</span>';
                  ?>
                </td>
                <td class="py-3 px-4">
                  <?php if (($row['userStatus'] == 1) && ($row['doctorStatus'] == 1)) { ?>
                    <a href="appointment-history.php?id=<?php echo $row['id'] ?>&cancel=update"
                       onclick="return confirm('Are you sure you want to cancel this appointment?')"
                       class="bg-blue-600 hover:bg-blue-700 text-white text-xs px-3 py-1.5 rounded-md transition">
                      Cancel
                    </a>
                  <?php } else { echo '<span class="text-gray-400 text-xs">Canceled</span>'; } ?>
                </td>
              </tr>
              <?php $cnt++; } ?>
            </tbody>
          </table>
        </div>
      </div>
    </main>

    <footer class="bg-white text-center py-3 text-sm text-gray-500 border-t">
      &copy; <?php echo date('Y'); ?> Hospital Management System. All Rights Reserved.
    </footer>
  </div>

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
</body>
</html>
<?php } ?>

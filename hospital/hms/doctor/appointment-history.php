<?php
session_start();
error_reporting(0);
include('include/config.php');

if (strlen($_SESSION['id'] == 0)) {
    header('location:logout.php');
} else {

if (isset($_GET['cancel'])) {
    mysqli_query($con, "UPDATE appointment SET doctorStatus='0' WHERE id = '" . $_GET['id'] . "'");
    $_SESSION['msg'] = "Appointment canceled!";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Doctor | Appointment History</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background: #f9fafb;
      color: #1f2937;
    }
    .sidebar {
      background: linear-gradient(180deg, #60a5fa, #3b82f6);
      color: white;
      transition: all 0.3s ease;
    }
    .sidebar.hidden { transform: translateX(-100%); }
    .nav-link {
      transition: all 0.2s ease;
      border-radius: 8px;
    }
    .nav-link:hover {
      background: rgba(255, 255, 255, 0.15);
    }
    .card {
      background: white;
      border-radius: 14px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }
  </style>
</head>
<body class="flex min-h-screen overflow-auto">

  <!-- Sidebar -->
  <aside id="sidebar" class="sidebar w-64 fixed top-0 left-0 bottom-0 z-30 flex flex-col">
    <div class="p-6 text-center border-b border-white/20">
      <img src="https://cdn-icons-png.flaticon.com/512/3774/3774299.png" alt="Doctor Icon" class="w-12 h-12 mx-auto mb-2">
      <h2 class="text-xl font-semibold">HMS Doctor</h2>
    </div>
    <nav class="flex-1 overflow-y-auto mt-4 px-2 space-y-1">
      <a href="dashboard.php" class="nav-link flex items-center px-4 py-2 text-sm"><i class="fa-solid fa-house mr-3 text-white"></i>Dashboard</a>
      <a href="appointment-history.php" class="nav-link flex items-center px-4 py-2 text-sm bg-white/20"><i class="fa-solid fa-clock-rotate-left mr-3 text-white"></i>Appointment History</a>
      <button onclick="toggleMenu('patientsMenu')" class="w-full text-left flex items-center px-4 py-2 nav-link text-sm focus:outline-none">
        <i class="fa-solid fa-user-group mr-3 text-white"></i>Patients<i class="fa-solid fa-chevron-down ml-auto text-xs"></i>
      </button>
      <ul id="patientsMenu" class="ml-8 hidden space-y-1">
        <li><a href="add-patient.php" class="block py-1.5 text-sm text-white/90 hover:text-white">Add Patient</a></li>
        <li><a href="manage-patient.php" class="block py-1.5 text-sm text-white/90 hover:text-white">Manage Patient</a></li>
      </ul>
      <a href="search.php" class="nav-link flex items-center px-4 py-2 text-sm"><i class="fa-solid fa-magnifying-glass mr-3 text-white"></i>Search</a>
    </nav>
    <div class="mt-auto p-4 text-center border-t border-white/20 text-xs text-white/70">
      <p>&copy; <?php echo date('Y'); ?> HMS</p>
    </div>
  </aside>

  <!-- Main Content -->
  <div class="flex-1 flex flex-col ml-64 min-h-screen transition-all duration-300">

    <!-- Header -->
    <header class="bg-white shadow-sm border-b border-gray-100 flex justify-between items-center px-6 py-3 sticky top-0 z-20">
      <div class="flex items-center gap-4">
        <button class="lg:hidden text-gray-700 hover:text-blue-600" id="toggleSidebar"><i class="fa-solid fa-bars text-xl"></i></button>
        <h1 class="text-xl font-semibold text-blue-600">Appointment History</h1>
      </div>
      <div class="relative">
        <button id="profileBtn" class="flex items-center gap-3 focus:outline-none">
          <img src="https://cdn-icons-png.flaticon.com/512/3774/3774299.png" class="w-10 h-10 rounded-full border-2 border-blue-400" alt="Doctor">
          <div class="flex flex-col items-start">
            <span class="text-sm font-medium text-gray-700">
              <?php
              $query = mysqli_query($con, "SELECT doctorName FROM doctors WHERE id='" . $_SESSION['id'] . "'");
              $row = mysqli_fetch_array($query);
              echo htmlspecialchars($row['doctorName']);
              ?>
            </span>
            <span class="text-xs text-gray-400">Doctor</span>
          </div>
          <i class="fa-solid fa-chevron-down text-gray-400 ml-1"></i>
        </button>
        <div id="profileMenu" class="absolute right-0 mt-3 w-52 bg-white border border-gray-100 rounded-xl shadow-md hidden">
          <a href="edit-profile.php" class="block px-4 py-2 text-sm hover:bg-blue-50 text-gray-700"><i class="fa-solid fa-user-pen mr-2 text-blue-600"></i>My Profile</a>
          <a href="change-password.php" class="block px-4 py-2 text-sm hover:bg-blue-50 text-gray-700"><i class="fa-solid fa-lock mr-2 text-blue-600"></i>Change Password</a>
          <div class="border-t my-1"></div>
          <a href="logout.php" class="block px-4 py-2 text-sm hover:bg-red-50 text-red-600"><i class="fa-solid fa-right-from-bracket mr-2"></i>Logout</a>
        </div>
      </div>
    </header>

    <!-- Page Body -->
    <main class="flex-1 p-8 bg-gradient-to-br from-blue-50 to-white overflow-y-auto">
      <div class="card p-6">
        <h2 class="text-lg font-semibold mb-2 text-gray-700">Your Appointment History</h2>
        <?php if($_SESSION['msg']) { ?>
          <div class="mb-4 p-3 text-sm text-white bg-green-500 rounded-md">
            <?php echo htmlentities($_SESSION['msg']); $_SESSION['msg'] = ""; ?>
          </div>
        <?php } ?>

        <div class="overflow-x-auto mt-4">
          <table class="min-w-full border border-gray-200 divide-y divide-gray-200 text-sm">
            <thead class="bg-blue-500 text-white">
              <tr>
                <th class="px-4 py-2 text-left">#</th>
                <th class="px-4 py-2 text-left">Patient Name</th>
                <th class="px-4 py-2 text-left">Specialization</th>
                <th class="px-4 py-2 text-left">Consultancy Fee</th>
                <th class="px-4 py-2 text-left">Appointment Date / Time</th>
                <th class="px-4 py-2 text-left">Created On</th>
                <th class="px-4 py-2 text-left">Status</th>
                <th class="px-4 py-2 text-center">Action</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 bg-white">
              <?php
              $sql = mysqli_query($con, "SELECT users.fullName as fname, appointment.* FROM appointment JOIN users ON users.id=appointment.userId WHERE appointment.doctorId='" . $_SESSION['id'] . "'");
              $cnt = 1;
              while ($row = mysqli_fetch_array($sql)) {
              ?>
              <tr class="hover:bg-gray-50 transition">
                <td class="px-4 py-2"><?php echo $cnt; ?>.</td>
                <td class="px-4 py-2"><?php echo $row['fname']; ?></td>
                <td class="px-4 py-2"><?php echo $row['doctorSpecialization']; ?></td>
                <td class="px-4 py-2"><?php echo $row['consultancyFees']; ?></td>
                <td class="px-4 py-2"><?php echo $row['appointmentDate']; ?> / <?php echo $row['appointmentTime']; ?></td>
                <td class="px-4 py-2"><?php echo $row['postingDate']; ?></td>
                <td class="px-4 py-2">
                  <?php
                  if (($row['userStatus'] == 1) && ($row['doctorStatus'] == 1)) echo '<span class="text-green-600 font-medium">Active</span>';
                  elseif (($row['userStatus'] == 0) && ($row['doctorStatus'] == 1)) echo '<span class="text-yellow-600 font-medium">Cancelled by Patient</span>';
                  elseif (($row['userStatus'] == 1) && ($row['doctorStatus'] == 0)) echo '<span class="text-red-600 font-medium">Cancelled by You</span>';
                  ?>
                </td>
                <td class="px-4 py-2 text-center">
                  <?php if (($row['userStatus'] == 1) && ($row['doctorStatus'] == 1)) { ?>
                    <a href="appointment-history.php?id=<?php echo $row['id'] ?>&cancel=update" onClick="return confirm('Are you sure you want to cancel this appointment?')" class="inline-block bg-red-500 text-white px-3 py-1 rounded-md text-xs font-medium hover:bg-red-600 transition">Cancel</a>
                  <?php } else { ?>
                    <span class="text-gray-400 text-xs">Canceled</span>
                  <?php } ?>
                </td>
              </tr>
              <?php $cnt++; } ?>
            </tbody>
          </table>
        </div>
      </div>
    </main>

    <!-- Footer -->
    <footer class="bg-white text-center text-gray-500 text-sm py-4 border-t border-gray-100">
      <p>© <?php echo date('Y'); ?> Hospital Management System | Designed with 💙 for Doctors</p>
    </footer>
  </div>

  <!-- JS -->
  <script>
    const sidebar = document.getElementById('sidebar');
    const toggleSidebar = document.getElementById('toggleSidebar');
    const profileBtn = document.getElementById('profileBtn');
    const profileMenu = document.getElementById('profileMenu');

    toggleSidebar.addEventListener('click', () => {
      sidebar.classList.toggle('hidden');
    });

    profileBtn.addEventListener('click', () => {
      profileMenu.classList.toggle('hidden');
    });

    document.addEventListener('click', (e) => {
      if (!profileBtn.contains(e.target) && !profileMenu.contains(e.target)) {
        profileMenu.classList.add('hidden');
      }
    });

    function toggleMenu(id) {
      document.getElementById(id).classList.toggle('hidden');
    }
  </script>
</body>
</html>
<?php } ?>

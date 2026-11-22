<?php
session_start();
error_reporting(0);
include('include/config.php');

if (strlen($_SESSION['id'] == 0)) {
    header('location:logout.php');
} else {
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Doctor | Manage Patients</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

  <style>
    body { font-family: 'Poppins', sans-serif; background: #f9fafb; color: #1f2937; }
    .sidebar { background: linear-gradient(180deg, #60a5fa, #3b82f6); color: white; transition: all 0.3s ease; }
    .nav-link:hover { background: rgba(255,255,255,0.15); border-radius: 8px; }
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
      <a href="appointment-history.php" class="nav-link flex items-center px-4 py-2 text-sm"><i class="fa-solid fa-clock-rotate-left mr-3 text-white"></i>Appointment History</a>
      <button onclick="toggleMenu('patientsMenu')" class="w-full text-left flex items-center px-4 py-2 nav-link text-sm focus:outline-none">
        <i class="fa-solid fa-user-group mr-3 text-white"></i>Patients<i class="fa-solid fa-chevron-down ml-auto text-xs"></i>
      </button>
      <ul id="patientsMenu" class="ml-8 space-y-1">
        <li><a href="add-patient.php" class="block py-1.5 text-sm text-white/90 hover:text-white">Add Patient</a></li>
        <li><a href="manage-patient.php" class="block py-1.5 text-sm text-white font-semibold">Manage Patient</a></li>
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
        <h1 class="text-xl font-semibold text-blue-600">Manage Patients</h1>
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

    <!-- Main Section -->
    <main class="flex-1 bg-gradient-to-br from-blue-50 to-white p-6 overflow-auto">
      <div class="max-w-6xl mx-auto bg-white p-6 rounded-2xl shadow-lg border border-gray-100">
        <div class="flex justify-between items-center mb-4">
          <h2 class="text-lg font-semibold text-gray-700">All Patients</h2>
          <a href="add-patient.php" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium shadow-sm transition">
            <i class="fa-solid fa-plus mr-2"></i> Add Patient
          </a>
        </div>

        <div class="overflow-x-auto">
          <table class="min-w-full text-sm text-left border-collapse">
            <thead class="bg-blue-100 text-gray-700">
              <tr>
                <th class="px-4 py-2">#</th>
                <th class="px-4 py-2">Patient Name</th>
                <th class="px-4 py-2">Contact No.</th>
                <th class="px-4 py-2">Gender</th>
                <th class="px-4 py-2">Created</th>
                <th class="px-4 py-2">Updated</th>
                <th class="px-4 py-2 text-center">Actions</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
              <?php
              $docid = $_SESSION['id'];
              $sql = mysqli_query($con, "SELECT * FROM tblpatient WHERE Docid='$docid'");
              $cnt = 1;
              while ($row = mysqli_fetch_array($sql)) {
              ?>
              <tr class="hover:bg-blue-50 transition">
                <td class="px-4 py-2 font-medium text-gray-600"><?php echo $cnt; ?>.</td>
                <td class="px-4 py-2"><?php echo $row['PatientName']; ?></td>
                <td class="px-4 py-2"><?php echo $row['PatientContno']; ?></td>
                <td class="px-4 py-2 capitalize"><?php echo $row['PatientGender']; ?></td>
                <td class="px-4 py-2 text-gray-500"><?php echo $row['CreationDate']; ?></td>
                <td class="px-4 py-2 text-gray-500"><?php echo $row['UpdationDate']; ?></td>
                <td class="px-4 py-2 text-center space-x-2">
                  <a href="edit-patient.php?editid=<?php echo $row['ID']; ?>" target="_blank" class="px-3 py-1 bg-blue-500 hover:bg-blue-600 text-white text-xs rounded-lg transition">Edit</a>
                  <a href="view-patient.php?viewid=<?php echo $row['ID']; ?>" target="_blank" class="px-3 py-1 bg-amber-500 hover:bg-amber-600 text-white text-xs rounded-lg transition">View</a>
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
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
    const sidebar = document.getElementById('sidebar');
    const toggleSidebar = document.getElementById('toggleSidebar');
    const profileBtn = document.getElementById('profileBtn');
    const profileMenu = document.getElementById('profileMenu');

    if (toggleSidebar) {
      toggleSidebar.addEventListener('click', () => sidebar.classList.toggle('hidden'));
    }
    profileBtn.addEventListener('click', () => profileMenu.classList.toggle('hidden'));
    document.addEventListener('click', (e) => {
      if (!profileBtn.contains(e.target) && !profileMenu.contains(e.target)) profileMenu.classList.add('hidden');
    });

    function toggleMenu(id) {
      document.getElementById(id).classList.toggle('hidden');
    }
  </script>
</body>
</html>
<?php } ?>

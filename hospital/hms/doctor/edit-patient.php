<?php
session_start();
error_reporting(0);
include('include/config.php');

if (strlen($_SESSION['id'] == 0)) {
  header('location:logout.php');
  exit();
}

if (isset($_POST['submit'])) {
  $eid = $_GET['editid'];
  $patname = $_POST['patname'];
  $patcontact = $_POST['patcontact'];
  $patemail = $_POST['patemail'];
  $gender = $_POST['gender'];
  $pataddress = $_POST['pataddress'];
  $patage = $_POST['patage'];
  $medhis = $_POST['medhis'];

  $sql = mysqli_query($con, "UPDATE tblpatient SET 
      PatientName='$patname',
      PatientContno='$patcontact',
      PatientEmail='$patemail',
      PatientGender='$gender',
      PatientAdd='$pataddress',
      PatientAge='$patage',
      PatientMedhis='$medhis'
      WHERE ID='$eid'");

  if ($sql) {
    $_SESSION['success_msg'] = "✅ Patient information updated successfully.";
    header('Location: manage-patient.php');
    exit();
  } else {
    $_SESSION['error_msg'] = "❌ Something went wrong. Please try again.";
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Doctor | Edit Patient</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    body { font-family: 'Poppins', sans-serif; background: #f9fafb; color: #1f2937; }
    .sidebar { background: linear-gradient(180deg, #60a5fa, #3b82f6); color: white; transition: all 0.3s ease; }
    .sidebar.hidden { transform: translateX(-100%); }
    .nav-link { transition: all 0.2s; border-radius: 8px; }
    .nav-link:hover { background: rgba(255,255,255,0.15); }
    .card { background: white; border-radius: 14px; box-shadow: 0 6px 20px rgba(0,0,0,0.05); transition: transform 0.3s ease, box-shadow 0.3s ease; }
    .card:hover { transform: translateY(-5px); box-shadow: 0 10px 25px rgba(0,0,0,0.08); }
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
        <h1 class="text-xl font-semibold text-blue-600">Edit Patient</h1>
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

    <!-- Edit Patient Form -->
    <main class="flex-1 p-8 bg-gradient-to-br from-blue-50 to-white">
      <div class="card p-8 max-w-5xl mx-auto rounded-2xl shadow-lg bg-white">
        <div class="mb-8 text-center">
          <img src="https://cdn-icons-png.flaticon.com/512/6401/6401060.png" alt="Edit Patient" class="w-28 mx-auto mb-3">
          <h2 class="text-2xl font-semibold text-blue-600 mb-1">Edit Patient Information</h2>
          <p class="text-gray-500 text-sm">Update patient records accurately and efficiently.</p>
        </div>

        <?php
        $eid = intval($_GET['editid']);
        $ret = mysqli_query($con, "SELECT * FROM tblpatient WHERE ID='$eid'");
        while ($row = mysqli_fetch_array($ret)) {
        ?>
        <form method="post" class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
            <input type="text" name="patname" value="<?php echo htmlentities($row['PatientName']); ?>" required
              class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Contact Number</label>
            <input type="text" name="patcontact" maxlength="10" pattern="[0-9]+" value="<?php echo htmlentities($row['PatientContno']); ?>" required
              class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
            <input type="email" name="patemail" value="<?php echo htmlentities($row['PatientEmail']); ?>" readonly
              class="w-full border border-gray-300 rounded-lg px-3 py-2 bg-gray-100 cursor-not-allowed">
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Gender</label>
            <div class="flex items-center gap-6 mt-1">
              <label class="inline-flex items-center gap-2">
                <input type="radio" name="gender" value="Male" <?php if ($row['PatientGender'] == "Male") echo "checked"; ?> class="text-blue-600">
                <span class="text-sm">Male</span>
              </label>
              <label class="inline-flex items-center gap-2">
                <input type="radio" name="gender" value="Female" <?php if ($row['PatientGender'] == "Female") echo "checked"; ?> class="text-blue-600">
                <span class="text-sm">Female</span>
              </label>
            </div>
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Address</label>
            <textarea name="pataddress" rows="2" required
              class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"><?php echo htmlentities($row['PatientAdd']); ?></textarea>
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Age</label>
            <input type="text" name="patage" value="<?php echo htmlentities($row['PatientAge']); ?>" required
              class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Creation Date</label>
            <input type="text" readonly value="<?php echo htmlentities($row['CreationDate']); ?>"
              class="w-full border border-gray-300 rounded-lg px-3 py-2 bg-gray-100 cursor-not-allowed">
          </div>

          <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-700 mb-1">Medical History</label>
            <textarea name="medhis" rows="3" required
              class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"><?php echo htmlentities($row['PatientMedhis']); ?></textarea>
          </div>

          <div class="md:col-span-2 flex justify-end gap-3 pt-4">
            <a href="manage-patient.php" class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-100 text-sm">Cancel</a>
            <button type="submit" name="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg text-sm shadow-md transition-all">Update</button>
          </div>
        </form>
        <?php } ?>
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

    toggleSidebar.addEventListener('click', () => sidebar.classList.toggle('hidden'));
    profileBtn.addEventListener('click', () => profileMenu.classList.toggle('hidden'));
    document.addEventListener('click', (e) => {
      if (!profileBtn.contains(e.target) && !profileMenu.contains(e.target)) profileMenu.classList.add('hidden');
    });
    function toggleMenu(id) { document.getElementById(id).classList.toggle('hidden'); }
  </script>
</body>

</html>

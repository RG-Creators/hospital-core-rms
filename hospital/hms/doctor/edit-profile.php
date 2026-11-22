<?php
session_start();
error_reporting(0);
include('include/config.php');

if (strlen($_SESSION['id'] == 0)) {
    header('location:logout.php');
} else {
    if (isset($_POST['submit'])) {
        $docspecialization = $_POST['Doctorspecialization'];
        $docname = $_POST['docname'];
        $docaddress = $_POST['clinicaddress'];
        $docfees = $_POST['docfees'];
        $doccontactno = $_POST['doccontact'];
        $docemail = $_POST['docemail'];

        $sql = mysqli_query($con, "UPDATE doctors SET specilization='$docspecialization', doctorName='$docname', address='$docaddress', docFees='$docfees', contactno='$doccontactno' WHERE id='" . $_SESSION['id'] . "'");
        if ($sql) {
            echo "<script>alert('Doctor Details updated Successfully');</script>";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Doctor | Edit Profile</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Tailwind & Fonts -->
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background: #f9fafb;
    }
    .sidebar {
      transition: all 0.3s ease;
      background: linear-gradient(180deg, #60a5fa, #3b82f6);
      color: white;
    }
    .sidebar.hidden { transform: translateX(-100%); }
    .nav-link:hover { background: rgba(255,255,255,0.15); }
    .card {
      background: white;
      border-radius: 12px;
      box-shadow: 0 6px 20px rgba(0,0,0,0.05);
      transition: 0.3s;
    }
    .card:hover { transform: translateY(-2px); }
    input, select, textarea { font-family: 'Poppins', sans-serif; }
  </style>
</head>
<body class="flex min-h-screen overflow-hidden">

  <!-- Sidebar -->
  <aside id="sidebar" class="sidebar w-64 fixed top-0 left-0 bottom-0 z-30 flex flex-col">
    <div class="p-6 text-center border-b border-white/20">
      <img src="https://cdn-icons-png.flaticon.com/512/3774/3774299.png" alt="Doctor Icon" class="w-12 h-12 mx-auto mb-2">
      <h2 class="text-xl font-semibold">HMS Doctor</h2>
    </div>
    <nav class="flex-1 overflow-y-auto mt-4 px-2 space-y-1">
      <a href="dashboard.php" class="nav-link flex items-center px-4 py-2 text-sm"><i class="fa-solid fa-house mr-3"></i>Dashboard</a>
      <a href="appointment-history.php" class="nav-link flex items-center px-4 py-2 text-sm"><i class="fa-solid fa-clock-rotate-left mr-3"></i>Appointment History</a>
      <button onclick="toggleMenu('patientsMenu')" class="w-full text-left flex items-center px-4 py-2 nav-link text-sm focus:outline-none">
        <i class="fa-solid fa-user-group mr-3"></i>Patients<i class="fa-solid fa-chevron-down ml-auto text-xs"></i>
      </button>
      <ul id="patientsMenu" class="ml-8 hidden space-y-1">
        <li><a href="add-patient.php" class="block py-1.5 text-sm text-white/90 hover:text-white">Add Patient</a></li>
        <li><a href="manage-patient.php" class="block py-1.5 text-sm text-white/90 hover:text-white">Manage Patient</a></li>
      </ul>
      <a href="search.php" class="nav-link flex items-center px-4 py-2 text-sm"><i class="fa-solid fa-magnifying-glass mr-3"></i>Search</a>
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
        <h1 class="text-xl font-semibold text-blue-600">Edit Doctor Profile</h1>
      </div>
      <div class="relative">
        <button id="profileBtn" class="flex items-center gap-3 focus:outline-none">
          <img src="https://cdn-icons-png.flaticon.com/512/3774/3774299.png" class="w-9 h-9 rounded-full border-2 border-blue-400" alt="Doctor">
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

    <!-- Body -->
    <main class="flex-1 p-6 bg-gradient-to-br from-blue-50 to-white flex items-center justify-center">
      <div class="w-full max-w-6xl grid grid-cols-2 gap-6 items-start">

        <!-- Left Panel -->
        <div class="card p-6 h-[480px] flex flex-col justify-center text-center">
          <?php
          $did = $_SESSION['dlogin'];
          $sql = mysqli_query($con, "SELECT * FROM doctors WHERE docEmail='$did'");
          while ($data = mysqli_fetch_array($sql)) {
          ?>
          <img src="https://cdn-icons-png.flaticon.com/512/3774/3774299.png" class="w-20 h-20 mb-3 mx-auto rounded-full border-4 border-blue-200">
          <h2 class="text-lg font-semibold text-blue-600 mb-1"><?php echo htmlentities($data['doctorName']); ?></h2>
          <p class="text-gray-500 text-sm mb-3"><?php echo htmlentities($data['specilization']); ?></p>
          <div class="text-sm text-gray-600 space-y-1">
            <p><b>Email:</b> <?php echo htmlentities($data['docEmail']); ?></p>
            <p><b>Contact:</b> <?php echo htmlentities($data['contactno']); ?></p>
            <p><b>Reg. Date:</b> <?php echo htmlentities($data['creationDate']); ?></p>
            <?php if ($data['updationDate']) { ?>
              <p><b>Last Updated:</b> <?php echo htmlentities($data['updationDate']); ?></p>
            <?php } ?>
          </div>
        </div>

        <!-- Right Panel -->
        <div class="card p-6 h-[480px] overflow-y-auto">
          <h3 class="text-lg font-semibold text-blue-600 mb-4">Update Details</h3>
          <form method="post" class="grid grid-cols-2 gap-4 text-sm">
            <div class="col-span-2">
              <label class="block font-medium text-gray-700 mb-1">Specialization</label>
              <select name="Doctorspecialization" class="w-full border-gray-300 rounded-lg p-1.5 focus:ring-2 focus:ring-blue-400 text-sm">
                <option value="<?php echo htmlentities($data['specilization']); ?>">
                  <?php echo htmlentities($data['specilization']); ?>
                </option>
                <?php
                $ret = mysqli_query($con, "SELECT * FROM doctorspecilization");
                while ($row = mysqli_fetch_array($ret)) {
                  echo '<option value="' . htmlentities($row['specilization']) . '">' . htmlentities($row['specilization']) . '</option>';
                }
                ?>
              </select>
            </div>

            <div>
              <label class="block font-medium text-gray-700 mb-1">Name</label>
              <input type="text" name="docname" value="<?php echo htmlentities($data['doctorName']); ?>" class="w-full border-gray-300 rounded-lg p-1.5 focus:ring-2 focus:ring-blue-400">
            </div>

            <div>
              <label class="block font-medium text-gray-700 mb-1">Contact</label>
              <input type="text" name="doccontact" value="<?php echo htmlentities($data['contactno']); ?>" class="w-full border-gray-300 rounded-lg p-1.5 focus:ring-2 focus:ring-blue-400" required>
            </div>

            <div>
              <label class="block font-medium text-gray-700 mb-1">Fees</label>
              <input type="text" name="docfees" value="<?php echo htmlentities($data['docFees']); ?>" class="w-full border-gray-300 rounded-lg p-1.5 focus:ring-2 focus:ring-blue-400" required>
            </div>

            <div>
              <label class="block font-medium text-gray-700 mb-1">Email</label>
              <input type="email" name="docemail" value="<?php echo htmlentities($data['docEmail']); ?>" readonly class="w-full border-gray-300 bg-gray-100 rounded-lg p-1.5">
            </div>

            <div class="col-span-2">
              <label class="block font-medium text-gray-700 mb-1">Clinic Address</label>
              <textarea name="clinicaddress" rows="2" class="w-full border-gray-300 rounded-lg p-1.5 focus:ring-2 focus:ring-blue-400"><?php echo htmlentities($data['address']); ?></textarea>
            </div>

            <div class="col-span-2">
              <button type="submit" name="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition text-sm font-medium">Update</button>
            </div>
          </form>
          <?php } ?>
        </div>
      </div>
    </main>

    <!-- Footer -->
    <!-- <footer class="bg-white text-center text-gray-500 text-sm py-3 border-t border-gray-100">
      <p>© <?php echo date('Y'); ?> Hospital Management System | Designed with 💙 for Doctors</p>
    </footer> -->

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
<?php } ?>

<?php
session_start();
error_reporting(0);
include('include/config.php');
if (strlen($_SESSION['id'] == 0)) {
  header('location:logout.php');
} else {
  if (isset($_POST['submit'])) {
    $vid = $_GET['viewid'];
    $bp = $_POST['bp'];
    $bs = $_POST['bs'];
    $weight = $_POST['weight'];
    $temp = $_POST['temp'];
    $pres = $_POST['pres'];

    $query = mysqli_query($con, "INSERT INTO tblmedicalhistory (PatientID, BloodPressure, BloodSugar, Weight, Temperature, MedicalPres) VALUES ('$vid', '$bp', '$bs', '$weight', '$temp', '$pres')");
    if ($query) {
      echo '<script>alert("Medical history has been added."); window.location.href="view-patient.php?viewid=' . $vid . '";</script>';
    } else {
      echo '<script>alert("Something Went Wrong. Please try again");</script>';
    }
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>View Patient | Doctor Dashboard</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    body { font-family: 'Poppins', sans-serif; background: #f9fafb; color: #1f2937; }
    .sidebar { background: linear-gradient(180deg, #60a5fa, #3b82f6); color: white; transition: all 0.3s; }
    .sidebar.hidden { transform: translateX(-100%); }
    .nav-link:hover { background: rgba(255,255,255,0.15); border-radius: 8px; }
    .card { background: white; border-radius: 14px; box-shadow: 0 6px 20px rgba(0,0,0,0.05); }
    .popup-overlay { background: rgba(0,0,0,0.5); }
    .popup-card { animation: fadeIn 0.3s ease; }
    @keyframes fadeIn {
      from { opacity: 0; transform: scale(0.95); }
      to { opacity: 1; transform: scale(1); }
    }
  </style>
</head>
<body class="flex min-h-screen overflow-x-hidden">

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
  <div class="flex-1 flex flex-col ml-64 min-h-screen">

    <!-- Header -->
    <header class="bg-white shadow-sm border-b border-gray-100 flex justify-between items-center px-6 py-3 sticky top-0 z-20">
      <h1 class="text-xl font-semibold text-blue-600">View Patient</h1>
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

    <!-- Main Body -->
    <main class="flex-1 p-8 bg-gradient-to-br from-blue-50 to-white">

      <!-- Patient Details -->
      <div class="card p-6 mb-8">
        <h2 class="text-lg font-semibold text-blue-600 mb-4">Patient Details</h2>
        <?php
        $vid = $_GET['viewid'];
        $ret = mysqli_query($con, "SELECT * FROM tblpatient WHERE ID='$vid'");
        while ($row = mysqli_fetch_array($ret)) {
        ?>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
          <p><strong>Name:</strong> <?php echo $row['PatientName']; ?></p>
          <p><strong>Email:</strong> <?php echo $row['PatientEmail']; ?></p>
          <p><strong>Contact:</strong> <?php echo $row['PatientContno']; ?></p>
          <p><strong>Address:</strong> <?php echo $row['PatientAdd']; ?></p>
          <p><strong>Gender:</strong> <?php echo $row['PatientGender']; ?></p>
          <p><strong>Age:</strong> <?php echo $row['PatientAge']; ?></p>
          <p><strong>Medical History:</strong> <?php echo $row['PatientMedhis']; ?></p>
          <p><strong>Registered On:</strong> <?php echo $row['CreationDate']; ?></p>
        </div>
        <?php } ?>
      </div>

      <!-- Medical History -->
      <div class="card p-6 relative">
        <div class="flex justify-between items-center mb-4">
          <h2 class="text-lg font-semibold text-blue-600">Medical History</h2>
          <button onclick="togglePopup()" class="bg-blue-600 hover:bg-blue-700 text-white text-sm px-4 py-2 rounded-md shadow">
            <i class="fa-solid fa-plus mr-1"></i> Add Medical History
          </button>
        </div>
        <div class="overflow-x-auto">
          <table class="w-full border text-sm">
            <thead class="bg-blue-100">
              <tr>
                <th class="p-2 border">#</th>
                <th class="p-2 border">Blood Pressure</th>
                <th class="p-2 border">Weight</th>
                <th class="p-2 border">Blood Sugar</th>
                <th class="p-2 border">Temperature</th>
                <th class="p-2 border">Prescription</th>
                <th class="p-2 border">Visit Date</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $ret = mysqli_query($con, "SELECT * FROM tblmedicalhistory WHERE PatientID='$vid'");
              $cnt = 1;
              while ($row = mysqli_fetch_array($ret)) {
              ?>
              <tr>
                <td class="p-2 border"><?php echo $cnt++; ?></td>
                <td class="p-2 border"><?php echo $row['BloodPressure']; ?></td>
                <td class="p-2 border"><?php echo $row['Weight']; ?></td>
                <td class="p-2 border"><?php echo $row['BloodSugar']; ?></td>
                <td class="p-2 border"><?php echo $row['Temperature']; ?></td>
                <td class="p-2 border"><?php echo $row['MedicalPres']; ?></td>
                <td class="p-2 border"><?php echo $row['CreationDate']; ?></td>
              </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>

      <!-- Popup Form -->
      <div id="popupForm" class="hidden fixed inset-0 flex items-center justify-center z-50 popup-overlay">
        <div class="popup-card bg-white p-6 rounded-xl shadow-xl w-full max-w-lg relative">
          <h3 class="text-lg font-semibold text-blue-600 mb-4">Add Medical History</h3>
          <form method="post">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <input name="bp" placeholder="Blood Pressure" class="border p-2 rounded" required>
              <input name="bs" placeholder="Blood Sugar" class="border p-2 rounded" required>
              <input name="weight" placeholder="Weight" class="border p-2 rounded" required>
              <input name="temp" placeholder="Body Temperature" class="border p-2 rounded" required>
            </div>
            <textarea name="pres" placeholder="Medical Prescription" rows="4" class="border p-2 rounded w-full mt-3" required></textarea>
            <div class="flex justify-end gap-3 mt-4">
              <button type="button" onclick="togglePopup()" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded">Cancel</button>
              <button type="submit" name="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">Submit</button>
            </div>
          </form>
        </div>
      </div>

    </main>

    <!-- Footer -->
    <footer class="bg-white text-center text-gray-500 text-sm py-4 border-t border-gray-100">
      <p>© <?php echo date('Y'); ?> Hospital Management System | Designed with 💙 for Doctors</p>
    </footer>

  </div>

  <script>
    const profileBtn = document.getElementById('profileBtn');
    const profileMenu = document.getElementById('profileMenu');
    profileBtn.addEventListener('click', () => profileMenu.classList.toggle('hidden'));
    document.addEventListener('click', e => {
      if (!profileBtn.contains(e.target) && !profileMenu.contains(e.target)) profileMenu.classList.add('hidden');
    });
    function toggleMenu(id) { document.getElementById(id).classList.toggle('hidden'); }
    function togglePopup() { document.getElementById('popupForm').classList.toggle('hidden'); }
  </script>

</body>
</html>
<?php } ?>

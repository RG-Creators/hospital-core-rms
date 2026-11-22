<?php
session_start();
error_reporting(0);
include('include/config.php');

if(strlen($_SESSION['id'])==0) {
    header('location:logout.php');
    exit();
} else {
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Doctor | Manage Patients</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    body { font-family: 'Poppins', sans-serif; background: #f8fafc; color: #1e293b; }
    .sidebar { background: linear-gradient(180deg, #2563eb, #1d4ed8); color: white; transition: all 0.3s ease; }
    .sidebar.hidden { transform: translateX(-100%); }
    .nav-link { transition: all 0.2s ease; border-radius: 8px; }
    .nav-link:hover { background: rgba(255,255,255,0.15); }
    table { border-collapse: separate; border-spacing: 0 8px; }
    th { background: #eff6ff; text-transform: uppercase; font-size: 12px; letter-spacing: 0.05em; }
    tr { background: white; border-radius: 10px; transition: all 0.2s ease; }
    tr:hover { background: #f0f9ff; }
    td, th { padding: 12px 16px; vertical-align: middle; }
    .fade-in { animation: fadeIn 0.6s ease-in-out; }
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(15px); }
      to { opacity: 1; transform: translateY(0); }
    }
  </style>
</head>
<body class="flex min-h-screen overflow-x-hidden">

  <!-- Sidebar -->
  <aside id="sidebar" class="sidebar w-64 fixed top-0 left-0 bottom-0 z-30 flex flex-col">
    <div class="p-6 text-center border-b border-white/20">
      <img src="https://cdn-icons-png.flaticon.com/512/3774/3774299.png" alt="Doctor Icon" class="w-12 h-12 mx-auto mb-2">
      <h2 class="text-lg font-semibold tracking-wide">HMS Doctor</h2>
    </div>
    <nav class="flex-1 overflow-y-auto mt-4 px-2 space-y-1">
      <a href="dashboard.php" class="nav-link flex items-center px-4 py-2 text-sm"><i class="fa-solid fa-house mr-3 text-white"></i>Dashboard</a>
      <a href="appointment-history.php" class="nav-link flex items-center px-4 py-2 text-sm"><i class="fa-solid fa-clock-rotate-left mr-3 text-white"></i>Appointment History</a>
      <button onclick="toggleMenu('patientsMenu')" class="w-full text-left flex items-center px-4 py-2 nav-link text-sm focus:outline-none">
        <i class="fa-solid fa-user-group mr-3 text-white"></i>Patients<i class="fa-solid fa-chevron-down ml-auto text-xs"></i>
      </button>
      <ul id="patientsMenu" class="ml-8 hidden space-y-1">
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

    <!-- Page Body -->
    <main class="flex-1 p-8 bg-gradient-to-br from-blue-50 via-white to-blue-100 fade-in">
      <div class="bg-white shadow-lg rounded-2xl p-8 max-w-6xl mx-auto">
        <h2 class="text-2xl font-semibold text-blue-700 mb-6 text-center">Search and Manage Patients</h2>
        <form role="form" method="post" name="search" class="flex flex-col sm:flex-row items-center justify-center gap-3 mb-6">
          <input type="text" name="searchdata" id="searchdata" class="w-full sm:w-96 border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Search by name or mobile number..." required>
          <button type="submit" name="search" id="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg shadow-md transition-all">
            <i class="fa-solid fa-magnifying-glass mr-2"></i>Search
          </button>
        </form>

        <?php
        if(isset($_POST['search'])) { 
          $sdata=$_POST['searchdata'];
        ?>
        <h4 class="text-center text-gray-700 font-medium mb-4">Result against "<span class="text-blue-600"><?php echo htmlentities($sdata);?></span>" keyword</h4>

        <div class="overflow-x-auto">
          <table class="min-w-full text-sm text-left">
            <thead>
              <tr>
                <th>#</th>
                <th>Patient Name</th>
                <th>Contact Number</th>
                <th>Gender</th>
                <th>Created On</th>
                <th>Updated On</th>
                <th class="text-center">Action</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $sql=mysqli_query($con,"SELECT * FROM tblpatient WHERE PatientName LIKE '%$sdata%' OR PatientContno LIKE '%$sdata%'");
              $num=mysqli_num_rows($sql);
              if($num>0){
                $cnt=1;
                while($row=mysqli_fetch_array($sql)) {
              ?>
              <tr class="rounded-lg shadow-sm">
                <td><?php echo $cnt;?>.</td>
                <td class="font-medium text-gray-700"><?php echo htmlentities($row['PatientName']);?></td>
                <td><?php echo htmlentities($row['PatientContno']);?></td>
                <td><?php echo htmlentities($row['PatientGender']);?></td>
                <td><?php echo htmlentities($row['CreationDate']);?></td>
                <td><?php echo htmlentities($row['UpdationDate']);?></td>
                <td class="text-center">
                  <a href="edit-patient.php?editid=<?php echo $row['ID'];?>" target="_blank" class="text-blue-600 hover:text-blue-800 font-medium">Edit</a> |
                  <a href="view-patient.php?viewid=<?php echo $row['ID'];?>" target="_blank" class="text-orange-500 hover:text-orange-700 font-medium">View</a>
                </td>
              </tr>
              <?php $cnt++; } } else { ?>
                <tr><td colspan="7" class="text-center text-gray-500 py-4">No record found against this search.</td></tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
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
    toggleSidebar?.addEventListener('click', () => sidebar.classList.toggle('hidden'));
    profileBtn?.addEventListener('click', () => profileMenu.classList.toggle('hidden'));
    document.addEventListener('click', (e) => {
      if (!profileBtn.contains(e.target) && !profileMenu.contains(e.target)) {
        profileMenu.classList.add('hidden');
      }
    });
    function toggleMenu(id) { document.getElementById(id).classList.toggle('hidden'); }
  </script>

</body>
</html>
<?php } ?>

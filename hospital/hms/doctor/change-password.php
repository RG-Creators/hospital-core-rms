<?php
session_start();
error_reporting(0);
include('include/config.php');

if (strlen($_SESSION['id']) == 0) {
    header('location:logout.php');
    exit();
} else {
    date_default_timezone_set('Asia/Kolkata');
    $currentTime = date('d-m-Y h:i:s A', time());
    $message = "";

    if (isset($_POST['submit'])) {
        $cpass = md5($_POST['cpass']);
        $did = $_SESSION['id'];
        $sql = mysqli_query($con, "SELECT password FROM doctors WHERE password='$cpass' && id='$did'");
        $num = mysqli_fetch_array($sql);
        if ($num > 0) {
            $npass = md5($_POST['npass']);
            mysqli_query($con, "UPDATE doctors SET password='$npass', updationDate='$currentTime' WHERE id='$did'");
            $_SESSION['msg1'] = "Password Changed Successfully !!";
        } else {
            $_SESSION['msg1'] = "Old Password not match !!";
        }
        header("Location: change-password.php");
        exit();
    }

    $message = isset($_SESSION['msg1']) ? $_SESSION['msg1'] : "";
    unset($_SESSION['msg1']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Doctor | Change Password</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    body { font-family: 'Poppins', sans-serif; background: #f8fafc; color: #1e293b; }
    .sidebar { background: linear-gradient(180deg, #2563eb, #1d4ed8); color: white; transition: all 0.3s ease; }
    .sidebar.hidden { transform: translateX(-100%); }
    .nav-link { transition: all 0.2s ease; border-radius: 8px; }
    .nav-link:hover { background: rgba(255,255,255,0.15); }
    .card { background: white; border-radius: 16px; box-shadow: 0 6px 20px rgba(0,0,0,0.08); }
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
        <h1 class="text-xl font-semibold text-blue-600">Change Password</h1>
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
    <main class="flex-1 flex items-center justify-center bg-gradient-to-br from-blue-50 via-white to-blue-100 p-8 fade-in">
      <div class="grid md:grid-cols-2 gap-8 items-center w-full max-w-4xl bg-white rounded-2xl shadow-lg p-8 hover:shadow-xl transition-all duration-300">

        <!-- Illustration -->
        <div class="flex flex-col items-center text-center px-4">
          <img src="https://cdn-icons-png.flaticon.com/512/2592/2592317.png" 
               alt="Secure Lock" 
               class="w-52 mx-auto mb-4 drop-shadow-md transition-transform duration-300 hover:scale-105">
          <h2 class="text-2xl font-semibold text-blue-600 mb-1">Secure Your Account</h2>
          <p class="text-gray-500 text-sm leading-relaxed">Keep your account protected by updating your password regularly. Stronger password, safer profile.</p>
        </div>

        <!-- Form Section -->
        <div class="px-4">
          <h3 class="text-xl font-semibold text-blue-700 mb-4 text-center">Change Password</h3>
          <?php if ($message) { ?>
            <div class="text-center mb-4 text-sm font-medium <?php echo ($message == 'Password Changed Successfully !!') ? 'text-green-600' : 'text-red-600'; ?>">
              <?php echo htmlentities($message); ?>
            </div>
          <?php } ?>
          <form name="chngpwd" method="post" onSubmit="return valid();" class="space-y-5">

            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">Current Password</label>
              <input type="password" name="cpass" 
                     class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none 
                            focus:ring-2 focus:ring-blue-500 focus:border-blue-400 transition-all" 
                     placeholder="Enter current password" required>
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">New Password</label>
              <input type="password" name="npass" 
                     class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none 
                            focus:ring-2 focus:ring-blue-500 focus:border-blue-400 transition-all" 
                     placeholder="Enter new password" required>
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
              <input type="password" name="cfpass" 
                     class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none 
                            focus:ring-2 focus:ring-blue-500 focus:border-blue-400 transition-all" 
                     placeholder="Re-enter new password" required>
            </div>

            <div class="flex justify-center pt-2">
              <button type="submit" name="submit" 
                      class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg 
                             font-medium shadow-md hover:shadow-lg transition-all duration-200">
                <i class="fa-solid fa-lock mr-2"></i>Update Password
              </button>
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

    function valid() {
      const f = document.chngpwd;
      if(f.cpass.value==""){alert("Current Password field is Empty !!");return false;}
      if(f.npass.value==""){alert("New Password field is Empty !!");return false;}
      if(f.cfpass.value==""){alert("Confirm Password field is Empty !!");return false;}
      if(f.npass.value!=f.cfpass.value){alert("Passwords do not match !!");return false;}
      return true;
    }
  </script>
</body>
</html>
<?php } ?>

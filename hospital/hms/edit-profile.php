<?php
session_start();
include('include/config.php');
include('include/checklogin.php');
check_login();

if (isset($_POST['submit'])) {
    $fname = $_POST['fname'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $gender = $_POST['gender'];

    $sql = mysqli_query($con, "UPDATE users SET fullName='$fname', address='$address', city='$city', gender='$gender' WHERE id='" . $_SESSION['id'] . "'");
    if ($sql) {
        $msg = "Your profile has been updated successfully!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit Profile | HMS</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Fonts & Icons -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
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

    /* Sidebar */
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

    .sidebar a:hover,
    .sidebar a.active {
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
      font-size: 22px;
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
      width: 44px;
      height: 44px;
      border-radius: 50%;
      border: 2px solid #2563eb;
      object-fit: cover;
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

    .card {
      background: #ffffff;
      border-radius: 18px;
      box-shadow: 0 6px 25px rgba(0,0,0,0.05);
      transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .card:hover {
      transform: translateY(-2px);
      box-shadow: 0 10px 28px rgba(0,0,0,0.08);
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
      <li><a href="edit-profile.php" class="active"><i class="fa-solid fa-user"></i> Edit Profile</a></li>
    </ul>
  </aside>

  <!-- Main Content -->
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

    <main class="pt-8 px-10 pb-24 bg-gray-50 min-h-screen">
      <div class="max-w-[1400px] mx-auto">

        <?php if (!empty($msg)): ?>
          <div class="bg-green-100 border border-green-300 text-green-800 px-5 py-4 rounded-lg mb-6 flex items-center gap-3 text-lg">
            <i class="fa-solid fa-circle-check text-green-600"></i>
            <?= htmlentities($msg); ?>
          </div>
        <?php endif; ?>

        <?php 
        $sql = mysqli_query($con, "SELECT * FROM users WHERE id='" . $_SESSION['id'] . "'");
        while ($data = mysqli_fetch_array($sql)) {
        ?>

        <!-- Profile + Form Section -->
        <section class="grid grid-cols-1 lg:grid-cols-3 gap-10 mb-12">

          <!-- Profile Summary -->
          <div class="card w-full flex flex-col items-center justify-center text-center bg-white shadow-lg rounded-2xl p-12 border border-gray-100">
            <img src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png"
                 alt="User" class="w-36 h-36 rounded-full bg-blue-50 p-3 mb-6 shadow-md">
            <h2 class="text-3xl font-semibold text-blue-700"><?= htmlentities($data['fullName']); ?></h2>
            <p class="text-gray-600 text-lg mb-3"><?= htmlentities($data['email']); ?></p>
            <div class="text-gray-400 text-base space-y-1 mt-2">
              <p>Registered: <?= htmlentities($data['regDate']); ?></p>
              <?php if ($data['updationDate']) { ?>
                <!-- <p>Updated: <?= htmlentities($data['updationDate']); ?></p> -->
              <?php } ?>
            </div>
          </div>

          <!-- Edit Profile Form -->
          <div class="card lg:col-span-2 bg-white shadow-lg rounded-2xl border border-gray-100 p-14">
            <h2 class="text-3xl font-bold text-blue-700 mb-10 flex items-center gap-3">
              <i class="fa-solid fa-user-pen"></i> Edit Profile
            </h2>

            <form method="post" class="grid grid-cols-1 md:grid-cols-2 gap-10 text-lg">

              <div>
                <label class="block text-gray-800 font-semibold mb-2">Full Name</label>
                <input type="text" name="fname" value="<?= htmlentities($data['fullName']); ?>"
                       class="w-full border border-gray-300 rounded-xl px-6 py-4 text-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">
              </div>

              <div>
                <label class="block text-gray-800 font-semibold mb-2">City</label>
                <input type="text" name="city" value="<?= htmlentities($data['city']); ?>" required
                       class="w-full border border-gray-300 rounded-xl px-6 py-4 text-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">
              </div>

              <div>
                <label class="block text-gray-800 font-semibold mb-2">Gender</label>
                <select name="gender"
                        class="w-full border border-gray-300 rounded-xl px-6 py-4 text-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">
                  <option value="<?= htmlentities($data['gender']); ?>"><?= htmlentities($data['gender']); ?></option>
                  <option value="Male">Male</option>
                  <option value="Female">Female</option>
                  <option value="Other">Other</option>
                </select>
              </div>

              <div>
                <label class="block text-gray-800 font-semibold mb-2">Email</label>
                <input type="email" value="<?= htmlentities($data['email']); ?>" readonly
                       class="w-full border border-gray-300 rounded-xl px-6 py-4 text-lg bg-gray-100 text-gray-600 cursor-not-allowed">
                <a href="change-emaild.php" class="text-blue-600 hover:underline mt-2 inline-block font-medium text-base">
                  <i class="fa-solid fa-envelope"></i> Change Email
                </a>
              </div>

              <div class="md:col-span-2">
                <label class="block text-gray-800 font-semibold mb-2">Address</label>
                <textarea name="address" rows="3"
                          class="w-full border border-gray-300 rounded-xl px-6 py-4 text-lg focus:ring-2 focus:ring-blue-500 focus:outline-none"><?= htmlentities($data['address']); ?></textarea>
              </div>

              <div class="md:col-span-2 text-right mt-4">
                <button type="submit" name="submit"
                        class="bg-blue-600 text-white px-10 py-4 rounded-lg text-lg font-semibold shadow-md hover:bg-blue-700 transition-all">
                  <i class="fa-solid fa-rotate"></i> Update Profile
                </button>
              </div>

            </form>
          </div>

        </section>

        <?php } ?>
      </div>
    </main>

    <footer>
      &copy; <?= date('Y'); ?> Hospital Management System. All Rights Reserved.
    </footer>
  </div>

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

<?php
session_start();
include('include/config.php');
include('include/checklogin.php');
check_login();

$vid = $_GET['viewid'] ?? null;
if (!$vid) {
  echo "<script>alert('Invalid Patient ID'); window.location.href='manage-patient.php';</script>";
  exit;
}

// Fetch Patient Info
$patientQuery = mysqli_query($con, "SELECT * FROM tblpatient WHERE ID='$vid'");
$patient = mysqli_fetch_array($patientQuery);

// Fetch Medical History
$historyQuery = mysqli_query($con, "SELECT * FROM tblmedicalhistory WHERE PatientID='$vid'");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Patient Medical History | HMS</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Fonts & Tailwind -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500&display=swap" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

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

    @media print {
      body * {
        visibility: hidden;
      }
      #printable, #printable * {
        visibility: visible;
      }
      #printable {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
      }
      #pdfButton {
        display: none !important;
      }
    }
  </style>
</head>

<body>
  <!-- Sidebar -->
  <aside class="sidebar">
    <h2>HMS Panel</h2>
    <a href="dashboard.php"><i class="fa-solid fa-house"></i> Dashboard</a>
    <a href="book-appointment.php"><i class="fa-solid fa-calendar-plus"></i> Book Appointment</a>
    <a href="appointment-history.php"><i class="fa-solid fa-clock-rotate-left"></i> Appointment History</a>
    <a href="view_medhistory.php" class="active"><i class="fa-solid fa-file-medical"></i> Medical History</a>
    <a href="edit-profile.php"><i class="fa-solid fa-user"></i> Edit Profile</a>
    <a href="change-password.php"><i class="fa-solid fa-lock"></i> Change Password</a>
    <a href="logout.php"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
  </aside>

  <!-- Main Content -->
  <div class="main-content">
    <header>
      <h1>Hospital Management System</h1>
      <div class="user-dropdown flex items-center gap-2">
        <img src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png" alt="User">
        <span>
          <?php
          $query = mysqli_query($con, "SELECT fullName FROM users WHERE id='" . $_SESSION['id'] . "'");
          $row = mysqli_fetch_array($query);
          echo htmlspecialchars($row['fullName']);
          ?>
        </span>
      </div>
    </header>

    <main class="flex justify-center items-start flex-1 overflow-y-auto px-5 py-8">
      <div class="bg-white rounded-xl shadow-md border border-gray-100 w-full max-w-6xl p-8" id="printable">

        <!-- Title Bar -->
        <div class="flex justify-between items-center border-b pb-4 mb-6">
          <h2 class="text-xl font-semibold text-blue-700 flex items-center gap-2">
            <i class="fa-solid fa-file-medical"></i> Patient Medical History
          </h2>
          <button id="pdfButton" onclick="window.print()" 
            class="bg-blue-600 hover:bg-blue-700 text-white text-sm px-4 py-2 rounded-md shadow-sm">
            <i class="fa-solid fa-file-pdf mr-1"></i> Save as PDF
          </button>
        </div>

        <!-- Patient Info -->
        <?php if ($patient) { ?>
        <div class="bg-blue-50 border border-blue-100 rounded-lg p-5 mb-6">
          <h3 class="text-blue-800 font-medium mb-3">Patient Information</h3>
          <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 text-sm text-gray-700">
            <div><span class="font-medium">Name:</span> <?= htmlentities($patient['PatientName']); ?></div>
            <div><span class="font-medium">Email:</span> <?= htmlentities($patient['PatientEmail']); ?></div>
            <div><span class="font-medium">Phone:</span> <?= htmlentities($patient['PatientContno']); ?></div>
            <div><span class="font-medium">Gender:</span> <?= htmlentities($patient['PatientGender']); ?></div>
            <div><span class="font-medium">Age:</span> <?= htmlentities($patient['PatientAge']); ?></div>
            <div><span class="font-medium">Address:</span> <?= htmlentities($patient['PatientAdd']); ?></div>
            <div class="sm:col-span-2"><span class="font-medium">Medical History:</span> <?= htmlentities($patient['PatientMedhis']); ?></div>
            <div><span class="font-medium">Registered On:</span> <?= htmlentities($patient['CreationDate']); ?></div>
          </div>
        </div>
        <?php } ?>

        <!-- Medical History Table -->
        <div>
          <h3 class="text-blue-800 font-medium mb-3">Visit Records</h3>
          <div class="overflow-x-auto border rounded-lg">
            <table class="min-w-full text-sm border-collapse">
              <thead class="bg-blue-600 text-white">
                <tr>
                  <th class="px-4 py-3 text-left">#</th>
                  <th class="px-4 py-3 text-left">Blood Pressure</th>
                  <th class="px-4 py-3 text-left">Weight</th>
                  <th class="px-4 py-3 text-left">Blood Sugar</th>
                  <th class="px-4 py-3 text-left">Temperature</th>
                  <th class="px-4 py-3 text-left">Prescription</th>
                  <th class="px-4 py-3 text-left">Visit Date</th>
                </tr>
              </thead>
              <tbody class="divide-y divide-gray-100">
                <?php
                $cnt = 1;
                if (mysqli_num_rows($historyQuery) > 0) {
                  while ($row = mysqli_fetch_array($historyQuery)) {
                ?>
                <tr class="hover:bg-blue-50 transition">
                  <td class="px-4 py-3 font-medium"><?= $cnt++; ?></td>
                  <td class="px-4 py-3"><?= htmlentities($row['BloodPressure']); ?></td>
                  <td class="px-4 py-3"><?= htmlentities($row['Weight']); ?></td>
                  <td class="px-4 py-3"><?= htmlentities($row['BloodSugar']); ?></td>
                  <td class="px-4 py-3"><?= htmlentities($row['Temperature']); ?></td>
                  <td class="px-4 py-3"><?= htmlentities($row['MedicalPres']); ?></td>
                  <td class="px-4 py-3 text-gray-500"><?= htmlentities($row['CreationDate']); ?></td>
                </tr>
                <?php } } else { ?>
                <tr><td colspan="7" class="text-center text-gray-500 py-6">No medical records found.</td></tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </div>

      </div>
    </main>

    <footer>
      &copy; <?= date('Y'); ?> Hospital Management System — All Rights Reserved.
    </footer>
  </div>
</body>
</html>

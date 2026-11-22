<?php
session_start();
error_reporting(0);
include("include/config.php");
$response = '';

if (isset($_POST['submit'])) {
    $contactno = $_POST['contactno'];
    $email = $_POST['email'];
    $query = mysqli_query($con, "SELECT id FROM doctors WHERE contactno='$contactno' AND docEmail='$email'");
    $row = mysqli_num_rows($query);

    if ($row > 0) {
        $_SESSION['cnumber'] = $contactno;
        $_SESSION['email'] = $email;
        $response = 'success';
    } else {
        $response = 'error';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Doctor Password Recovery | HMS</title>

<!-- Tailwind CSS -->
<script src="https://cdn.tailwindcss.com"></script>

<!-- Google Font -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<!-- Remix Icons -->
<link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet">

<style>
body {
  font-family: 'Poppins', sans-serif;
  background: linear-gradient(135deg, #5eead4, #38bdf8, #60a5fa);
}
.glass {
  background: rgba(255, 255, 255, 0.25);
  backdrop-filter: blur(14px);
  border: 1px solid rgba(255, 255, 255, 0.3);
}
.fade { animation: fadeIn 0.6s ease-in-out; }
@keyframes fadeIn { from {opacity:0; transform:translateY(10px);} to {opacity:1; transform:translateY(0);} }

.toast {
  position: fixed;
  bottom: 30px;
  left: 50%;
  transform: translateX(-50%) scale(0.9);
  background: #2563eb;
  color: white;
  padding: 12px 22px;
  border-radius: 8px;
  font-weight: 500;
  font-size: 14px;
  box-shadow: 0 3px 15px rgba(0,0,0,0.25);
  opacity: 0;
  transition: all 0.4s ease;
  z-index: 9999;
}
.toast.show {
  opacity: 1;
  transform: translateX(-50%) scale(1);
}
.toast.error { background: #dc2626; }
</style>

<script>
function showToast(message, isError=false, redirectURL="") {
  const toast = document.getElementById("toast");
  toast.textContent = message;
  toast.classList.toggle("error", isError);
  toast.classList.add("show");

  setTimeout(() => {
    toast.classList.remove("show", "error");
    if (redirectURL && !isError) window.location.href = redirectURL;
  }, 1300);
}
</script>
</head>

<body class="min-h-screen flex items-center justify-center p-4 fade">

<!-- Toast -->
<div id="toast" class="toast"></div>

<div class="w-full max-w-4xl flex flex-col md:flex-row rounded-2xl overflow-hidden glass shadow-2xl">

  <!-- Left Side (Illustration + Text) -->
  <div class="hidden md:flex w-1/2 bg-gradient-to-br from-teal-500 to-sky-500 text-white flex-col justify-center p-8 relative overflow-hidden">
    <h2 class="text-3xl font-bold mb-3 leading-snug z-10">Doctor Password Recovery</h2>
    <p class="text-white/90 text-sm leading-relaxed z-10">
      Forgot your password? Enter your contact number and email to verify your account and reset it quickly.
    </p>
    <div class="mt-6 mx-auto bg-white/95 p-4 rounded-2xl shadow-xl backdrop-blur-sm z-10">
      <img src="https://cdn-icons-png.flaticon.com/512/14670/14670453.png" alt="Password Recovery" class="w-40 opacity-100">
    </div>
    <div class="absolute inset-0 bg-black/10"></div>
  </div>

  <!-- Right Side (Form) -->
  <div class="w-full md:w-1/2 bg-white/95 p-6 sm:p-8 text-gray-800">
    <div class="text-center mb-4">
      <a href="../../index.php" class="text-2xl font-bold text-sky-600">HMS</a>
      <p class="text-gray-600 text-sm">Doctor Password Recovery</p>
    </div>

    <form method="post" class="space-y-4">
      <input type="text" name="contactno" placeholder="Registered Contact Number" required class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-sky-300">
      <input type="email" name="email" placeholder="Registered Email" required class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-sky-300">

      <button type="submit" name="submit" id="resetBtn" class="w-full bg-gradient-to-r from-sky-500 to-teal-400 text-white py-2 rounded-lg font-semibold hover:opacity-90 transition-all">
        Reset Password <i class="ri-lock-unlock-line ml-1"></i>
      </button>

      <div class="text-center text-xs mt-2">
        <a href="index.php" class="text-sky-600 hover:underline">Back to Login</a>
      </div>
    </form>

    <p class="text-center text-gray-600 text-xs mt-4">
      © <span class="current-year"></span> <b>HMS</b> — All rights reserved.
    </p>
  </div>

</div>

<?php if ($response === 'success') { ?>
<script>
document.addEventListener("DOMContentLoaded", () => {
  const btn = document.getElementById("resetBtn");
  btn.disabled = true;
  btn.innerHTML = "Redirecting...";
  showToast("Verification successful! Redirecting...", false, "reset-password.php");
});
</script>
<?php } elseif ($response === 'error') { ?>
<script>
document.addEventListener("DOMContentLoaded", () => {
  showToast("Invalid details. Please try again.", true);
});
</script>
<?php } ?>

</body>
</html>

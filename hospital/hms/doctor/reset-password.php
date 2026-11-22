<?php
session_start();
include("include/config.php");
$response = '';

if (isset($_POST['change'])) {
    $cno = $_SESSION['cnumber'];
    $email = $_SESSION['email'];
    $newpassword = md5($_POST['password']);
    $query = mysqli_query($con, "UPDATE doctors SET password='$newpassword' WHERE contactno='$cno' AND docEmail='$email'");
    if ($query) {
        $response = 'success';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Doctor Password Reset | HMS</title>

<!-- Tailwind CSS -->
<script src="https://cdn.tailwindcss.com"></script>

<!-- Google Font -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<!-- Remix Icons -->
<link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet">

<style>
body {
  font-family: 'Poppins', sans-serif;
  background: linear-gradient(135deg, #38bdf8, #5eead4);
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

function validatePasswords(e) {
  const pass = document.getElementById("password").value;
  const confirm = document.getElementById("confirm_password").value;
  if (pass !== confirm) {
    e.preventDefault();
    showToast("Passwords do not match!", true);
    return false;
  }
  return true;
}
</script>
</head>

<body class="min-h-screen flex items-center justify-center p-4 fade">

<!-- Toast -->
<div id="toast" class="toast"></div>

<div class="w-full max-w-4xl flex flex-col md:flex-row rounded-2xl overflow-hidden glass shadow-2xl">

  <!-- Left Side (Image + Text) -->
  <div class="hidden md:flex w-1/2 bg-gradient-to-br from-sky-500 to-teal-500 text-white flex-col justify-center p-8 relative overflow-hidden">
    <h2 class="text-3xl font-bold mb-3 leading-snug z-10">Doctor Password Reset</h2>
    <p class="text-white/90 text-sm leading-relaxed z-10">
      Set a strong new password to secure your HMS doctor account.
    </p>
    <div class="mt-6 mx-auto bg-white/95 p-4 rounded-2xl shadow-xl z-10">
      <img src="https://cdn-icons-png.flaticon.com/512/14670/14670453.png" alt="Password Reset" class="w-40 opacity-100">
    </div>
    <div class="absolute inset-0 bg-black/10"></div>
  </div>

  <!-- Right Side (Form) -->
  <div class="w-full md:w-1/2 bg-white/95 p-6 sm:p-8 text-gray-800">
    <div class="text-center mb-4">
      <a href="../../index.php" class="text-2xl font-bold text-sky-600">HMS</a>
      <p class="text-gray-600 text-sm">Doctor Password Reset</p>
    </div>

    <form method="post" onsubmit="return validatePasswords(event)" class="space-y-4">
      <input type="password" id="password" name="password" placeholder="New Password" required class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-sky-300">
      <input type="password" id="confirm_password" name="password_again" placeholder="Confirm Password" required class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-sky-300">

      <button type="submit" name="change" id="resetBtn" class="w-full bg-gradient-to-r from-sky-500 to-teal-400 text-white py-2 rounded-lg font-semibold hover:opacity-90 transition-all">
        Update Password <i class="ri-check-line ml-1"></i>
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
  showToast("Password updated successfully! Redirecting...", false, "index.php");
});
</script>
<?php } ?>

</body>
</html>

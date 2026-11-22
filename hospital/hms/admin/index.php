<?php
session_start();
include("include/config.php");
$response = '';

if (isset(<?php
session_start();
include("include/config.php");
error_reporting(0);

$response = '';

if (isset($_POST['submit'])) {
    $uname = $_POST['username'];
    $upassword = $_POST['password'];

    $ret = mysqli_query($con, "SELECT * FROM admin WHERE username='$uname' AND password='$upassword'");
    $num = mysqli_fetch_array($ret);
    if ($num > 0) {
        $_SESSION['login'] = $_POST['username'];
        $_SESSION['id'] = $num['id'];
        $response = 'success';
    } else {
        $_SESSION['errmsg'] = "Invalid username or password";
        $response = 'error';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Login | HMS</title>

<!-- Tailwind CSS -->
<script src="https://cdn.tailwindcss.com"></script>

<!-- Google Font -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<!-- Remix Icons -->
<link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet">

<style>
body {
  font-family: 'Poppins', sans-serif;
  background: linear-gradient(135deg, #0f172a, #1e3a8a, #2563eb);
  color: #1e293b;
}
.glass {
  background: rgba(255, 255, 255, 0.18);
  backdrop-filter: blur(14px);
  border: 1px solid rgba(255, 255, 255, 0.25);
}
.fade { animation: fadeIn 0.6s ease-in-out; }
@keyframes fadeIn { from {opacity:0; transform:translateY(10px);} to {opacity:1; transform:translateY(0);} }

.toast {
  position: fixed;
  bottom: 25px;
  right: 25px;
  background: #1e40af;
  color: white;
  padding: 14px 26px;
  border-radius: 10px;
  font-weight: 500;
  font-size: 15px;
  box-shadow: 0 5px 20px rgba(0,0,0,0.3);
  opacity: 0;
  transform: translateY(30px) scale(0.95);
  transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
  z-index: 9999;
}
.toast.show {
  opacity: 1;
  transform: translateY(0) scale(1);
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

  <!-- Left Side (Image + Intro) -->
  <div class="hidden md:flex w-1/2 bg-gradient-to-br from-indigo-700 to-blue-600 text-white flex-col justify-center p-8 relative">
    <h2 class="text-3xl font-bold mb-3 leading-snug z-10">Welcome Back, Admin</h2>
    <p class="text-white/90 text-sm leading-relaxed z-10">
      Manage hospital operations efficiently and securely from your dashboard.
    </p>
    <div class="mt-6 mx-auto bg-white/90 p-4 rounded-2xl shadow-xl z-10">
      <img src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png" alt="Admin Login" class="w-40 opacity-100">
    </div>
    <div class="absolute inset-0 bg-black/10"></div>
  </div>

  <!-- Right Side (Form) -->
  <div class="w-full md:w-1/2 bg-white/95 p-6 sm:p-8 text-gray-800">
    <div class="text-center mb-4">
      <h1 class="text-2xl font-bold text-indigo-700">HMS Admin Panel</h1>
      <p class="text-gray-600 text-sm">Secure Login Portal</p>
    </div>

    <form method="post" class="space-y-4">
      <input type="text" name="username" placeholder="Username" required class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-300">
      <input type="password" name="password" placeholder="Password" required class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-300">

      <button type="submit" name="submit" id="loginBtn" class="w-full bg-gradient-to-r from-indigo-600 to-blue-500 text-white py-2 rounded-lg font-semibold hover:opacity-90 transition-all">
        Login <i class="ri-login-circle-line ml-1"></i>
      </button>
    </form>

    <div class="text-center mt-3">
      <a href="../../index.php" class="text-indigo-600 text-sm hover:underline">← Back to Home Page</a>
    </div>

    <p class="text-center text-gray-600 text-xs mt-6">
      © <span class="current-year"></span> <b>HMS</b> — All rights reserved.
    </p>
  </div>

</div>

<?php if ($response === 'success') { ?>
<script>
document.addEventListener("DOMContentLoaded", () => {
  const btn = document.getElementById("loginBtn");
  btn.disabled = true;
  btn.innerHTML = "Redirecting...";
  showToast("Login successful! Redirecting to dashboard...", false, "dashboard.php");
});
</script>
<?php } elseif ($response === 'error') { ?>
<script>
document.addEventListener("DOMContentLoaded", () => {
  showToast("Invalid username or password. Try again.", true);
});
</script>
<?php } ?>

</body>
</html>
POST['submit'])) {
    $uname = trim(<?php
session_start();
include("include/config.php");
error_reporting(0);

$response = '';

if (isset($_POST['submit'])) {
    $uname = $_POST['username'];
    $upassword = $_POST['password'];

    $ret = mysqli_query($con, "SELECT * FROM admin WHERE username='$uname' AND password='$upassword'");
    $num = mysqli_fetch_array($ret);
    if ($num > 0) {
        $_SESSION['login'] = $_POST['username'];
        $_SESSION['id'] = $num['id'];
        $response = 'success';
    } else {
        $_SESSION['errmsg'] = "Invalid username or password";
        $response = 'error';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Login | HMS</title>

<!-- Tailwind CSS -->
<script src="https://cdn.tailwindcss.com"></script>

<!-- Google Font -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<!-- Remix Icons -->
<link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet">

<style>
body {
  font-family: 'Poppins', sans-serif;
  background: linear-gradient(135deg, #0f172a, #1e3a8a, #2563eb);
  color: #1e293b;
}
.glass {
  background: rgba(255, 255, 255, 0.18);
  backdrop-filter: blur(14px);
  border: 1px solid rgba(255, 255, 255, 0.25);
}
.fade { animation: fadeIn 0.6s ease-in-out; }
@keyframes fadeIn { from {opacity:0; transform:translateY(10px);} to {opacity:1; transform:translateY(0);} }

.toast {
  position: fixed;
  bottom: 25px;
  right: 25px;
  background: #1e40af;
  color: white;
  padding: 14px 26px;
  border-radius: 10px;
  font-weight: 500;
  font-size: 15px;
  box-shadow: 0 5px 20px rgba(0,0,0,0.3);
  opacity: 0;
  transform: translateY(30px) scale(0.95);
  transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
  z-index: 9999;
}
.toast.show {
  opacity: 1;
  transform: translateY(0) scale(1);
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

  <!-- Left Side (Image + Intro) -->
  <div class="hidden md:flex w-1/2 bg-gradient-to-br from-indigo-700 to-blue-600 text-white flex-col justify-center p-8 relative">
    <h2 class="text-3xl font-bold mb-3 leading-snug z-10">Welcome Back, Admin</h2>
    <p class="text-white/90 text-sm leading-relaxed z-10">
      Manage hospital operations efficiently and securely from your dashboard.
    </p>
    <div class="mt-6 mx-auto bg-white/90 p-4 rounded-2xl shadow-xl z-10">
      <img src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png" alt="Admin Login" class="w-40 opacity-100">
    </div>
    <div class="absolute inset-0 bg-black/10"></div>
  </div>

  <!-- Right Side (Form) -->
  <div class="w-full md:w-1/2 bg-white/95 p-6 sm:p-8 text-gray-800">
    <div class="text-center mb-4">
      <h1 class="text-2xl font-bold text-indigo-700">HMS Admin Panel</h1>
      <p class="text-gray-600 text-sm">Secure Login Portal</p>
    </div>

    <form method="post" class="space-y-4">
      <input type="text" name="username" placeholder="Username" required class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-300">
      <input type="password" name="password" placeholder="Password" required class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-300">

      <button type="submit" name="submit" id="loginBtn" class="w-full bg-gradient-to-r from-indigo-600 to-blue-500 text-white py-2 rounded-lg font-semibold hover:opacity-90 transition-all">
        Login <i class="ri-login-circle-line ml-1"></i>
      </button>
    </form>

    <div class="text-center mt-3">
      <a href="../../index.php" class="text-indigo-600 text-sm hover:underline">← Back to Home Page</a>
    </div>

    <p class="text-center text-gray-600 text-xs mt-6">
      © <span class="current-year"></span> <b>HMS</b> — All rights reserved.
    </p>
  </div>

</div>

<?php if ($response === 'success') { ?>
<script>
document.addEventListener("DOMContentLoaded", () => {
  const btn = document.getElementById("loginBtn");
  btn.disabled = true;
  btn.innerHTML = "Redirecting...";
  showToast("Login successful! Redirecting to dashboard...", false, "dashboard.php");
});
</script>
<?php } elseif ($response === 'error') { ?>
<script>
document.addEventListener("DOMContentLoaded", () => {
  showToast("Invalid username or password. Try again.", true);
});
</script>
<?php } ?>

</body>
</html>
POST['username'] ?? '');
    $raw_pass = <?php
session_start();
include("include/config.php");
error_reporting(0);

$response = '';

if (isset($_POST['submit'])) {
    $uname = $_POST['username'];
    $upassword = $_POST['password'];

    $ret = mysqli_query($con, "SELECT * FROM admin WHERE username='$uname' AND password='$upassword'");
    $num = mysqli_fetch_array($ret);
    if ($num > 0) {
        $_SESSION['login'] = $_POST['username'];
        $_SESSION['id'] = $num['id'];
        $response = 'success';
    } else {
        $_SESSION['errmsg'] = "Invalid username or password";
        $response = 'error';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Login | HMS</title>

<!-- Tailwind CSS -->
<script src="https://cdn.tailwindcss.com"></script>

<!-- Google Font -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<!-- Remix Icons -->
<link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet">

<style>
body {
  font-family: 'Poppins', sans-serif;
  background: linear-gradient(135deg, #0f172a, #1e3a8a, #2563eb);
  color: #1e293b;
}
.glass {
  background: rgba(255, 255, 255, 0.18);
  backdrop-filter: blur(14px);
  border: 1px solid rgba(255, 255, 255, 0.25);
}
.fade { animation: fadeIn 0.6s ease-in-out; }
@keyframes fadeIn { from {opacity:0; transform:translateY(10px);} to {opacity:1; transform:translateY(0);} }

.toast {
  position: fixed;
  bottom: 25px;
  right: 25px;
  background: #1e40af;
  color: white;
  padding: 14px 26px;
  border-radius: 10px;
  font-weight: 500;
  font-size: 15px;
  box-shadow: 0 5px 20px rgba(0,0,0,0.3);
  opacity: 0;
  transform: translateY(30px) scale(0.95);
  transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
  z-index: 9999;
}
.toast.show {
  opacity: 1;
  transform: translateY(0) scale(1);
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

  <!-- Left Side (Image + Intro) -->
  <div class="hidden md:flex w-1/2 bg-gradient-to-br from-indigo-700 to-blue-600 text-white flex-col justify-center p-8 relative">
    <h2 class="text-3xl font-bold mb-3 leading-snug z-10">Welcome Back, Admin</h2>
    <p class="text-white/90 text-sm leading-relaxed z-10">
      Manage hospital operations efficiently and securely from your dashboard.
    </p>
    <div class="mt-6 mx-auto bg-white/90 p-4 rounded-2xl shadow-xl z-10">
      <img src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png" alt="Admin Login" class="w-40 opacity-100">
    </div>
    <div class="absolute inset-0 bg-black/10"></div>
  </div>

  <!-- Right Side (Form) -->
  <div class="w-full md:w-1/2 bg-white/95 p-6 sm:p-8 text-gray-800">
    <div class="text-center mb-4">
      <h1 class="text-2xl font-bold text-indigo-700">HMS Admin Panel</h1>
      <p class="text-gray-600 text-sm">Secure Login Portal</p>
    </div>

    <form method="post" class="space-y-4">
      <input type="text" name="username" placeholder="Username" required class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-300">
      <input type="password" name="password" placeholder="Password" required class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-300">

      <button type="submit" name="submit" id="loginBtn" class="w-full bg-gradient-to-r from-indigo-600 to-blue-500 text-white py-2 rounded-lg font-semibold hover:opacity-90 transition-all">
        Login <i class="ri-login-circle-line ml-1"></i>
      </button>
    </form>

    <div class="text-center mt-3">
      <a href="../../index.php" class="text-indigo-600 text-sm hover:underline">← Back to Home Page</a>
    </div>

    <p class="text-center text-gray-600 text-xs mt-6">
      © <span class="current-year"></span> <b>HMS</b> — All rights reserved.
    </p>
  </div>

</div>

<?php if ($response === 'success') { ?>
<script>
document.addEventListener("DOMContentLoaded", () => {
  const btn = document.getElementById("loginBtn");
  btn.disabled = true;
  btn.innerHTML = "Redirecting...";
  showToast("Login successful! Redirecting to dashboard...", false, "dashboard.php");
});
</script>
<?php } elseif ($response === 'error') { ?>
<script>
document.addEventListener("DOMContentLoaded", () => {
  showToast("Invalid username or password. Try again.", true);
});
</script>
<?php } ?>

</body>
</html>
POST['password'] ?? '';

    $stmt = mysqli_prepare($con, "SELECT id, username, password FROM admin WHERE username = ?");
    mysqli_stmt_bind_param($stmt, "s", $uname);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    $admin = mysqli_fetch_assoc($res);
    mysqli_stmt_close($stmt);

    $authenticated = false;
    if ($admin) {
        if (password_verify($raw_pass, $admin['password'])) {
            $authenticated = true;
        } elseif ($admin['password'] === $raw_pass || md5($raw_pass) === $admin['password']) {
            $authenticated = true;
            $newHash = password_hash($raw_pass, PASSWORD_BCRYPT);
            $upd = mysqli_prepare($con, "UPDATE admin SET password = ? WHERE id = ?");
            mysqli_stmt_bind_param($upd, "si", $newHash, $admin['id']);
            mysqli_stmt_execute($upd);
            mysqli_stmt_close($upd);
        }
    }

    if ($authenticated) {
        <?php
session_start();
include("include/config.php");
error_reporting(0);

$response = '';

if (isset($_POST['submit'])) {
    $uname = $_POST['username'];
    $upassword = $_POST['password'];

    $ret = mysqli_query($con, "SELECT * FROM admin WHERE username='$uname' AND password='$upassword'");
    $num = mysqli_fetch_array($ret);
    if ($num > 0) {
        $_SESSION['login'] = $_POST['username'];
        $_SESSION['id'] = $num['id'];
        $response = 'success';
    } else {
        $_SESSION['errmsg'] = "Invalid username or password";
        $response = 'error';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Login | HMS</title>

<!-- Tailwind CSS -->
<script src="https://cdn.tailwindcss.com"></script>

<!-- Google Font -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<!-- Remix Icons -->
<link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet">

<style>
body {
  font-family: 'Poppins', sans-serif;
  background: linear-gradient(135deg, #0f172a, #1e3a8a, #2563eb);
  color: #1e293b;
}
.glass {
  background: rgba(255, 255, 255, 0.18);
  backdrop-filter: blur(14px);
  border: 1px solid rgba(255, 255, 255, 0.25);
}
.fade { animation: fadeIn 0.6s ease-in-out; }
@keyframes fadeIn { from {opacity:0; transform:translateY(10px);} to {opacity:1; transform:translateY(0);} }

.toast {
  position: fixed;
  bottom: 25px;
  right: 25px;
  background: #1e40af;
  color: white;
  padding: 14px 26px;
  border-radius: 10px;
  font-weight: 500;
  font-size: 15px;
  box-shadow: 0 5px 20px rgba(0,0,0,0.3);
  opacity: 0;
  transform: translateY(30px) scale(0.95);
  transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
  z-index: 9999;
}
.toast.show {
  opacity: 1;
  transform: translateY(0) scale(1);
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

  <!-- Left Side (Image + Intro) -->
  <div class="hidden md:flex w-1/2 bg-gradient-to-br from-indigo-700 to-blue-600 text-white flex-col justify-center p-8 relative">
    <h2 class="text-3xl font-bold mb-3 leading-snug z-10">Welcome Back, Admin</h2>
    <p class="text-white/90 text-sm leading-relaxed z-10">
      Manage hospital operations efficiently and securely from your dashboard.
    </p>
    <div class="mt-6 mx-auto bg-white/90 p-4 rounded-2xl shadow-xl z-10">
      <img src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png" alt="Admin Login" class="w-40 opacity-100">
    </div>
    <div class="absolute inset-0 bg-black/10"></div>
  </div>

  <!-- Right Side (Form) -->
  <div class="w-full md:w-1/2 bg-white/95 p-6 sm:p-8 text-gray-800">
    <div class="text-center mb-4">
      <h1 class="text-2xl font-bold text-indigo-700">HMS Admin Panel</h1>
      <p class="text-gray-600 text-sm">Secure Login Portal</p>
    </div>

    <form method="post" class="space-y-4">
      <input type="text" name="username" placeholder="Username" required class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-300">
      <input type="password" name="password" placeholder="Password" required class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-300">

      <button type="submit" name="submit" id="loginBtn" class="w-full bg-gradient-to-r from-indigo-600 to-blue-500 text-white py-2 rounded-lg font-semibold hover:opacity-90 transition-all">
        Login <i class="ri-login-circle-line ml-1"></i>
      </button>
    </form>

    <div class="text-center mt-3">
      <a href="../../index.php" class="text-indigo-600 text-sm hover:underline">← Back to Home Page</a>
    </div>

    <p class="text-center text-gray-600 text-xs mt-6">
      © <span class="current-year"></span> <b>HMS</b> — All rights reserved.
    </p>
  </div>

</div>

<?php if ($response === 'success') { ?>
<script>
document.addEventListener("DOMContentLoaded", () => {
  const btn = document.getElementById("loginBtn");
  btn.disabled = true;
  btn.innerHTML = "Redirecting...";
  showToast("Login successful! Redirecting to dashboard...", false, "dashboard.php");
});
</script>
<?php } elseif ($response === 'error') { ?>
<script>
document.addEventListener("DOMContentLoaded", () => {
  showToast("Invalid username or password. Try again.", true);
});
</script>
<?php } ?>

</body>
</html>
SESSION['login'] = $uname;
        <?php
session_start();
include("include/config.php");
error_reporting(0);

$response = '';

if (isset($_POST['submit'])) {
    $uname = $_POST['username'];
    $upassword = $_POST['password'];

    $ret = mysqli_query($con, "SELECT * FROM admin WHERE username='$uname' AND password='$upassword'");
    $num = mysqli_fetch_array($ret);
    if ($num > 0) {
        $_SESSION['login'] = $_POST['username'];
        $_SESSION['id'] = $num['id'];
        $response = 'success';
    } else {
        $_SESSION['errmsg'] = "Invalid username or password";
        $response = 'error';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Login | HMS</title>

<!-- Tailwind CSS -->
<script src="https://cdn.tailwindcss.com"></script>

<!-- Google Font -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<!-- Remix Icons -->
<link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet">

<style>
body {
  font-family: 'Poppins', sans-serif;
  background: linear-gradient(135deg, #0f172a, #1e3a8a, #2563eb);
  color: #1e293b;
}
.glass {
  background: rgba(255, 255, 255, 0.18);
  backdrop-filter: blur(14px);
  border: 1px solid rgba(255, 255, 255, 0.25);
}
.fade { animation: fadeIn 0.6s ease-in-out; }
@keyframes fadeIn { from {opacity:0; transform:translateY(10px);} to {opacity:1; transform:translateY(0);} }

.toast {
  position: fixed;
  bottom: 25px;
  right: 25px;
  background: #1e40af;
  color: white;
  padding: 14px 26px;
  border-radius: 10px;
  font-weight: 500;
  font-size: 15px;
  box-shadow: 0 5px 20px rgba(0,0,0,0.3);
  opacity: 0;
  transform: translateY(30px) scale(0.95);
  transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
  z-index: 9999;
}
.toast.show {
  opacity: 1;
  transform: translateY(0) scale(1);
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

  <!-- Left Side (Image + Intro) -->
  <div class="hidden md:flex w-1/2 bg-gradient-to-br from-indigo-700 to-blue-600 text-white flex-col justify-center p-8 relative">
    <h2 class="text-3xl font-bold mb-3 leading-snug z-10">Welcome Back, Admin</h2>
    <p class="text-white/90 text-sm leading-relaxed z-10">
      Manage hospital operations efficiently and securely from your dashboard.
    </p>
    <div class="mt-6 mx-auto bg-white/90 p-4 rounded-2xl shadow-xl z-10">
      <img src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png" alt="Admin Login" class="w-40 opacity-100">
    </div>
    <div class="absolute inset-0 bg-black/10"></div>
  </div>

  <!-- Right Side (Form) -->
  <div class="w-full md:w-1/2 bg-white/95 p-6 sm:p-8 text-gray-800">
    <div class="text-center mb-4">
      <h1 class="text-2xl font-bold text-indigo-700">HMS Admin Panel</h1>
      <p class="text-gray-600 text-sm">Secure Login Portal</p>
    </div>

    <form method="post" class="space-y-4">
      <input type="text" name="username" placeholder="Username" required class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-300">
      <input type="password" name="password" placeholder="Password" required class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-300">

      <button type="submit" name="submit" id="loginBtn" class="w-full bg-gradient-to-r from-indigo-600 to-blue-500 text-white py-2 rounded-lg font-semibold hover:opacity-90 transition-all">
        Login <i class="ri-login-circle-line ml-1"></i>
      </button>
    </form>

    <div class="text-center mt-3">
      <a href="../../index.php" class="text-indigo-600 text-sm hover:underline">← Back to Home Page</a>
    </div>

    <p class="text-center text-gray-600 text-xs mt-6">
      © <span class="current-year"></span> <b>HMS</b> — All rights reserved.
    </p>
  </div>

</div>

<?php if ($response === 'success') { ?>
<script>
document.addEventListener("DOMContentLoaded", () => {
  const btn = document.getElementById("loginBtn");
  btn.disabled = true;
  btn.innerHTML = "Redirecting...";
  showToast("Login successful! Redirecting to dashboard...", false, "dashboard.php");
});
</script>
<?php } elseif ($response === 'error') { ?>
<script>
document.addEventListener("DOMContentLoaded", () => {
  showToast("Invalid username or password. Try again.", true);
});
</script>
<?php } ?>

</body>
</html>
SESSION['id'] = $admin['id'];
        $response = 'success';
    } else {
        <?php
session_start();
include("include/config.php");
error_reporting(0);

$response = '';

if (isset($_POST['submit'])) {
    $uname = $_POST['username'];
    $upassword = $_POST['password'];

    $ret = mysqli_query($con, "SELECT * FROM admin WHERE username='$uname' AND password='$upassword'");
    $num = mysqli_fetch_array($ret);
    if ($num > 0) {
        $_SESSION['login'] = $_POST['username'];
        $_SESSION['id'] = $num['id'];
        $response = 'success';
    } else {
        $_SESSION['errmsg'] = "Invalid username or password";
        $response = 'error';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Login | HMS</title>

<!-- Tailwind CSS -->
<script src="https://cdn.tailwindcss.com"></script>

<!-- Google Font -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<!-- Remix Icons -->
<link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet">

<style>
body {
  font-family: 'Poppins', sans-serif;
  background: linear-gradient(135deg, #0f172a, #1e3a8a, #2563eb);
  color: #1e293b;
}
.glass {
  background: rgba(255, 255, 255, 0.18);
  backdrop-filter: blur(14px);
  border: 1px solid rgba(255, 255, 255, 0.25);
}
.fade { animation: fadeIn 0.6s ease-in-out; }
@keyframes fadeIn { from {opacity:0; transform:translateY(10px);} to {opacity:1; transform:translateY(0);} }

.toast {
  position: fixed;
  bottom: 25px;
  right: 25px;
  background: #1e40af;
  color: white;
  padding: 14px 26px;
  border-radius: 10px;
  font-weight: 500;
  font-size: 15px;
  box-shadow: 0 5px 20px rgba(0,0,0,0.3);
  opacity: 0;
  transform: translateY(30px) scale(0.95);
  transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
  z-index: 9999;
}
.toast.show {
  opacity: 1;
  transform: translateY(0) scale(1);
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

  <!-- Left Side (Image + Intro) -->
  <div class="hidden md:flex w-1/2 bg-gradient-to-br from-indigo-700 to-blue-600 text-white flex-col justify-center p-8 relative">
    <h2 class="text-3xl font-bold mb-3 leading-snug z-10">Welcome Back, Admin</h2>
    <p class="text-white/90 text-sm leading-relaxed z-10">
      Manage hospital operations efficiently and securely from your dashboard.
    </p>
    <div class="mt-6 mx-auto bg-white/90 p-4 rounded-2xl shadow-xl z-10">
      <img src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png" alt="Admin Login" class="w-40 opacity-100">
    </div>
    <div class="absolute inset-0 bg-black/10"></div>
  </div>

  <!-- Right Side (Form) -->
  <div class="w-full md:w-1/2 bg-white/95 p-6 sm:p-8 text-gray-800">
    <div class="text-center mb-4">
      <h1 class="text-2xl font-bold text-indigo-700">HMS Admin Panel</h1>
      <p class="text-gray-600 text-sm">Secure Login Portal</p>
    </div>

    <form method="post" class="space-y-4">
      <input type="text" name="username" placeholder="Username" required class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-300">
      <input type="password" name="password" placeholder="Password" required class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-300">

      <button type="submit" name="submit" id="loginBtn" class="w-full bg-gradient-to-r from-indigo-600 to-blue-500 text-white py-2 rounded-lg font-semibold hover:opacity-90 transition-all">
        Login <i class="ri-login-circle-line ml-1"></i>
      </button>
    </form>

    <div class="text-center mt-3">
      <a href="../../index.php" class="text-indigo-600 text-sm hover:underline">← Back to Home Page</a>
    </div>

    <p class="text-center text-gray-600 text-xs mt-6">
      © <span class="current-year"></span> <b>HMS</b> — All rights reserved.
    </p>
  </div>

</div>

<?php if ($response === 'success') { ?>
<script>
document.addEventListener("DOMContentLoaded", () => {
  const btn = document.getElementById("loginBtn");
  btn.disabled = true;
  btn.innerHTML = "Redirecting...";
  showToast("Login successful! Redirecting to dashboard...", false, "dashboard.php");
});
</script>
<?php } elseif ($response === 'error') { ?>
<script>
document.addEventListener("DOMContentLoaded", () => {
  showToast("Invalid username or password. Try again.", true);
});
</script>
<?php } ?>

</body>
</html>
SESSION['errmsg'] = "Invalid username or password";
        $response = 'error';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Login | HMS</title>

<!-- Tailwind CSS -->
<script src="https://cdn.tailwindcss.com"></script>

<!-- Google Font -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<!-- Remix Icons -->
<link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet">

<style>
body {
  font-family: 'Poppins', sans-serif;
  background: linear-gradient(135deg, #0f172a, #1e3a8a, #2563eb);
  color: #1e293b;
}
.glass {
  background: rgba(255, 255, 255, 0.18);
  backdrop-filter: blur(14px);
  border: 1px solid rgba(255, 255, 255, 0.25);
}
.fade { animation: fadeIn 0.6s ease-in-out; }
@keyframes fadeIn { from {opacity:0; transform:translateY(10px);} to {opacity:1; transform:translateY(0);} }

.toast {
  position: fixed;
  bottom: 25px;
  right: 25px;
  background: #1e40af;
  color: white;
  padding: 14px 26px;
  border-radius: 10px;
  font-weight: 500;
  font-size: 15px;
  box-shadow: 0 5px 20px rgba(0,0,0,0.3);
  opacity: 0;
  transform: translateY(30px) scale(0.95);
  transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
  z-index: 9999;
}
.toast.show {
  opacity: 1;
  transform: translateY(0) scale(1);
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

  <!-- Left Side (Image + Intro) -->
  <div class="hidden md:flex w-1/2 bg-gradient-to-br from-indigo-700 to-blue-600 text-white flex-col justify-center p-8 relative">
    <h2 class="text-3xl font-bold mb-3 leading-snug z-10">Welcome Back, Admin</h2>
    <p class="text-white/90 text-sm leading-relaxed z-10">
      Manage hospital operations efficiently and securely from your dashboard.
    </p>
    <div class="mt-6 mx-auto bg-white/90 p-4 rounded-2xl shadow-xl z-10">
      <img src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png" alt="Admin Login" class="w-40 opacity-100">
    </div>
    <div class="absolute inset-0 bg-black/10"></div>
  </div>

  <!-- Right Side (Form) -->
  <div class="w-full md:w-1/2 bg-white/95 p-6 sm:p-8 text-gray-800">
    <div class="text-center mb-4">
      <h1 class="text-2xl font-bold text-indigo-700">HMS Admin Panel</h1>
      <p class="text-gray-600 text-sm">Secure Login Portal</p>
    </div>

    <form method="post" class="space-y-4">
      <input type="text" name="username" placeholder="Username" required class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-300">
      <input type="password" name="password" placeholder="Password" required class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-300">

      <button type="submit" name="submit" id="loginBtn" class="w-full bg-gradient-to-r from-indigo-600 to-blue-500 text-white py-2 rounded-lg font-semibold hover:opacity-90 transition-all">
        Login <i class="ri-login-circle-line ml-1"></i>
      </button>
    </form>

    <div class="text-center mt-3">
      <a href="../../index.php" class="text-indigo-600 text-sm hover:underline">← Back to Home Page</a>
    </div>

    <p class="text-center text-gray-600 text-xs mt-6">
      © <span class="current-year"></span> <b>HMS</b> — All rights reserved.
    </p>
  </div>

</div>

<?php if ($response === 'success') { ?>
<script>
document.addEventListener("DOMContentLoaded", () => {
  const btn = document.getElementById("loginBtn");
  btn.disabled = true;
  btn.innerHTML = "Redirecting...";
  showToast("Login successful! Redirecting to dashboard...", false, "dashboard.php");
});
</script>
<?php } elseif ($response === 'error') { ?>
<script>
document.addEventListener("DOMContentLoaded", () => {
  showToast("Invalid username or password. Try again.", true);
});
</script>
<?php } ?>

</body>
</html>


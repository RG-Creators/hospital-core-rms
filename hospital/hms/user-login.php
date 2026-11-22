<?php
session_start();
error_reporting(0);
include("include/config.php");
$response = '';

if (isset($_POST['submit'])) {
    $puname = trim($_POST['username'] ?? '');
    $raw_pass = $_POST['password'] ?? '';
    $ppwd = md5($raw_pass);
    
    $stmt = mysqli_prepare($con, "SELECT * FROM users WHERE email = ?");
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "s", $puname);
        mysqli_stmt_execute($stmt);
        $res = mysqli_stmt_get_result($stmt);
        $num = mysqli_fetch_array($res, MYSQLI_ASSOC);
        
        $login_ok = false;
        if ($num) {
            if ($num['password'] === $ppwd || password_verify($raw_pass, $num['password']) || $num['password'] === $raw_pass) {
                $login_ok = true;
            }
        }
        
        if ($login_ok) {
            $_SESSION['login'] = $puname;
            $_SESSION['id'] = $num['id'];
            $pid = (int)$num['id'];
            $uip = $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';
            $status = 1;
            
            $log_stmt = mysqli_prepare($con, "INSERT INTO userlog(uid, username, userip, status) VALUES(?, ?, ?, ?)");
            if ($log_stmt) {
                mysqli_stmt_bind_param($log_stmt, "issi", $pid, $puname, $uip, $status);
                mysqli_stmt_execute($log_stmt);
            }
            $response = 'success';
        } else {
            $uip = $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';
            $status = 0;
            $log_stmt = mysqli_prepare($con, "INSERT INTO userlog(username, userip, status) VALUES(?, ?, ?)");
            if ($log_stmt) {
                mysqli_stmt_bind_param($log_stmt, "ssi", $puname, $uip, $status);
                mysqli_stmt_execute($log_stmt);
            }
            $response = 'error';
        }
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
<title>Patient Login | HMS</title>

<!-- Tailwind CSS -->
<script src="https://cdn.tailwindcss.com"></script>

<!-- Poppins Font -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<!-- Remix Icons -->
<link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet">

<style>
body {
  font-family: 'Poppins', sans-serif;
  background: linear-gradient(135deg, #2563eb, #3b82f6, #06b6d4);
  color: #1e3a8a;
}
.glass {
  background: rgba(255, 255, 255, 0.25);
  backdrop-filter: blur(12px);
  border: 1px solid rgba(255, 255, 255, 0.3);
}
.fade { animation: fadeIn 0.6s ease-in-out; }
@keyframes fadeIn { from {opacity:0; transform:translateY(10px);} to {opacity:1; transform:translateY(0);} }

.toast {
  position: fixed;
  bottom: 30px;
  left: 50%;
  transform: translateX(-50%) scale(0.9);
  background: #16a34a;
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
.toast.error {
  background: #dc2626;
}
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
  }, 1200);
}
</script>
</head>

<body class="min-h-screen flex items-center justify-center p-3 fade">

<!-- Toast Notification -->
<div id="toast" class="toast"></div>

<div class="w-full max-w-4xl flex flex-col md:flex-row rounded-2xl overflow-hidden glass shadow-2xl">

  <!-- Left Section -->
  <div class="hidden md:flex w-1/2 bg-gradient-to-br from-blue-700 to-cyan-500 text-white flex-col justify-center p-8">
    <h2 class="text-3xl font-bold mb-3 leading-snug">Welcome Back!</h2>
    <p class="text-white/90 text-sm leading-relaxed">
      Log in to manage appointments, view reports, and access your medical dashboard.
    </p>
    <img src="https://cdn-icons-png.flaticon.com/512/4140/4140048.png" alt="Login Illustration" class="w-40 mt-5 mx-auto opacity-95">
  </div>

  <!-- Right Login Form -->
  <div class="w-full md:w-1/2 bg-white/95 p-6 sm:p-8 text-gray-800">
    <div class="text-center mb-4">
      <a href="../index.php" class="text-2xl font-bold text-blue-700">HMS</a>
      <p class="text-gray-600 text-sm">Patient Login</p>
    </div>

    <form class="space-y-4" method="post">
      <input type="email" name="username" placeholder="Email" required class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-300">
      <input type="password" name="password" placeholder="Password" required class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-300">

      <div class="flex justify-between text-xs">
        <a href="forgot-password.php" class="text-blue-600 hover:underline">Forgot Password?</a>
        <a href="registration.php" class="text-blue-600 hover:underline">Create Account</a>
      </div>

      <button type="submit" name="submit" id="loginBtn" class="w-full bg-gradient-to-r from-blue-500 to-cyan-400 text-white py-2 rounded-lg font-semibold hover:opacity-90 transition-all">
        Login <i class="ri-login-circle-line ml-1"></i>
      </button>
    </form>

    <p class="text-center text-gray-600 text-xs mt-4">
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
  showToast("Login Successful!", false, "dashboard.php");
});
</script>
<?php } elseif ($response === 'error') { ?>
<script>
document.addEventListener("DOMContentLoaded", () => {
  showToast("Invalid username or password", true);
});
</script>
<?php } ?>

</body>
</html>
POST['submit'])) {
    $puname = trim(<?php
session_start();
error_reporting(0);
include("include/config.php");
$response = '';

if (isset($_POST['submit'])) {
    $puname = $_POST['username'];    
    $ppwd = md5($_POST['password']);
    $ret = mysqli_query($con, "SELECT * FROM users WHERE email='$puname' AND password='$ppwd'");
    $num = mysqli_fetch_array($ret);
    if ($num > 0) {
        $_SESSION['login'] = $_POST['username'];
        $_SESSION['id'] = $num['id'];
        $pid = $num['id'];
        $uip = $_SERVER['REMOTE_ADDR'];
        $status = 1;
        mysqli_query($con, "INSERT INTO userlog(uid, username, userip, status) VALUES('$pid', '$puname', '$uip', '$status')");
        $response = 'success';
    } else {
        $uip = $_SERVER['REMOTE_ADDR'];
        $status = 0;
        mysqli_query($con, "INSERT INTO userlog(username, userip, status) VALUES('$puname', '$uip', '$status')");
        $response = 'error';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Patient Login | HMS</title>

<!-- Tailwind CSS -->
<script src="https://cdn.tailwindcss.com"></script>

<!-- Poppins Font -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<!-- Remix Icons -->
<link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet">

<style>
body {
  font-family: 'Poppins', sans-serif;
  background: linear-gradient(135deg, #2563eb, #3b82f6, #06b6d4);
  color: #1e3a8a;
}
.glass {
  background: rgba(255, 255, 255, 0.25);
  backdrop-filter: blur(12px);
  border: 1px solid rgba(255, 255, 255, 0.3);
}
.fade { animation: fadeIn 0.6s ease-in-out; }
@keyframes fadeIn { from {opacity:0; transform:translateY(10px);} to {opacity:1; transform:translateY(0);} }

.toast {
  position: fixed;
  bottom: 30px;
  left: 50%;
  transform: translateX(-50%) scale(0.9);
  background: #16a34a;
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
.toast.error {
  background: #dc2626;
}
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
  }, 1200);
}
</script>
</head>

<body class="min-h-screen flex items-center justify-center p-3 fade">

<!-- Toast Notification -->
<div id="toast" class="toast"></div>

<div class="w-full max-w-4xl flex flex-col md:flex-row rounded-2xl overflow-hidden glass shadow-2xl">

  <!-- Left Section -->
  <div class="hidden md:flex w-1/2 bg-gradient-to-br from-blue-700 to-cyan-500 text-white flex-col justify-center p-8">
    <h2 class="text-3xl font-bold mb-3 leading-snug">Welcome Back!</h2>
    <p class="text-white/90 text-sm leading-relaxed">
      Log in to manage appointments, view reports, and access your medical dashboard.
    </p>
    <img src="https://cdn-icons-png.flaticon.com/512/4140/4140048.png" alt="Login Illustration" class="w-40 mt-5 mx-auto opacity-95">
  </div>

  <!-- Right Login Form -->
  <div class="w-full md:w-1/2 bg-white/95 p-6 sm:p-8 text-gray-800">
    <div class="text-center mb-4">
      <a href="../index.php" class="text-2xl font-bold text-blue-700">HMS</a>
      <p class="text-gray-600 text-sm">Patient Login</p>
    </div>

    <form class="space-y-4" method="post">
      <input type="email" name="username" placeholder="Email" required class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-300">
      <input type="password" name="password" placeholder="Password" required class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-300">

      <div class="flex justify-between text-xs">
        <a href="forgot-password.php" class="text-blue-600 hover:underline">Forgot Password?</a>
        <a href="registration.php" class="text-blue-600 hover:underline">Create Account</a>
      </div>

      <button type="submit" name="submit" id="loginBtn" class="w-full bg-gradient-to-r from-blue-500 to-cyan-400 text-white py-2 rounded-lg font-semibold hover:opacity-90 transition-all">
        Login <i class="ri-login-circle-line ml-1"></i>
      </button>
    </form>

    <p class="text-center text-gray-600 text-xs mt-4">
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
  showToast("Login Successful!", false, "dashboard.php");
});
</script>
<?php } elseif ($response === 'error') { ?>
<script>
document.addEventListener("DOMContentLoaded", () => {
  showToast("Invalid username or password", true);
});
</script>
<?php } ?>

</body>
</html>
POST['username'] ?? '');    
    $raw_pass = <?php
session_start();
error_reporting(0);
include("include/config.php");
$response = '';

if (isset($_POST['submit'])) {
    $puname = $_POST['username'];    
    $ppwd = md5($_POST['password']);
    $ret = mysqli_query($con, "SELECT * FROM users WHERE email='$puname' AND password='$ppwd'");
    $num = mysqli_fetch_array($ret);
    if ($num > 0) {
        $_SESSION['login'] = $_POST['username'];
        $_SESSION['id'] = $num['id'];
        $pid = $num['id'];
        $uip = $_SERVER['REMOTE_ADDR'];
        $status = 1;
        mysqli_query($con, "INSERT INTO userlog(uid, username, userip, status) VALUES('$pid', '$puname', '$uip', '$status')");
        $response = 'success';
    } else {
        $uip = $_SERVER['REMOTE_ADDR'];
        $status = 0;
        mysqli_query($con, "INSERT INTO userlog(username, userip, status) VALUES('$puname', '$uip', '$status')");
        $response = 'error';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Patient Login | HMS</title>

<!-- Tailwind CSS -->
<script src="https://cdn.tailwindcss.com"></script>

<!-- Poppins Font -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<!-- Remix Icons -->
<link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet">

<style>
body {
  font-family: 'Poppins', sans-serif;
  background: linear-gradient(135deg, #2563eb, #3b82f6, #06b6d4);
  color: #1e3a8a;
}
.glass {
  background: rgba(255, 255, 255, 0.25);
  backdrop-filter: blur(12px);
  border: 1px solid rgba(255, 255, 255, 0.3);
}
.fade { animation: fadeIn 0.6s ease-in-out; }
@keyframes fadeIn { from {opacity:0; transform:translateY(10px);} to {opacity:1; transform:translateY(0);} }

.toast {
  position: fixed;
  bottom: 30px;
  left: 50%;
  transform: translateX(-50%) scale(0.9);
  background: #16a34a;
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
.toast.error {
  background: #dc2626;
}
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
  }, 1200);
}
</script>
</head>

<body class="min-h-screen flex items-center justify-center p-3 fade">

<!-- Toast Notification -->
<div id="toast" class="toast"></div>

<div class="w-full max-w-4xl flex flex-col md:flex-row rounded-2xl overflow-hidden glass shadow-2xl">

  <!-- Left Section -->
  <div class="hidden md:flex w-1/2 bg-gradient-to-br from-blue-700 to-cyan-500 text-white flex-col justify-center p-8">
    <h2 class="text-3xl font-bold mb-3 leading-snug">Welcome Back!</h2>
    <p class="text-white/90 text-sm leading-relaxed">
      Log in to manage appointments, view reports, and access your medical dashboard.
    </p>
    <img src="https://cdn-icons-png.flaticon.com/512/4140/4140048.png" alt="Login Illustration" class="w-40 mt-5 mx-auto opacity-95">
  </div>

  <!-- Right Login Form -->
  <div class="w-full md:w-1/2 bg-white/95 p-6 sm:p-8 text-gray-800">
    <div class="text-center mb-4">
      <a href="../index.php" class="text-2xl font-bold text-blue-700">HMS</a>
      <p class="text-gray-600 text-sm">Patient Login</p>
    </div>

    <form class="space-y-4" method="post">
      <input type="email" name="username" placeholder="Email" required class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-300">
      <input type="password" name="password" placeholder="Password" required class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-300">

      <div class="flex justify-between text-xs">
        <a href="forgot-password.php" class="text-blue-600 hover:underline">Forgot Password?</a>
        <a href="registration.php" class="text-blue-600 hover:underline">Create Account</a>
      </div>

      <button type="submit" name="submit" id="loginBtn" class="w-full bg-gradient-to-r from-blue-500 to-cyan-400 text-white py-2 rounded-lg font-semibold hover:opacity-90 transition-all">
        Login <i class="ri-login-circle-line ml-1"></i>
      </button>
    </form>

    <p class="text-center text-gray-600 text-xs mt-4">
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
  showToast("Login Successful!", false, "dashboard.php");
});
</script>
<?php } elseif ($response === 'error') { ?>
<script>
document.addEventListener("DOMContentLoaded", () => {
  showToast("Invalid username or password", true);
});
</script>
<?php } ?>

</body>
</html>
POST['password'] ?? '';
    $uip = <?php
session_start();
error_reporting(0);
include("include/config.php");
$response = '';

if (isset($_POST['submit'])) {
    $puname = $_POST['username'];    
    $ppwd = md5($_POST['password']);
    $ret = mysqli_query($con, "SELECT * FROM users WHERE email='$puname' AND password='$ppwd'");
    $num = mysqli_fetch_array($ret);
    if ($num > 0) {
        $_SESSION['login'] = $_POST['username'];
        $_SESSION['id'] = $num['id'];
        $pid = $num['id'];
        $uip = $_SERVER['REMOTE_ADDR'];
        $status = 1;
        mysqli_query($con, "INSERT INTO userlog(uid, username, userip, status) VALUES('$pid', '$puname', '$uip', '$status')");
        $response = 'success';
    } else {
        $uip = $_SERVER['REMOTE_ADDR'];
        $status = 0;
        mysqli_query($con, "INSERT INTO userlog(username, userip, status) VALUES('$puname', '$uip', '$status')");
        $response = 'error';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Patient Login | HMS</title>

<!-- Tailwind CSS -->
<script src="https://cdn.tailwindcss.com"></script>

<!-- Poppins Font -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<!-- Remix Icons -->
<link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet">

<style>
body {
  font-family: 'Poppins', sans-serif;
  background: linear-gradient(135deg, #2563eb, #3b82f6, #06b6d4);
  color: #1e3a8a;
}
.glass {
  background: rgba(255, 255, 255, 0.25);
  backdrop-filter: blur(12px);
  border: 1px solid rgba(255, 255, 255, 0.3);
}
.fade { animation: fadeIn 0.6s ease-in-out; }
@keyframes fadeIn { from {opacity:0; transform:translateY(10px);} to {opacity:1; transform:translateY(0);} }

.toast {
  position: fixed;
  bottom: 30px;
  left: 50%;
  transform: translateX(-50%) scale(0.9);
  background: #16a34a;
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
.toast.error {
  background: #dc2626;
}
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
  }, 1200);
}
</script>
</head>

<body class="min-h-screen flex items-center justify-center p-3 fade">

<!-- Toast Notification -->
<div id="toast" class="toast"></div>

<div class="w-full max-w-4xl flex flex-col md:flex-row rounded-2xl overflow-hidden glass shadow-2xl">

  <!-- Left Section -->
  <div class="hidden md:flex w-1/2 bg-gradient-to-br from-blue-700 to-cyan-500 text-white flex-col justify-center p-8">
    <h2 class="text-3xl font-bold mb-3 leading-snug">Welcome Back!</h2>
    <p class="text-white/90 text-sm leading-relaxed">
      Log in to manage appointments, view reports, and access your medical dashboard.
    </p>
    <img src="https://cdn-icons-png.flaticon.com/512/4140/4140048.png" alt="Login Illustration" class="w-40 mt-5 mx-auto opacity-95">
  </div>

  <!-- Right Login Form -->
  <div class="w-full md:w-1/2 bg-white/95 p-6 sm:p-8 text-gray-800">
    <div class="text-center mb-4">
      <a href="../index.php" class="text-2xl font-bold text-blue-700">HMS</a>
      <p class="text-gray-600 text-sm">Patient Login</p>
    </div>

    <form class="space-y-4" method="post">
      <input type="email" name="username" placeholder="Email" required class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-300">
      <input type="password" name="password" placeholder="Password" required class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-300">

      <div class="flex justify-between text-xs">
        <a href="forgot-password.php" class="text-blue-600 hover:underline">Forgot Password?</a>
        <a href="registration.php" class="text-blue-600 hover:underline">Create Account</a>
      </div>

      <button type="submit" name="submit" id="loginBtn" class="w-full bg-gradient-to-r from-blue-500 to-cyan-400 text-white py-2 rounded-lg font-semibold hover:opacity-90 transition-all">
        Login <i class="ri-login-circle-line ml-1"></i>
      </button>
    </form>

    <p class="text-center text-gray-600 text-xs mt-4">
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
  showToast("Login Successful!", false, "dashboard.php");
});
</script>
<?php } elseif ($response === 'error') { ?>
<script>
document.addEventListener("DOMContentLoaded", () => {
  showToast("Invalid username or password", true);
});
</script>
<?php } ?>

</body>
</html>
SERVER['REMOTE_ADDR'] ?? '127.0.0.1';

    $stmt = mysqli_prepare($con, "SELECT id, email, password FROM users WHERE email = ?");
    mysqli_stmt_bind_param($stmt, "s", $puname);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    $user = mysqli_fetch_assoc($res);
    mysqli_stmt_close($stmt);

    $authenticated = false;
    if ($user) {
        if (password_verify($raw_pass, $user['password'])) {
            $authenticated = true;
        } elseif (md5($raw_pass) === $user['password']) {
            $authenticated = true;
            $newHash = password_hash($raw_pass, PASSWORD_BCRYPT);
            $upd = mysqli_prepare($con, "UPDATE users SET password = ? WHERE id = ?");
            mysqli_stmt_bind_param($upd, "si", $newHash, $user['id']);
            mysqli_stmt_execute($upd);
            mysqli_stmt_close($upd);
        }
    }

    if ($authenticated) {
        <?php
session_start();
error_reporting(0);
include("include/config.php");
$response = '';

if (isset($_POST['submit'])) {
    $puname = $_POST['username'];    
    $ppwd = md5($_POST['password']);
    $ret = mysqli_query($con, "SELECT * FROM users WHERE email='$puname' AND password='$ppwd'");
    $num = mysqli_fetch_array($ret);
    if ($num > 0) {
        $_SESSION['login'] = $_POST['username'];
        $_SESSION['id'] = $num['id'];
        $pid = $num['id'];
        $uip = $_SERVER['REMOTE_ADDR'];
        $status = 1;
        mysqli_query($con, "INSERT INTO userlog(uid, username, userip, status) VALUES('$pid', '$puname', '$uip', '$status')");
        $response = 'success';
    } else {
        $uip = $_SERVER['REMOTE_ADDR'];
        $status = 0;
        mysqli_query($con, "INSERT INTO userlog(username, userip, status) VALUES('$puname', '$uip', '$status')");
        $response = 'error';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Patient Login | HMS</title>

<!-- Tailwind CSS -->
<script src="https://cdn.tailwindcss.com"></script>

<!-- Poppins Font -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<!-- Remix Icons -->
<link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet">

<style>
body {
  font-family: 'Poppins', sans-serif;
  background: linear-gradient(135deg, #2563eb, #3b82f6, #06b6d4);
  color: #1e3a8a;
}
.glass {
  background: rgba(255, 255, 255, 0.25);
  backdrop-filter: blur(12px);
  border: 1px solid rgba(255, 255, 255, 0.3);
}
.fade { animation: fadeIn 0.6s ease-in-out; }
@keyframes fadeIn { from {opacity:0; transform:translateY(10px);} to {opacity:1; transform:translateY(0);} }

.toast {
  position: fixed;
  bottom: 30px;
  left: 50%;
  transform: translateX(-50%) scale(0.9);
  background: #16a34a;
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
.toast.error {
  background: #dc2626;
}
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
  }, 1200);
}
</script>
</head>

<body class="min-h-screen flex items-center justify-center p-3 fade">

<!-- Toast Notification -->
<div id="toast" class="toast"></div>

<div class="w-full max-w-4xl flex flex-col md:flex-row rounded-2xl overflow-hidden glass shadow-2xl">

  <!-- Left Section -->
  <div class="hidden md:flex w-1/2 bg-gradient-to-br from-blue-700 to-cyan-500 text-white flex-col justify-center p-8">
    <h2 class="text-3xl font-bold mb-3 leading-snug">Welcome Back!</h2>
    <p class="text-white/90 text-sm leading-relaxed">
      Log in to manage appointments, view reports, and access your medical dashboard.
    </p>
    <img src="https://cdn-icons-png.flaticon.com/512/4140/4140048.png" alt="Login Illustration" class="w-40 mt-5 mx-auto opacity-95">
  </div>

  <!-- Right Login Form -->
  <div class="w-full md:w-1/2 bg-white/95 p-6 sm:p-8 text-gray-800">
    <div class="text-center mb-4">
      <a href="../index.php" class="text-2xl font-bold text-blue-700">HMS</a>
      <p class="text-gray-600 text-sm">Patient Login</p>
    </div>

    <form class="space-y-4" method="post">
      <input type="email" name="username" placeholder="Email" required class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-300">
      <input type="password" name="password" placeholder="Password" required class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-300">

      <div class="flex justify-between text-xs">
        <a href="forgot-password.php" class="text-blue-600 hover:underline">Forgot Password?</a>
        <a href="registration.php" class="text-blue-600 hover:underline">Create Account</a>
      </div>

      <button type="submit" name="submit" id="loginBtn" class="w-full bg-gradient-to-r from-blue-500 to-cyan-400 text-white py-2 rounded-lg font-semibold hover:opacity-90 transition-all">
        Login <i class="ri-login-circle-line ml-1"></i>
      </button>
    </form>

    <p class="text-center text-gray-600 text-xs mt-4">
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
  showToast("Login Successful!", false, "dashboard.php");
});
</script>
<?php } elseif ($response === 'error') { ?>
<script>
document.addEventListener("DOMContentLoaded", () => {
  showToast("Invalid username or password", true);
});
</script>
<?php } ?>

</body>
</html>
SESSION['login'] = $puname;
        <?php
session_start();
error_reporting(0);
include("include/config.php");
$response = '';

if (isset($_POST['submit'])) {
    $puname = $_POST['username'];    
    $ppwd = md5($_POST['password']);
    $ret = mysqli_query($con, "SELECT * FROM users WHERE email='$puname' AND password='$ppwd'");
    $num = mysqli_fetch_array($ret);
    if ($num > 0) {
        $_SESSION['login'] = $_POST['username'];
        $_SESSION['id'] = $num['id'];
        $pid = $num['id'];
        $uip = $_SERVER['REMOTE_ADDR'];
        $status = 1;
        mysqli_query($con, "INSERT INTO userlog(uid, username, userip, status) VALUES('$pid', '$puname', '$uip', '$status')");
        $response = 'success';
    } else {
        $uip = $_SERVER['REMOTE_ADDR'];
        $status = 0;
        mysqli_query($con, "INSERT INTO userlog(username, userip, status) VALUES('$puname', '$uip', '$status')");
        $response = 'error';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Patient Login | HMS</title>

<!-- Tailwind CSS -->
<script src="https://cdn.tailwindcss.com"></script>

<!-- Poppins Font -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<!-- Remix Icons -->
<link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet">

<style>
body {
  font-family: 'Poppins', sans-serif;
  background: linear-gradient(135deg, #2563eb, #3b82f6, #06b6d4);
  color: #1e3a8a;
}
.glass {
  background: rgba(255, 255, 255, 0.25);
  backdrop-filter: blur(12px);
  border: 1px solid rgba(255, 255, 255, 0.3);
}
.fade { animation: fadeIn 0.6s ease-in-out; }
@keyframes fadeIn { from {opacity:0; transform:translateY(10px);} to {opacity:1; transform:translateY(0);} }

.toast {
  position: fixed;
  bottom: 30px;
  left: 50%;
  transform: translateX(-50%) scale(0.9);
  background: #16a34a;
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
.toast.error {
  background: #dc2626;
}
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
  }, 1200);
}
</script>
</head>

<body class="min-h-screen flex items-center justify-center p-3 fade">

<!-- Toast Notification -->
<div id="toast" class="toast"></div>

<div class="w-full max-w-4xl flex flex-col md:flex-row rounded-2xl overflow-hidden glass shadow-2xl">

  <!-- Left Section -->
  <div class="hidden md:flex w-1/2 bg-gradient-to-br from-blue-700 to-cyan-500 text-white flex-col justify-center p-8">
    <h2 class="text-3xl font-bold mb-3 leading-snug">Welcome Back!</h2>
    <p class="text-white/90 text-sm leading-relaxed">
      Log in to manage appointments, view reports, and access your medical dashboard.
    </p>
    <img src="https://cdn-icons-png.flaticon.com/512/4140/4140048.png" alt="Login Illustration" class="w-40 mt-5 mx-auto opacity-95">
  </div>

  <!-- Right Login Form -->
  <div class="w-full md:w-1/2 bg-white/95 p-6 sm:p-8 text-gray-800">
    <div class="text-center mb-4">
      <a href="../index.php" class="text-2xl font-bold text-blue-700">HMS</a>
      <p class="text-gray-600 text-sm">Patient Login</p>
    </div>

    <form class="space-y-4" method="post">
      <input type="email" name="username" placeholder="Email" required class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-300">
      <input type="password" name="password" placeholder="Password" required class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-300">

      <div class="flex justify-between text-xs">
        <a href="forgot-password.php" class="text-blue-600 hover:underline">Forgot Password?</a>
        <a href="registration.php" class="text-blue-600 hover:underline">Create Account</a>
      </div>

      <button type="submit" name="submit" id="loginBtn" class="w-full bg-gradient-to-r from-blue-500 to-cyan-400 text-white py-2 rounded-lg font-semibold hover:opacity-90 transition-all">
        Login <i class="ri-login-circle-line ml-1"></i>
      </button>
    </form>

    <p class="text-center text-gray-600 text-xs mt-4">
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
  showToast("Login Successful!", false, "dashboard.php");
});
</script>
<?php } elseif ($response === 'error') { ?>
<script>
document.addEventListener("DOMContentLoaded", () => {
  showToast("Invalid username or password", true);
});
</script>
<?php } ?>

</body>
</html>
SESSION['id'] = $user['id'];
        $pid = $user['id'];
        $status = 1;
        $logStmt = mysqli_prepare($con, "INSERT INTO userlog(uid, username, userip, status) VALUES(?, ?, ?, ?)");
        mysqli_stmt_bind_param($logStmt, "issi", $pid, $puname, $uip, $status);
        mysqli_stmt_execute($logStmt);
        mysqli_stmt_close($logStmt);
        $response = 'success';
    } else {
        $status = 0;
        $logStmt = mysqli_prepare($con, "INSERT INTO userlog(username, userip, status) VALUES(?, ?, ?)");
        mysqli_stmt_bind_param($logStmt, "ssi", $puname, $uip, $status);
        mysqli_stmt_execute($logStmt);
        mysqli_stmt_close($logStmt);
        $response = 'error';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Patient Login | HMS</title>

<!-- Tailwind CSS -->
<script src="https://cdn.tailwindcss.com"></script>

<!-- Poppins Font -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<!-- Remix Icons -->
<link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet">

<style>
body {
  font-family: 'Poppins', sans-serif;
  background: linear-gradient(135deg, #2563eb, #3b82f6, #06b6d4);
  color: #1e3a8a;
}
.glass {
  background: rgba(255, 255, 255, 0.25);
  backdrop-filter: blur(12px);
  border: 1px solid rgba(255, 255, 255, 0.3);
}
.fade { animation: fadeIn 0.6s ease-in-out; }
@keyframes fadeIn { from {opacity:0; transform:translateY(10px);} to {opacity:1; transform:translateY(0);} }

.toast {
  position: fixed;
  bottom: 30px;
  left: 50%;
  transform: translateX(-50%) scale(0.9);
  background: #16a34a;
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
.toast.error {
  background: #dc2626;
}
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
  }, 1200);
}
</script>
</head>

<body class="min-h-screen flex items-center justify-center p-3 fade">

<!-- Toast Notification -->
<div id="toast" class="toast"></div>

<div class="w-full max-w-4xl flex flex-col md:flex-row rounded-2xl overflow-hidden glass shadow-2xl">

  <!-- Left Section -->
  <div class="hidden md:flex w-1/2 bg-gradient-to-br from-blue-700 to-cyan-500 text-white flex-col justify-center p-8">
    <h2 class="text-3xl font-bold mb-3 leading-snug">Welcome Back!</h2>
    <p class="text-white/90 text-sm leading-relaxed">
      Log in to manage appointments, view reports, and access your medical dashboard.
    </p>
    <img src="https://cdn-icons-png.flaticon.com/512/4140/4140048.png" alt="Login Illustration" class="w-40 mt-5 mx-auto opacity-95">
  </div>

  <!-- Right Login Form -->
  <div class="w-full md:w-1/2 bg-white/95 p-6 sm:p-8 text-gray-800">
    <div class="text-center mb-4">
      <a href="../index.php" class="text-2xl font-bold text-blue-700">HMS</a>
      <p class="text-gray-600 text-sm">Patient Login</p>
    </div>

    <form class="space-y-4" method="post">
      <input type="email" name="username" placeholder="Email" required class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-300">
      <input type="password" name="password" placeholder="Password" required class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-300">

      <div class="flex justify-between text-xs">
        <a href="forgot-password.php" class="text-blue-600 hover:underline">Forgot Password?</a>
        <a href="registration.php" class="text-blue-600 hover:underline">Create Account</a>
      </div>

      <button type="submit" name="submit" id="loginBtn" class="w-full bg-gradient-to-r from-blue-500 to-cyan-400 text-white py-2 rounded-lg font-semibold hover:opacity-90 transition-all">
        Login <i class="ri-login-circle-line ml-1"></i>
      </button>
    </form>

    <p class="text-center text-gray-600 text-xs mt-4">
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
  showToast("Login Successful!", false, "dashboard.php");
});
</script>
<?php } elseif ($response === 'error') { ?>
<script>
document.addEventListener("DOMContentLoaded", () => {
  showToast("Invalid username or password", true);
});
</script>
<?php } ?>

</body>
</html>


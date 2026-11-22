<?php
include_once('include/config.php');
$response = '';
if (isset($_POST['submit'])) {
    $fname = $_POST['full_name'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $gender = $_POST['gender'];
    $email = $_POST['email'];
    $password = md5($_POST['password']);
    $query = mysqli_query($con, "INSERT INTO users(fullname,address,city,gender,email,password) VALUES('$fname','$address','$city','$gender','$email','$password')");
    if ($query) {
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
<title>Patient Registration | HMS</title>

<!-- Tailwind CSS -->
<script src="https://cdn.tailwindcss.com"></script>

<!-- Poppins Font -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<!-- Remix Icons -->
<link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet">

<style>
body {
  font-family: 'Poppins', sans-serif;
  background: linear-gradient(135deg, #0077b6, #0096c7, #00b4d8);
  color: #023e8a;
}
.glass {
  background: rgba(255, 255, 255, 0.2);
  backdrop-filter: blur(10px);
  border: 1px solid rgba(255, 255, 255, 0.3);
}
.fade { animation: fadeIn 0.6s ease-in-out; }
@keyframes fadeIn {
  from {opacity: 0; transform: translateY(10px);}
  to {opacity: 1; transform: translateY(0);}
}
.toast {
  position: fixed;
  top: 20px;
  right: 20px;
  background: #38b000;
  color: white;
  padding: 10px 16px;
  border-radius: 6px;
  box-shadow: 0 2px 10px rgba(0,0,0,0.2);
  opacity: 0;
  transform: translateY(-10px);
  transition: all 0.4s ease;
  z-index: 9999;
}
.toast.show {
  opacity: 1;
  transform: translateY(0);
}
.toast.error {
  background: #d00000;
}
</style>

<script>
function valid() {
  if(document.registration.password.value != document.registration.password_again.value) {
    showToast("Passwords do not match!", true);
    return false;
  }
  return true;
}
function showToast(message, isError = false) {
  const toast = document.getElementById("toast");
  toast.textContent = message;
  if (isError) toast.classList.add("error");
  toast.classList.add("show");
  setTimeout(() => {
    toast.classList.remove("show", "error");
  }, 3000);
}
</script>
</head>

<body class="min-h-screen flex items-center justify-center p-3 fade">

<!-- Toast Notification -->
<div id="toast" class="toast"></div>

<div class="w-full max-w-4xl flex flex-col md:flex-row rounded-2xl overflow-hidden glass shadow-2xl">

  <!-- Left Panel -->
  <div class="hidden md:flex w-1/2 bg-gradient-to-br from-blue-600 to-teal-400 text-white flex-col justify-center p-8 relative overflow-hidden">
	  <h2 class="text-3xl font-bold mb-3 leading-snug z-10">Welcome to MediCare</h2>
	  <p class="text-white/90 text-sm leading-relaxed z-10">
	    Register now and access personalized, efficient healthcare services with ease.
	  </p>	

	  <div class="mt-6 mx-auto bg-white/90 p-4 rounded-2xl shadow-lg backdrop-blur-sm z-10">
	    <img src="https://cdn-icons-png.flaticon.com/512/2966/2966481.png" alt="Health" class="w-36 opacity-100">
	  </div>	

	  <!-- Optional subtle overlay for better readability -->
	  <div class="absolute inset-0 bg-black/10"></div>
	</div>	


  <!-- Right Panel -->
  <div class="w-full md:w-1/2 bg-white/90 p-6 sm:p-8 text-gray-800">
    <div class="text-center mb-4">
      <a href="../index.php" class="text-2xl font-bold text-blue-700">HMS</a>
      <p class="text-gray-600 text-sm">Patient Registration</p>
    </div>

    <form name="registration" id="registration" method="post" onSubmit="return valid();" class="space-y-3">
      <input type="text" name="full_name" placeholder="Full Name" required class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-300">
      <input type="text" name="address" placeholder="Address" required class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-300">
      <input type="text" name="city" placeholder="City" required class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-300">

      <div class="flex items-center space-x-4">
        <label class="text-sm font-medium">Gender:</label>
        <label class="flex items-center space-x-1"><input type="radio" name="gender" value="female"><span>Female</span></label>
        <label class="flex items-center space-x-1"><input type="radio" name="gender" value="male"><span>Male</span></label>
      </div>

      <input type="email" name="email" id="email" placeholder="Email" onBlur="userAvailability()" required class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-300">
      <span id="user-availability-status1" class="text-xs text-gray-500"></span>

      <input type="password" id="password" name="password" placeholder="Password" required class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-300">
      <input type="password" id="password_again" name="password_again" placeholder="Confirm Password" required class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-300">

      <div class="flex justify-between items-center">
        <label class="text-xs"><input type="checkbox" checked readonly class="accent-blue-600"> I agree</label>
        <a href="user-login.php" class="text-xs text-blue-600 hover:underline">Already have an account?</a>
      </div>

      <button type="submit" id="submit" name="submit" class="w-full bg-gradient-to-r from-blue-500 to-teal-400 text-white py-2 rounded-lg font-semibold hover:opacity-90 transition-all">
        Register Now <i class="ri-arrow-right-line ml-1"></i>
      </button>
    </form>

    <p class="text-center text-gray-600 text-xs mt-3">
      © <span class="current-year"></span> <b>HMS</b> — All rights reserved.
    </p>
  </div>
</div>

<script src="vendor/jquery/jquery.min.js"></script>
<script>
function userAvailability() {
  $("#loaderIcon").show();
  jQuery.ajax({
    url: "check_availability.php",
    data:'email='+$("#email").val(),
    type: "POST",
    success:function(data){
      $("#user-availability-status1").html(data);
      $("#loaderIcon").hide();
    }
  });
}
</script>

<?php if ($response === 'success') { ?>
<script>
document.addEventListener("DOMContentLoaded", () => {
  const btn = document.getElementById("submit");
  btn.disabled = true;
  btn.innerHTML = "Redirecting...";
  showToast("Registration Successful!");
  setTimeout(() => {
    window.location.href = "user-login.php";
  }, 2500);
});
</script>
<?php } elseif ($response === 'error') { ?>
<script>document.addEventListener("DOMContentLoaded", () => showToast("Something went wrong!", true));</script>
<?php } ?>

</body>
</html>

<?php error_reporting(0); ?>
<header style="
  background: #ffffff;
  border-bottom: 1px solid #e5e7eb;
  box-shadow: 0 2px 10px rgba(0,0,0,0.05);
  padding: 10px 25px;
  display: flex;
  align-items: center;
  justify-content: space-between;
  position: sticky;
  top: 0;
  z-index: 999;
  height: 65px;
  font-family: 'Poppins', sans-serif;
">
  <!-- Left Section: Logo + Sidebar Toggle -->
  <div style="display: flex; align-items: center; gap: 15px;">
    <button id="sidebarToggle" style="
      background: none;
      border: none;
      font-size: 20px;
      color: #2d6cdf;
      cursor: pointer;
      transition: 0.3s;
    ">
      <i class="fa-solid fa-bars"></i>
    </button>
    <a href="dashboard.php" style="text-decoration: none;">
      <h2 style="
        font-weight: 700;
        color: #2d6cdf;
        font-size: 22px;
        margin: 0;
      ">HMS</h2>
    </a>
  </div>

  <!-- Center Section: Title -->
  <div class="hidden-sm hidden-xs" style="text-align: center;">
    <h3 style="
      margin: 0;
      font-weight: 600;
      color: #334155;
      letter-spacing: 0.5px;
    ">Hospital Management System</h3>
  </div>

  <!-- Right Section: User Dropdown -->
  <div class="user-dropdown" style="position: relative;">
    <div style="display: flex; align-items: center; gap: 10px; cursor: pointer;" id="userMenuToggle">
      <img src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png"
           alt="User"
           style="width: 42px; height: 42px; border-radius: 50%; background: #f1f5f9; padding: 5px;">
      <span style="display: flex; align-items: center; gap: 5px; color: #334155; font-weight: 500;">
        <?php 
          $query = mysqli_query($con, "SELECT fullName FROM users WHERE id='".$_SESSION['id']."'");
          while($row = mysqli_fetch_array($query)) {
            echo htmlspecialchars($row['fullName']);
          }
        ?>
        <i class="fa-solid fa-chevron-down" style="font-size: 12px; color: #64748b;"></i>
      </span>
    </div>

    <!-- Dropdown Menu -->
    <ul class="dropdown-menu" id="userMenu" style="
      position: absolute;
      right: 0;
      top: 48px; /* ↓ Reduced from 55px → closes gap */
      background: #fff;
      border: 1px solid #e5e7eb;
      border-radius: 10px;
      box-shadow: 0 6px 18px rgba(0, 0, 0, 0.08);
      min-width: 200px;
      padding: 8px 0;
      display: none;
      opacity: 0;
      transform: translateY(-5px);
      transition: all 0.18s ease-in-out;
      z-index: 1000;
    ">
      <li style="list-style: none;">
        <a href="edit-profile.php" style="
          display: flex;
          align-items: center;
          gap: 10px;
          padding: 10px 18px;
          color: #374151;
          text-decoration: none;
          transition: background 0.2s ease, color 0.2s ease;
        ">
          <i class="fa-solid fa-user" style="color: #2563eb; width: 18px;"></i> My Profile
        </a>
      </li>
      <li style="list-style: none;">
        <a href="change-password.php" style="
          display: flex;
          align-items: center;
          gap: 10px;
          padding: 10px 18px;
          color: #374151;
          text-decoration: none;
          transition: background 0.2s ease, color 0.2s ease;
        ">
          <i class="fa-solid fa-key" style="color: #2563eb; width: 18px;"></i> Change Password
        </a>
      </li>
      <li style="list-style: none;">
        <a href="logout.php" class="logout" style="
          display: flex;
          align-items: center;
          gap: 10px;
          padding: 10px 18px;
          color: #dc2626;
          text-decoration: none;
          transition: background 0.2s ease, color 0.2s ease;
        ">
          <i class="fa-solid fa-right-from-bracket" style="color: #dc2626; width: 18px;"></i> Log Out
        </a>
      </li>
    </ul>
  </div>
</header>

<!-- Font Awesome -->
<script src="https://kit.fontawesome.com/a2e0e6ad54.js" crossorigin="anonymous"></script>

<script>
  // Dropdown toggle
  const userMenuToggle = document.getElementById("userMenuToggle");
  const userMenu = document.getElementById("userMenu");

  document.addEventListener("click", (e) => {
    if (userMenuToggle.contains(e.target)) {
      e.preventDefault();
      const isVisible = userMenu.style.display === "block";
      userMenu.style.display = isVisible ? "none" : "block";
      userMenu.style.opacity = isVisible ? "0" : "1";
      userMenu.style.transform = isVisible ? "translateY(-5px)" : "translateY(0)";
    } else if (!userMenu.contains(e.target)) {
      userMenu.style.display = "none";
      userMenu.style.opacity = "0";
      userMenu.style.transform = "translateY(-5px)";
    }
  });

  // Sidebar toggle
  document.getElementById("sidebarToggle")?.addEventListener("click", () => {
    document.getElementById("sidebar")?.classList.toggle("collapsed");
  });
</script>

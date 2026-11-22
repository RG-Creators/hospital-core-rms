<!-- Include Poppins Font and Tailwind -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
<script src="https://cdn.tailwindcss.com"></script>

<div class="w-64 h-screen fixed top-0 left-0 bg-gradient-to-b from-white to-gray-100 shadow-lg flex flex-col transition-all duration-300 ease-in-out z-50 font-[Poppins]">
  
  <!-- Sidebar Header -->
  <div class="px-6 py-5 border-b border-gray-200">
    <h2 class="text-2xl font-bold text-blue-600 tracking-tight">HMS Panel</h2>
  </div>

  <!-- Navigation -->
  <nav class="flex-1 overflow-y-auto mt-4">
    <ul class="space-y-1">

      <!-- Dashboard -->
      <li>
        <a href="dashboard.php" class="flex items-center gap-3 px-6 py-3 text-gray-700 font-medium hover:bg-blue-50 hover:text-blue-600 border-l-4 border-transparent hover:border-blue-500 transition-all duration-200">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 group-hover:text-blue-600 transition" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M13 5v6h6" />
          </svg>
          <span>Dashboard</span>
        </a>
      </li>

      <!-- Book Appointment -->
      <li>
        <a href="book-appointment.php" class="flex items-center gap-3 px-6 py-3 text-gray-700 font-medium hover:bg-blue-50 hover:text-blue-600 border-l-4 border-transparent hover:border-blue-500 transition-all duration-200">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 group-hover:text-blue-600 transition" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v10M16 7v10M3 7h18" />
          </svg>
          <span>Book Appointment</span>
        </a>
      </li>

      <!-- Appointment History -->
      <li>
        <a href="appointment-history.php" class="flex items-center gap-3 px-6 py-3 text-gray-700 font-medium hover:bg-blue-50 hover:text-blue-600 border-l-4 border-transparent hover:border-blue-500 transition-all duration-200">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 group-hover:text-blue-600 transition" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
          </svg>
          <span>Appointment History</span>
        </a>
      </li>

      <!-- Medical History -->
      <li>
        <a href="manage-medhistory.php" class="flex items-center gap-3 px-6 py-3 text-gray-700 font-medium hover:bg-blue-50 hover:text-blue-600 border-l-4 border-transparent hover:border-blue-500 transition-all duration-200">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 group-hover:text-blue-600 transition" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
          <span>Medical History</span>
        </a>
      </li>

    </ul>
  </nav>
</div>

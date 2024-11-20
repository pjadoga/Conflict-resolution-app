<?php
require('config/config.php');

$sql = "SELECT * FROM conflict_reports WHERE status = 'pending'";
$counter = "SELECT * FROM conflict_reports WHERE status = 'pending'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<h1>Pending Conflict Reports</h1>";
    while($row = $result->fetch_assoc()) {
        echo "<div>";
        echo "<h2>Location: " . $row["location"] . "</h2>";
        echo "<p>Issue: " . $row["issue_description"] . "</p>";
        echo "<p>Date Reported: " . $row["date_reported"] . "</p>";
        echo "<form action='resolve_report.php' method='post'>";
        echo "<input type='hidden' name='id' value='" . $row["id"] . "'>";
        echo "<input type='submit' value='Mark as Resolved'>";
        echo "</form>";
        echo "</div>";
    }
} else {
    echo "No pending reports.";
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">

  <!-- Header -->
  <header class="bg-blue-600 text-white py-4">
    <div class="container mx-auto flex justify-between items-center">
      <h1 class="text-xl font-bold">Admin Dashboard</h1>
      <div class="relative">
        <button class="relative text-white focus:outline-none">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-5-5.917V4a1 1 0 00-2 0v1.083A6.002 6.002 0 006 11v3.159c0 .538-.214 1.055-.595 1.437L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
          </svg>
          <span class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-red-100 bg-red-600 rounded-full">
            <span id="notification-count"> </span>
          </span>
        </button>
      </div>
    </div>
  </header>

  <!-- Sidebar and Main Content -->
  <div class="flex">
    <!-- Sidebar -->
     <?php require('sidebar.php'); ?>
    <!-- <nav class="w-64 bg-white shadow-md h-screen">
      <div class="p-6">
        <a href="#" class="text-gray-700 text-lg font-semibold block">Dashboard</a>
        <a href="#" class="text-gray-700 text-lg font-semibold block mt-4">Reports</a>
        <a href="#" class="text-gray-700 text-lg font-semibold block mt-4">Settings</a>
      </div>
    </nav> -->

    <!-- Main Content -->
    <main class="flex-1 p-6">
      <h2 class="text-2xl font-semibold text-gray-700">Notifications</h2>
      <div class="mt-6">
        <div class="bg-white p-4 rounded-lg shadow-md">
          <h3 class="text-lg font-medium text-gray-700">Pending Notifications</h3>
          <p class="text-gray-600 mt-2">
            You have <span id="pending-notifications"></span> pending notifications.
          </p>
        </div>
      </div>
    </main>
  </div>

  <script>
    // Example: Update the notification count dynamically
    document.addEventListener('DOMContentLoaded', function() {
      const pendingNotifications = <?php  
         $pending_counter =mysqli_query($conn, $counter);
         if($pending_report = mysqli_num_rows($pending_counter)){
           echo $pending_report;
         }  else {
           echo 0;
         } 
         $conn->close();
        ?> // Fetch this from your backend
      document.getElementById('notification-count').textContent = pendingNotifications;
      document.getElementById('pending-notifications').textContent = pendingNotifications;
    });
  </script>
</body>
</html>

<?php
require('config/config.php');

$sql = "SELECT * FROM conflict_reports WHERE status = 'pending'";
$counter = "SELECT * FROM conflict_reports WHERE status = 'pending'";
$result = $conn->query($sql);
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
  <title>Admin Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <link rel= “manifest” href= “manifest.json” />
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
    <?php require('sidemenu/sidebar.php'); ?>

    <!-- Main Content -->
    <main>
        <h2 class="text-2xl font-semibold text-gray-700">Notifications</h2>
        <div class="flex flex-row flex-wrap justify-evenly">
          <!-- <div class="mt-6"> -->
            <div class="bg-indigo-500 p-4 rounded-lg shadow-md">
              <h3 class="text-lg font-medium text-white-700">Pending Notifications</h3>
              <p class="text-white-600 mt-2">
                You have <span id="pending-notifications"></span> pending notifications.
              </p>
            </div>
            <!-- <div class="mt-6"> -->
            <div class="bg-white p-4 rounded-lg shadow-lg">
              <h3 class="text-lg font-medium text-gray-700">Pending Notifications</h3>
              <p class="text-gray-600 mt-2">
                You have <span id="pending-notifications"></span> pending notifications.
              </p>
            </div>
        </div>


        <h1>Pending Conflict Reports</h1>
        <div class="flex flex-row flex-wrap justify-evenly">
<?php
if ($result->num_rows > 0) {
  
    while($row = $result->fetch_assoc()): ?>

          <div class="px-8 pt-8">
            <h2 class="text-lg font-medium text-gray-700">Location: <?php echo $row["location"]; ?></h2>
            <p class="text-gray-600 mt-2">Issue: <?php echo $row["issue_description"]; ?> </p>
            <p class="text-gray-600 mt-2">Date Reported: <?php echo $row["date_reported"]; ?></p>
            <form action='resolve_report.php' method='post'>
            <input type='hidden' name='id' value=' <?php echo $row["id"]; ?>'>
            <button class="round-full outline outline-offset-2 outline-blue-500" type='submit' value='Mark as Resolved'>Mark as Resolved</button>
            </form>
          </div>

          <section class="flexbox-layout">
            <h2 class="section-title text-center">Report a Conflict</h2>
            <div class="flex-container">
            <form action= '<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>' method="post">
                <div class="flex-item">
                    <label for="location">Location:</label><br>
                    <input type="text" id="location" name="location" required><br>
                    <label for="issue_description">Issue Description:</label><br>
                    <textarea id="issue_description" name="issue_description" rows="4" cols="50" required></textarea><br>
                    <input type="submit" value="Submit Report">
                </div>
            </form>
            </div>
        </section>



          <?php endwhile;
      
    } else {
        echo "No pending reports.";
    }
    
    
    ?>
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

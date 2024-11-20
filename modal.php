<?php
require('config/config.php');

$sql = "SELECT * FROM conflict_reports WHERE status = 'pending'";
$counter = "SELECT * FROM conflict_reports WHERE status = 'pending'";
$result = $conn->query($sql);
// echo strval($result);
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
  <title>Issue Details</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <link rel= “manifest” href= “manifest.json” />
  <style>
    [x-cloak] {
      display: none;
    }
  </style>
</head>
<body class="bg-gray-100">

  <!-- Trigger Button -->
  <div class="flex justify-center mt-10">
    <button 
      id="viewDetailsButton" 
      class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 focus:outline-none focus:ring focus:ring-blue-300"
      onclick="showModal()">
      View Reported Issue
    </button>
  </div>

  <!-- Modal -->
  <div id="modal" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50 hidden">
    <div class="bg-white rounded-lg shadow-lg max-w-lg w-full p-6">
      <h2 class="text-xl font-bold text-gray-700 mb-4">Reported Issue Details</h2>
      <div class="space-y-2">
        <p><span class="font-medium text-gray-700">Location:</span> <span id="modal-location">---</span></p>
        <p><span class="font-medium text-gray-700">Description:</span></p>
        <p class="bg-gray-100 p-3 rounded-md text-gray-600" id="modal-description">---</p>
      </div>
      <div class="mt-6 flex justify-end space-x-4">
        <button 
          id="markResolvedButton"
          class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600 focus:outline-none focus:ring focus:ring-green-300"
          onclick="markAsResolved()">
          Mark as Resolved
        </button>
        <button 
          id="cancelButton"
          class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600 focus:outline-none focus:ring focus:ring-red-300"
          onclick="hideModal()">
          Cancel
        </button>
      </div>
    </div>
  </div>

  <!-- Scripts -->
  <script>
    // Sample issue data (fetch from backend in a real app)
    const issueData = {
      location: "Downtown Market",
      description: "There is a conflict reported regarding stall allocations leading to unrest among vendors."
    };

    function showModal() {
      // Populate modal with issue details
      document.getElementById("modal-location").textContent = issueData.location;
      document.getElementById("modal-description").textContent = issueData.description;

      // Show modal
      document.getElementById("modal").classList.remove("hidden");
    }

    function hideModal() {
      // Hide modal
      document.getElementById("modal").classList.add("hidden");
    }

    function markAsResolved() {
      // Handle marking the issue as resolved
      alert("The issue has been marked as resolved.");

      // Hide modal after marking resolved
      hideModal();
    }
  </script>
</body>
</html>

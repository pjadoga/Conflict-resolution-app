<?php

require 'vendor/autoload.php';

use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mime\Email;

// Database credentials
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "conflict_resolution";

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the input values
    $location = $_POST['location'];
    $issue_description = $_POST['issue_description'];

    // Prepare and bind
    $sql = "INSERT INTO conflict_reports (location, issue_description) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param("ss", $location, $issue_description);

    // Execute the statement
    if ($stmt->execute()) {
        echo "Report submitted successfully";
        notifyAuthorities($location, $issue_description);
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
}

// Close the connection
$conn->close();

// Function to notify authorities
function notifyAuthorities($location, $issue_description) {
    $transport = Transport::fromDsn('smtp://username:password@smtp.example.com:587'); // Use your SMTP server credentials
    $mailer = new Mailer($transport);

    $email = (new Email())
        ->from('noreply@conflictresolutionapp.com')
        ->to('authorities@example.com')
        ->subject("New Conflict Report in $location")
        ->text("A new conflict has been reported in $location. Issue description: $issue_description.");

    try {
        $mailer->send($email);
        echo "Notification sent to authorities.";
    } catch (Exception $e) {
        echo "Failed to send notification: " . $e->getMessage();
    }
}
?>

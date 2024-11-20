<?php

require 'vendor/autoload.php';

use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mime\Email;

// Database credentials
require('config/config.php');
// 

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the input values
    $fullname = $_POST['fullname'];
    $tel = $_POST['tel'];
    $location = $_POST['location'];
    $issue_description = $_POST['issue_description'];

    // Prepare and bind
    $sql = "INSERT INTO conflict_reports (fullname, tel, location, issue_description) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param("ss", $fullname, $tel, $location, $issue_description);

    // Execute the statement
    if ($stmt->execute()) {
        echo "Report submitted successfully";
        notifyAuthorities($location, $issue_description);
        echo notifyAuthorities($location, $issue_description);
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
    if(isset($_POST['submit'])){
        $to = "pj4just@gmail.com"; // this is your Email address
        // $from = $_POST['email']; // this is the sender's Email address
        $from = "noreply@conflictresolutionapp.com";
        // $first_name = $_POST['first_name'];
        // $last_name = $_POST['last_name'];
        $subject = "New Conflict Report in $location";
        // $subject2 = "Copy of your form submission";
        $message = "A new conflict has been reported in $location. Issue description: $issue_description.";
        // $message2 = "Here is a copy of your message " . $first_name . "\n\n" . $_POST['message'];
        $headers = "From:" . $from;
        // $headers2 = "From:" . $to;
        mail($to,$subject,$message,$headers);
        // mail($from,$subject2,$message2,$headers2); // sends a copy of the message to the sender
        echo "Mail Sent. Thank you, we will contact you shortly.";
        // You can also use header('Location: thank_you.php'); to redirect to another page.
        }








    // $transport = Transport::fromDsn('smtp://pj4just@gmail.com:08024702539@smtp.gmail.com:587'); // Use your SMTP server credentials
    // $mailer = new Mailer($transport);

    // $email = (new Email())
    //     ->from('noreply@conflictresolutionapp.com')
    //     ->to('justinadoga@gmail.com')
    //     ->subject("New Conflict Report in $location")
    //     ->text("A new conflict has been reported in $location. Issue description: $issue_description.");

    // try {
    //     $mailer->send($email);
    //     echo "Notification sent to authorities.";
    // } catch (Exception $e) {
    //     echo "Failed to send notification: " . $e->getMessage();
    // }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <title>Conflict Report Form</title>
    <link rel="stylesheet" href="styles.css">
    <link rel= “manifest” href= “manifest.json” />
</head>
<body>
    <header>
        <h1 id="main-title">Conflict Report Portal</h1>
    </header>
    <nav>
        <ul class="nav-list">
            <li><a href="#">Home</a></li>
            <li><a href="#">About</a></li>
            <li><a href="#">Services</a></li>
            <li><a href="#">Contact</a></li>
        </ul>
    </nav>
    <main class="content">
        <section class="flexbox-layout">
            <h2 class="section-title text-center">Report a Conflict</h2>
            <form action= '<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>' method="post">
                <div class="form-group">
                    <label for="fullname">Name(Optional):</label>
                    <input type="text" id="fullname" name="fullname" placeholder="Full Name">
                </div>
                <div class="form-group">
                    <label for="location">Phone Number(Optional):</label>
                    <input type="tel" id="tel" name="tel" placeholder="080***">
                </div>
                <div class="form-group">
                    <label for="location">*Location:</label>
                    <input type="text" id="location" name="location" placeholder="Provide details of the location" required>
                </div>
                <div class="form-group">
                    <label for="issue_description">*Issue Description:</label>
                    <textarea id="issue_description" name="issue_description" required placeholder="Give us detail description" rows="10" cols="150"></textarea>
                </div>
                <button type="submit">Submit Report</button>
            </form>
        </section>       
    </main>
    <footer>
        <p>&copy; 2024 Conflict Report Portal</p>
    </footer>
    <script src="scripts.js"></script>
</body>
</html>

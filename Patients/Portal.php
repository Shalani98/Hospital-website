<?php
session_start();
// Check if the user is logged in
if (!isset($_SESSION['user']['loggedin']) || $_SESSION['user']['loggedin'] !== true) {
    header('Location: login.php');
    exit();
}

$current_user_id = $_SESSION['user']['id']; // Define the current_user_id based on the session data

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Portal</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            background-image: url('../src/portal.jpg'); /* Set the background image */
            background-size: cover; /* Make the image cover the entire background */
            background-position: center; /* Center the image */
            background-repeat: no-repeat; 
        }

        .header {
            background-color:rgba(0, 0, 0, 0.1);
            color: white;
            padding: 15px;
            text-align: center;
        }

        .container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.8); /* Semi-transparent white background */
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .section {
            margin-bottom: 30px;
        }

        .section h2 {
            color: #017d73;
            margin-bottom: 15px;
        }

        .section ul {
            list-style: none;
            padding-left: 0;
        }

        .section ul li {
            margin-bottom: 12px;
        }

        .section ul li a {
            text-decoration: none;
            color: #017d73;
            font-size: 16px;
        }

        .section ul li a:hover {
            text-decoration: underline;
        }

        .action-button {
            background-color: #017d73;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            text-align: center;
            display: inline-block;
            width: 200px;
            margin-top: 10px;
            cursor: pointer;
        }

        .action-button:hover {
            background-color: #005e57;
        }
         /* Footer styles */
         footer {
            background-color: #444; /* Dark shade */
            color: white;
            text-align: center;
            padding: 20px;
            margin-top: 40px;
        }
    </style>
</head>
<body>

    <header class="header">
        <h1>Welcome to the Patient Portal</h1>
        <h1><a href="logout.php" style="color: white;">Log out</a></h1>
    </header>

    <div class="container">
        <!-- Account Management Section -->
        <section class="section">
            <h2>Account Management</h2>
            <ul>
                <li><a href="Patients.php">Register and manage your account details</a></li>
                <li><a href="Patients.php">Login securely to the patient portal</a></li>
            </ul>
        </section>

        <!-- Medical Records Section -->
        <section class="section">
            <h2>Medical Records, lab results, and appointment history</h2>
            <ul>
                <li><a href="Medicalrecords.php">Medical records</a></li>
                <li><a href="Labresults.php?id=<?php echo htmlspecialchars($current_user_id); ?>">Lab results</a></li>
                
            </ul>
        </section>

        <!-- Appointment Scheduling Section -->
        <section class="section">
            <h2>Appointment Scheduling</h2>
            <ul>
                <li><a href="BookAppointment.php">Book, reschedule, or cancel appointments</a></li>
                <li><a href="Appointmenthistory.php">Appointment history</a></li>
              
            </ul>
        </section>

        <!-- Bill Payments Section -->
        <section class="section">
            <h2>Bill Payments</h2>
            <ul>
                <li><a href="Display.php">Register for services & Pay bills online securely</a></li>
                <li><a href="download.php">View and download billing statements</a></li>
            </ul>
        </section>

        <!-- Communication Section -->
        <section class="section">
            <h2>Communication</h2>
            <ul>
                <li><a href="query.php">Submit queries regarding medical services and tests</a></li>
                <li><a href="feedback.php">Provide feedback and reviews on services received</a></li>
            </ul>
        </section>

      
    </div>

</body>
<footer>
        <p>&copy; 2025 CareCompass Hospital. All Rights Reserved.</p>
    </footer>
</html>

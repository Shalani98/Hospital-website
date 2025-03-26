<?php
// Start the session to access user-specific data
session_start();

// Include the database connection
require_once('../dataconnect.php');

// Ensure the user is logged in
if (!isset($_SESSION['user']['loggedin']) || $_SESSION['user']['loggedin'] != 1) {
    // Redirect to login if user is not logged in
    header('Location: ../login.php'); // Adjust path to your login page
    exit();
}

// Fetch the logged-in user's ID from the session
$user_id = intval($_SESSION['user']['id']); // Sanitize the user ID

// Check if form data is posted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the test IDs and total price from the POST request
    $test_ids = explode(',', $_POST['tests']);
    $total_price = floatval($_POST['total_price']); // Convert total price to float
    
    // Iterate through the selected test IDs and register them
    foreach ($test_ids as $test_id) {
        $test_id = intval($test_id); // Sanitize test ID
        
        // SQL query to insert registration into database
        $sql = "INSERT INTO test_registrations (user_id, test_id, payment_status, price) 
                VALUES ($user_id, $test_id, 'Completed', $total_price)";
        
        // Execute query and check for errors
        if (!mysqli_query($conp, $sql)) {
            die("Error registering test ID $test_id: " . mysqli_error($conp));
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Success</title>
    <style>
        /* Basic Styling */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f7f7f7;
            margin: 0;
            padding: 0;
            color: #333;
            display: flex;
            flex-direction: column;
            height: 100vh;
        }

        /* Center the container */
        .container {
            max-width: 800px;
            margin: 50px auto;
            padding: 30px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            text-align: center;
            flex-grow: 1; /* Allow the content area to take up remaining space */
        }

        h1 {
            color: #27ae60;
            font-size: 2.5em;
            margin-bottom: 20px;
        }

        p {
            font-size: 1.2em;
            color: #555;
        }

        a {
            display: inline-block;
            margin-top: 30px;
            padding: 12px 25px;
            font-size: 1em;
            text-decoration: none;
            color: white;
            background-color: #3498db;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        a:hover {
            background-color: #2980b9;
        }

        /* Footer styles */
        footer {
            background-color: #444;
            color: white;
            text-align: center;
            padding: 20px;
            font-size: 0.9em;
            margin-top: 40px;
        }

        footer a {
            color: #3498db;
        }

        footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <div class="container">
        <h1>Payment Successful!</h1>
        <p>Your registration for the selected tests has been successfully completed.</p>
        <a href="Display.php">Go back to test selection</a> <!-- Redirect back to test selection page -->
    </div>

    <footer>
        <p>&copy; 2025 Your Hospital. All rights reserved.</p>
    </footer>

</body>
</html>

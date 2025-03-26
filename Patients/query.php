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

// Initialize a  alert message variable

$alert_message = "";

// Check if form data is posted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the query from the POST request
    $query_text = trim($_POST['query']);
    
    // Validate the input
    if (empty($query_text)) {
        $message = "Query cannot be empty.";
    } else {
        // Sanitize the query input
        $query_text = mysqli_real_escape_string($conp, $query_text);

        // SQL query to insert the user query into the database
        $sql = "INSERT INTO user_queries (user_id, query_text) VALUES ($user_id, '$query_text')";
        
        // Execute query and check for errors
        if (mysqli_query($conp, $sql)) {
         
            $alert_message = "Query submitted successfully.";
        } else {
           
            $alert_message = "Error submitting query: " . mysqli_error($conp);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit Query</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        .container {
            background-color: #ffffff;
            margin: 50px auto;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 600px;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        label {
            font-weight: bold;
            margin-bottom: 5px;
        }
        textarea {
            margin-bottom: 20px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            resize: vertical;
            font-size: 16px;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
        .message {
            text-align: center;
            margin-bottom: 20px;
        }
        .back-link {
            text-align: center;
            margin-top: 20px;
        }
        .back-link a {
            text-decoration: none;
            color: #4CAF50;
            font-weight: bold;
        }
        .back-link a:hover {
            text-decoration: underline;
        }
        footer {
            background-color: #333;
            color: white;
            text-align: center;
            padding: 10px;
            position: absolute;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Submit Your Query</h1>
        <?php if (!empty($message)): ?>
            <p class="message"><?= htmlspecialchars($message) ?></p>
        <?php endif; ?>
        <form action="query.php" method="post">
            <label for="query">Your Query:</label>
            <textarea id="query" name="query" rows="4" cols="50" required></textarea>
            <input type="submit" value="Submit Query">
        </form>
        <div class="back-link">
            <a href="Bill.php">Go back to the previous page</a>
        </div>
    </div>
    <footer>
        &copy; <?= date("Y") ?> Hospital Administration. All rights reserved.
    </footer>
    <?php if (!empty($alert_message)): ?>
        <script>
            alert('<?= htmlspecialchars($alert_message) ?>');
        </script>
    <?php endif; ?>
</body>
</html>
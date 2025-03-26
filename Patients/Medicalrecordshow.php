<?php
require_once('../dataconnect.php');
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user']['loggedin']) || $_SESSION['user']['loggedin'] !== true) {
    header('Location: login.php');
    exit;
}

$current_user_id = $_SESSION['user']['id']; // Assuming you store the user's ID in the session upon login

// Check if 'id' parameter is set and is a numeric value
if (isset($_GET['id'])) {
    $requested_id = $_GET['id'];
    if (is_numeric($requested_id)) {
        $requested_id = mysqli_real_escape_string($conp, $requested_id);

        // Query to fetch the required fields from the medicalrecordshow table using id
        if ($requested_id == $current_user_id) {
            $query = "SELECT id, test_id, record_id, date, staff_id, records FROM medicalrecordshow WHERE id = '$requested_id'";
            $result = mysqli_query($conp, $query);

            if ($result) {
                if (mysqli_num_rows($result) > 0) {
                    $record = mysqli_fetch_assoc($result);
                } else {
                    echo "No records found for this patient.";
                    exit;
                }
            } else {
                die("Error fetching medical records: " . mysqli_error($conp) . " - Actual Query: " . $query);
            }
        } else {
            echo "Unauthorized access to this record.";
            exit;
        }
    } else {
        echo "Invalid or missing ID parameter.";
        exit;
    }
} else {
    echo "Invalid or missing ID parameter.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medical Records - <?php echo htmlspecialchars($requested_id); ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }

        main {
            max-width: 600px;
            margin: 0 auto;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .patient-details {
            margin-top: 20px;
        }

        .patient-details h3 {
            margin-bottom: 10px;
        }

        .patient-details p {
            margin-bottom: 10px;
        }

        .back-button {
            text-align: center;
            margin-top: 20px;
        }

        .back-button a {
            text-decoration: none;
            background-color: #017d73;
            color: white;
            padding: 10px 20px;
            border-radius: 4px;
        }

        .back-button a:hover {
            background-color: #005e57;
        }
    </style>
</head>
<body>
<main>
    <h2>Medical Records - <?php echo htmlspecialchars($requested_id); ?></h2>

    <div class="patient-details">
        <h3>ID:</h3>
        <p><?php echo isset($record['id']) ? htmlspecialchars($record['id']) : 'No ID available'; ?></p>

        <h3>Test ID:</h3>
        <p><?php echo isset($record['test_id']) ? htmlspecialchars($record['test_id']) : 'No Test ID available'; ?></p>

        <h3>Record ID:</h3>
        <p><?php echo isset($record['record_id']) ? htmlspecialchars($record['record_id']) : 'No Record ID available'; ?></p>

        <h3>Date:</h3>
        <p><?php echo isset($record['date']) ? htmlspecialchars($record['date']) : 'No Date available'; ?></p>

        <h3>Staff ID:</h3>
        <p><?php echo isset($record['staff_id']) ? htmlspecialchars($record['staff_id']) : 'No Staff ID available'; ?></p>

        <h3>Records:</h3>
        <p><?php echo isset($record['records']) ? htmlspecialchars($record['records']) : 'No Records available'; ?></p>
    </div>

    <div class="back-button">
        <a href="medicalrecords.php">Back to Patients List</a>
    </div>
</main>
</body>
</html>
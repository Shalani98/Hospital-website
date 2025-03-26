<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
if (!isset($_SESSION['user']['loggedin']) || $_SESSION['user']['loggedin'] !== true) {
    header("Location: login.php");
    exit();
}

require_once('../dataconnect.php');

// Selecting correct database
mysqli_select_db($conp, 'care_compass_hospitals');

// Check if the connection is successful
if (!$conp) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Fetch the appointment with appointment_id 
$rest_list = "";
$appointmentsQuery = "
    SELECT 
        a.appointment_id, 
        a.user_id, 
        a.id, 
        a.date, 
        a.start_time, 
        a.end_time, 
        a.status
    FROM 
        appointments a
   
";

$appointmentsResult = mysqli_query($conp, $appointmentsQuery);

if (!$appointmentsResult) {
    die("Error fetching appointments: " . mysqli_error($conp));
}

while ($row = mysqli_fetch_assoc($appointmentsResult)) {
    $rest_list .= "<tr>";
    $rest_list .= "<td>" . htmlspecialchars($row['appointment_id']) . "</td>";
    $rest_list .= "<td>" . htmlspecialchars($row['user_id']) . "</td>";
    $rest_list .= "<td>" . htmlspecialchars($row['id']) . "</td>";
    $rest_list .= "<td>" . htmlspecialchars($row['date']) . "</td>";
    $rest_list .= "<td>" . htmlspecialchars($row['start_time']) . "</td>";
    $rest_list .= "<td>" . htmlspecialchars($row['end_time']) . "</td>";
    $rest_list .= "<td>" . htmlspecialchars($row['status']) . "</td>";
    $rest_list .= "</tr>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment History</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }
        .container {
            width: 100%;
            max-width: none;
            margin: 0 auto;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow-x: auto;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #017d73;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Appointment History</h2>
    <table>
        <thead>
            <tr>
                <th>Appointment ID</th>
                <th>Doctor ID</th>
                <th>Patient ID</th>
                <th>Date</th>
                <th>Start Time</th>
                <th>End Time</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php echo $rest_list; ?>
        </tbody>
    </table>
</div>
</body>
</html>

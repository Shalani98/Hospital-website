<?php
// Include the database connection
require_once('../dataconnect.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['doctor_id']) && isset($_POST['patient_id']) && isset($_POST['date']) && isset($_POST['time']) && isset($_POST['price']) && isset($_POST['status'])) {
    $doctor_id = intval($_POST['doctor_id']); // input sanitizing
    $patient_id = intval($_POST['patient_id']); // input sanitizing
    $date = $_POST['date'];
    $time = $_POST['time'];
    $price = floatval($_POST['price']);
    $status = $_POST['status'];

    //  Insert the appointment into the database
    $sql = "INSERT INTO appointments (doctor_id, patient_id, date, time, price, status) VALUES ($doctor_id, $patient_id, '$date', '$time', $price, '$status')";
    if (mysqli_query($conp, $sql)) {
        $message = "<h1>Payment Successful</h1>
                    <p>Your payment of $" . htmlspecialchars($price) . " has been processed successfully.</p>
                    <p>Appointment booked with Dr. on " . htmlspecialchars($date) . " at " . htmlspecialchars($time) . ".</p>";
    } else {
        $message = "<h1>Error</h1>
                    <p>There was an error processing your payment. Please try again.</p>";
    }
} else {
    $message = "<h1>Error</h1>
                <p>Invalid appointment details.</p>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Status</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }
        .container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        h1 {
            color: #017d73;
            margin-bottom: 20px;
        }
        p {
            font-size: 18px;
            margin-bottom: 20px;
        }
        .back-button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #017d73;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
        }
        .back-button:hover {
            background-color: #005e57;
        }
    </style>
</head>
<body>
    <div class="container">
        <?= $message ?>
        <a href="register.php" class="back-button">Back to Booking</a>
    </div>
</body>
</html>
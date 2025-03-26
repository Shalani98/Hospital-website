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

if (!$conp) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Variable initializing
$doctorAppointments = [];
$logged_in_user_id = $_SESSION['user']['id'];
$is_doctor = false;
$doctorPrice = 0; // Default price

// Check if the logged-in user is a doctor
$doctorCheckQuery = $conp->prepare("SELECT * FROM staff WHERE user_id = ? AND role = 'Doctor' AND specialization IS NOT NULL");
$doctorCheckQuery->bind_param("i", $logged_in_user_id);
$doctorCheckQuery->execute();
$doctorCheckResult = $doctorCheckQuery->get_result();

if ($doctorCheckResult && $doctorCheckResult->num_rows > 0) {
    $is_doctor = true;

    // Fetch the doctor's price
    $doctorData = $doctorCheckResult->fetch_assoc();
    $doctorPrice = $doctorData['price']; // Get the doctor's price

    // Fetch appointments for the logged-in doctor
    $appointmentsQuery = $conp->prepare("SELECT * FROM appointments WHERE user_id = ?");
    $appointmentsQuery->bind_param("i", $logged_in_user_id);
    $appointmentsQuery->execute();
    $appointmentsResult = $appointmentsQuery->get_result();

    while ($row = $appointmentsResult->fetch_assoc()) {
        $doctorAppointments[] = $row;
    }
}

// Fetch doctors by role "Doctor" and specialization, along with price
$specializationsQuery = $conp->prepare("SELECT user_id, first_name, last_name, specialization, price FROM staff WHERE role = 'Doctor' AND specialization IS NOT NULL");
$specializationsQuery->execute();
$specializationsResult = $specializationsQuery->get_result();

// Fetch time slots from time.json
$timeSlots = [];
$timeFile = './time.json';
if (file_exists($timeFile)) {
    $timeData = file_get_contents($timeFile);
    $timeSlots = json_decode($timeData, true)['time'] ?? [];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'] ?? '';
    $appointment_id = $_POST['appointment_id'] ?? null;
    $doctor_id = $conp->real_escape_string($_POST['doctor_id'] ?? '');
    $date = $conp->real_escape_string($_POST['date'] ?? '');
    $time = $conp->real_escape_string($_POST['time'] ?? '');
    $status = $conp->real_escape_string($_POST['status'] ?? '');

    if ($action === 'book') {
        // Extract start_time and end_time from the selected time slot
        list($start_time, $end_time) = explode(' - ', $time);

        // Check if the doctor is already booked for the selected date and time
        $checkQuery = $conp->prepare("SELECT * FROM appointments WHERE user_id = ? AND date = ? AND start_time = ?");
        $checkQuery->bind_param("iss", $doctor_id, $date, $start_time);
        $checkQuery->execute();
        $checkResult = $checkQuery->get_result();

        if ($checkResult->num_rows > 0) {
            echo "<script>alert('This time slot is already booked for the selected doctor. Please choose another time.');</script>";
        } else {
            // Insert appointment 
            $insertQuery = $conp->prepare("INSERT INTO appointments (user_id, id, date, start_time, end_time, status) VALUES (?, ?, ?, ?, ?, ?)");
            $insertQuery->bind_param("iissss", $doctor_id, $logged_in_user_id, $date, $start_time, $end_time, $status);
            
            if ($insertQuery->execute()) {
                echo "<script>alert('Appointment booked successfully!'); window.location.href='doctorbill.php';</script>";
            } else {
                echo "<script>alert('Error booking appointment: " . $conp->error . "');</script>";
            }
        }
    } 
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Doctor Profiles</title>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
</head>
<style>
/* Your existing CSS styles */
body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    padding: 20px;
}

.container {
    width: 100%;
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

.appointment-form {
    margin-top: 20px;
    padding: 20px;
    border: 1px solid #ddd;
    border-radius: 8px;
    background-color: #f9f9f9;
}

.appointment-form label {
    display: block;
    margin-bottom: 8px;
}

.appointment-form input, .appointment-form select {
    width: 100%;
    padding: 10px;
    margin-bottom: 15px;
    border-radius: 4px;
    border: 1px solid #ddd;
}

.appointment-form button {
    width: 100%;
    padding: 12px;
    background-color: #017d73;
    color: white;
    font-size: 16px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

.appointment-form button:hover {
    background-color: #005e57;
}
</style>
<body>

<div class="appointment-form">
<h2>Book Appointment</h2>
<form method="POST" action="">
<input type="hidden" name="action" value="book">

<label for="doctor_id">Doctors</label>
<select name="doctor_id" id="doctor_id" required>
<option value="">Select Doctor</option>
<?php
while ($row = $specializationsResult->fetch_assoc()) {
    echo "<option value='{$row['user_id']}'>
            {$row['first_name']} {$row['last_name']} - {$row['specialization']} 
            ({$row['price']} LKR)</option>";
}
?>
</select>

<label for="date">Date:</label>
<input type="date" name="date" id="date" required>

<label for="time">Time:</label>
<select name="time" id="time" required>
<option value="">Choose a time</option>
<?php foreach ($timeSlots as $slot): ?>
<option value="<?= "{$slot['start_time']} - {$slot['end_time']}" ?>">
<?= "{$slot['start_time']} - {$slot['end_time']} ({$slot['status']})" ?>
</option>
<?php endforeach; ?>
</select>

<label for="status">Status:</label>
<select name="status" id="status" required>
<option value="Scheduled">Scheduled</option>
</select>

<button type="submit">Book Appointment</button>
</form>
</div>

</body>
</html>

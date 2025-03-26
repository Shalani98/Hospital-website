<?php
// Simulating user role; in real apps, fetch from session or database.
$role = isset($_GET['role']) ? $_GET['role'] : null;

// Include dashboard content based on role
function get_dashboard_content($role) {
    switch ($role) {
        case 'doctor':
            include 'doctor_dashboard.php';
            break;
        case 'lab_technician':
            include 'labtechnician_dashboard.php';
            break;
        case 'nurse':
            include 'nurse_dashboard.php';
            break;
        default:
            echo "<p>Please select a role to view the dashboard.</p>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        header, footer {
            background-color: #333;
            color: white;
            text-align: center;
            padding: 10px 0;
        }
        .navigation {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin: 20px 0;
        }
        .navigation a {
            text-decoration: none;
            padding: 10px 15px;
            background-color: #444;
            color: white;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }
        .navigation a:hover {
            background-color: #555;
        }
        .dashboard-content {
            max-width: 1200px;
            margin: auto;
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <header>
        <h1>Staff Dashboard</h1>
    </header>
<nav class=
    <nav class="navigation">
        <a href="staff_dashboard.php?role=doctor">Doctor</a>
        <a href="staff_dashboard.php?role=lab_technician">Lab Technician</a>
        <a href="staff_dashboard.php?role=nurse">Nurse</a>
    </nav>

    <div class="dashboard-content">
        <?php get_dashboard_content($role); ?>
    </div>

    <footer>
        <p>&copy; 2024 CareCompass Hospital. All Rights Reserved.</p>
    </footer>
</body>
</html>

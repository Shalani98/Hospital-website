<?php
session_start();
// Check if the user is logged in
if (!isset($_SESSION['user']['loggedin']) || $_SESSION['user']['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}

require_once('../dataconnect.php');

// Fetch doctors from the staff table where specialization is not null
$doctorsQuery = "SELECT s.staff_id, s.user_id, s.first_name, s.last_name, s.specialization, s.department, s.phone_extension, s.shift, u.email, u.contactno, u.address, u.registration_date 
                 FROM staff s 
                 JOIN users u ON s.user_id = u.user_id 
                 WHERE s.specialization IS NOT NULL";
$doctorsResult = mysqli_query($conp, $doctorsQuery);

if (!$doctorsResult) {
    die("Error fetching doctors: " . mysqli_error($conp));
}

$doctors = [];
while ($row = mysqli_fetch_assoc($doctorsResult)) {
    $doctors[] = $row;
}

// Fetch staff members from the staff table where specialization is null
$staffQuery = "SELECT s.staff_id, s.user_id, s.first_name, s.last_name, s.department, s.phone_extension, s.shift, u.email, u.contactno, u.address, u.registration_date 
               FROM staff s 
               JOIN users u ON s.user_id = u.user_id 
               WHERE s.specialization IS NULL";
$staffResult = mysqli_query($conp, $staffQuery);

if (!$staffResult) {
    die("Error fetching staff: " . mysqli_error($conp));
}

$staff = [];
while ($row = mysqli_fetch_assoc($staffResult)) {
    $staff[] = $row;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff List</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
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
        .action-link {
            text-decoration: none;
            color: #017d73;
        }
        .action-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Doctors List</h2>
    <table>
        <thead>
            <tr>
                <th>Staff ID</th>
                <th>User ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Specialization</th>
                <th>Department</th>
                <th>Phone Extension</th>
                <th>Shift</th>
                <th>Email</th>
                <th>Phone Number</th>
                <th>Address</th>
                <th>Registration Date</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($doctors as $doctor): ?>
                <tr>
                    <td><?php echo htmlspecialchars($doctor['staff_id']); ?></td>
                    <td><?php echo htmlspecialchars($doctor['user_id']); ?></td>
                    <td><?php echo htmlspecialchars($doctor['first_name']); ?></td>
                    <td><?php echo htmlspecialchars($doctor['last_name']); ?></td>
                    <td><?php echo htmlspecialchars($doctor['specialization']); ?></td>
                    <td><?php echo htmlspecialchars($doctor['department']); ?></td>
                    <td><?php echo htmlspecialchars($doctor['phone_extension']); ?></td>
                    <td><?php echo htmlspecialchars($doctor['shift']); ?></td>
                    <td><?php echo htmlspecialchars($doctor['email']); ?></td>
                    <td><?php echo htmlspecialchars($doctor['contactno']); ?></td>
                    <td><?php echo htmlspecialchars($doctor['address']); ?></td>
                    <td><?php echo htmlspecialchars($doctor['registration_date']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <h2>Staff List</h2>
    <table>
        <thead>
            <tr>
                <th>Staff ID</th>
                <th>User ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Department</th>
                <th>Phone Extension</th>
                <th>Shift</th>
                <th>Email</th>
                <th>Phone Number</th>
                <th>Address</th>
                <th>Registration Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($staff as $staffMember): ?>
                <tr>
                    <td><?php echo htmlspecialchars($staffMember['staff_id']); ?></td>
                    <td><?php echo htmlspecialchars($staffMember['user_id']); ?></td>
                    <td><?php echo htmlspecialchars($staffMember['first_name']); ?></td>
                    <td><?php echo htmlspecialchars($staffMember['last_name']); ?></td>
                    <td><?php echo htmlspecialchars($staffMember['department']); ?></td>
                    <td><?php echo htmlspecialchars($staffMember['phone_extension']); ?></td>
                    <td><?php echo htmlspecialchars($staffMember['shift']); ?></td>
                    <td><?php echo htmlspecialchars($staffMember['email']); ?></td>
                    <td><?php echo htmlspecialchars($staffMember['contactno']); ?></td>
                    <td><?php echo htmlspecialchars($staffMember['address']); ?></td>
                    <td><?php echo htmlspecialchars($staffMember['registration_date']); ?></td>
                    <td><a class="action-link" href="Labresults.php?staff_id=<?php echo htmlspecialchars($staffMember['user_id']); ?>">Record Lab Results</a></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>
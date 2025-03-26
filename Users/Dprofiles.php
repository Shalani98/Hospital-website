<?php
require_once('../dataconnect.php'); // Ensure this file contains the correct database connection details

// Handle search and filter
$filters = ["specialization IS NOT NULL"];

if (isset($_GET['specialization']) && !empty($_GET['specialization'])) {
    $filters[] = "specialization = '" . mysqli_real_escape_string($conp, $_GET['specialization']) . "'";
}
if (isset($_GET['location']) && !empty($_GET['location'])) {
    $filters[] = "address LIKE '%" . mysqli_real_escape_string($conp, $_GET['location']) . "%'";
}
if (isset($_GET['availability']) && !empty($_GET['availability'])) {
    $filters[] = "shift = '" . mysqli_real_escape_string($conp, $_GET['availability']) . "'";
}
if (isset($_GET['qualifications']) && !empty($_GET['qualifications'])) {
    $filters[] = "qualifications LIKE '%" . mysqli_real_escape_string($conp, $_GET['qualifications']) . "%'";
}
if (isset($_GET['contact']) && !empty($_GET['contact'])) {
    $filters[] = "contactno LIKE '%" . mysqli_real_escape_string($conp, $_GET['contact']) . "%'";
}

$searchQuery = implode(" AND ", $filters);

// Fetch doctors from the staff table where specialization is not null
$doctorsQuery = "SELECT staff_id, user_id, first_name, last_name, specialization, department, phone_extension, shift, email, phone_number, address, registration_date, qualifications
                 FROM staff 
                 WHERE $searchQuery";
$doctorsResult = mysqli_query($conp, $doctorsQuery);

if (!$doctorsResult) {
    die("Error fetching doctors: " . mysqli_error($conp));
}

$doctors = [];
while ($row = mysqli_fetch_assoc($doctorsResult)) {
    $doctors[] = $row;
}

// Handle form submission for updating doctor details
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['staff_id'])) {
    // Sanitize the form data to avoid SQL injection
    $first_name = mysqli_real_escape_string($conp, $_POST['first_name']);
    $last_name = mysqli_real_escape_string($conp, $_POST['last_name']);
    $specialization = mysqli_real_escape_string($conp, $_POST['specialization']);
    $department = mysqli_real_escape_string($conp, $_POST['department']);
    $phone_extension = mysqli_real_escape_string($conp, $_POST['phone_extension']);
    $shift = mysqli_real_escape_string($conp, $_POST['shift']);
    $email = mysqli_real_escape_string($conp, $_POST['email']);
    $phone_number = mysqli_real_escape_string($conp, $_POST['phone_number']);
    $address = mysqli_real_escape_string($conp, $_POST['address']);
    $registration_date = mysqli_real_escape_string($conp, $_POST['registration_date']);
    $qualifications = mysqli_real_escape_string($conp, $_POST['qualifications']);
    $staff_id = mysqli_real_escape_string($conp, $_POST['staff_id']);

    // Prepared statement to update doctor details
    $updateQuery = "UPDATE staff 
                    SET first_name = '$first_name', last_name = '$last_name', specialization = '$specialization', 
                        department = '$department', phone_extension = '$phone_extension', shift = '$shift', 
                        email = '$email', phone_number = '$phone_number', address = '$address', 
                        registration_date = '$registration_date', qualifications = '$qualifications' 
                    WHERE staff_id = '$staff_id'";

    if (mysqli_query($conp, $updateQuery)) {
        echo "Doctor details updated successfully.";
    } else {
        echo "Error updating doctor details: " . mysqli_error($conp);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Profiles</title>
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
        .action-link {
            text-decoration: none;
            color: #017d73;
        }
        .action-link:hover {
            text-decoration: underline;
        }
        .filter-form {
            margin-bottom: 20px;
        }
        .filter-form label {
            margin-right: 10px;
        }
        .filter-form input, .filter-form select {
            margin-right: 20px;
            padding: 5px;
        }
        .filter-form button {
            padding: 5px 10px;
            background-color: #017d73;
            color: white;
            border: none;
            cursor: pointer;
        }
        .filter-form button:hover {
            background-color: #005e57;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Search and Filter Doctors</h2>
    <form class="filter-form" method="get" action="">
        <label for="specialization">Specialty:</label>
        <input type="text" name="specialization" id="specialization">
        <label for="address">Address:</label>
        <input type="text" name="address" id="address">
        <label for="availability">Availability:</label>
        <input type="text" name="availability" id="availability">
        <label for="qualifications">Qualifications:</label>
        <input type="text" name="qualifications" id="qualifications">
        
        
        
        <button type="submit">Search</button>
    </form>

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
                <th>Qualifications</th>
                <th>Actions</th>
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
                    <td><?php echo htmlspecialchars($doctor['phone_number']); ?></td>
                    <td><?php echo htmlspecialchars($doctor['address']); ?></td>
                    <td><?php echo htmlspecialchars($doctor['registration_date']); ?></td>
                    <td><?php echo htmlspecialchars($doctor['qualifications']); ?></td>
                    <td><a class="action-link" href="edit_doctor.php?staff_id=<?php echo htmlspecialchars($doctor['staff_id']); ?>">Edit</a></td>
                    
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>
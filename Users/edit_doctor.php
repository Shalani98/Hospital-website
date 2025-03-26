<?php
require_once('../dataconnect.php'); // Ensure this file contains the correct database connection details

// Fetch doctor's data when editing
if (isset($_GET['staff_id'])) {
    $staff_id = mysqli_real_escape_string($conp, $_GET['staff_id']);
    
    // Check if the staff_id is passed correctly
    if (empty($staff_id)) {
        die("Staff ID is missing.");
    }
    
    // Fetch the doctor's details from the database
    $doctorQuery = "SELECT staff_id, user_id, first_name, last_name, specialization, department, phone_extension, shift, email, phone_number, address, registration_date, qualifications
                    FROM staff WHERE staff_id = '$staff_id' LIMIT 1";
    
    $doctorResult = mysqli_query($conp, $doctorQuery);
    
    if ($doctorResult) {
        $doctor = mysqli_fetch_assoc($doctorResult);
        
        if (!$doctor) {
            die("No doctor found with the given staff_id.");
        }
    } else {
        die("Error fetching doctor details: " . mysqli_error($conp));
    }
} else {
    die("No staff ID provided.");
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
                    SET first_name = ?, last_name = ?, specialization = ?, 
                        department = ?, phone_extension = ?, shift = ?, 
                        email = ?, phone_number = ?, address = ?, 
                        registration_date = ?, qualifications = ? 
                    WHERE staff_id = ?";

    if ($stmt = mysqli_prepare($conp, $updateQuery)) {
        mysqli_stmt_bind_param($stmt, "sssssssssssi", $first_name, $last_name, $specialization, 
            $department, $phone_extension, $shift, $email, $phone_number, $address, 
            $registration_date, $qualifications, $staff_id);
        
        if (mysqli_stmt_execute($stmt)) {
            echo "Doctor details updated successfully.";
        } else {
            echo "Error updating doctor details: " . mysqli_error($conp);
        }
        mysqli_stmt_close($stmt);
    } else {
        echo "Prepared statement error: " . mysqli_error($conp);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Doctor</title>
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
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        label {
            margin-bottom: 5px;
            font-weight: bold;
        }
        input {
            margin-bottom: 15px;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        button {
            padding: 10px;
            font-size: 16px;
            background-color: #017d73;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #005e57;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Edit Doctor Details</h2>
        <?php if (isset($doctor) && $doctor) : ?>
        <form method="POST" action="">
            <input type="hidden" name="staff_id" value="<?php echo htmlspecialchars($doctor['staff_id']); ?>">
            <label for="first_name">First Name:</label>
            <input type="text" name="first_name" id="first_name" value="<?php echo htmlspecialchars($doctor['first_name']); ?>">
            <label for="last_name">Last Name:</label>
            <input type="text" name="last_name" id="last_name" value="<?php echo htmlspecialchars($doctor['last_name']); ?>">
            <label for="specialization">Specialization:</label>
            <input type="text" name="specialization" id="specialization" value="<?php echo htmlspecialchars($doctor['specialization']); ?>">
            <label for="department">Department:</label>
            <input type="text" name="department" id="department" value="<?php echo htmlspecialchars($doctor['department']); ?>">
            <label for="phone_extension">Phone Extension:</label>
            <input type="text" name="phone_extension" id="phone_extension" value="<?php echo htmlspecialchars($doctor['phone_extension']); ?>">
            <label for="shift">Shift:</label>
            <input type="text" name="shift" id="shift" value="<?php echo htmlspecialchars($doctor['shift']); ?>">
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($doctor['email']); ?>">
            <label for="phone_number">Phone Number:</label>
            <input type="text" name="phone_number" id="phone_number" value="<?php echo htmlspecialchars($doctor['phone_number']); ?>">
            <label for="address">Address:</label>
            <input type="text" name="address" id="address" value="<?php echo htmlspecialchars($doctor['address']); ?>">
            <label for="registration_date">Registration Date:</label>
            <input type="date" name="registration_date" id="registration_date" value="<?php echo htmlspecialchars($doctor['registration_date']); ?>">
            <label for="qualifications">Qualifications:</label>
            <input type="text" name="qualifications" id="qualifications" value="<?php echo htmlspecialchars($doctor['qualifications']); ?>">
            <button type="submit">Update Doctor</button>
        </form>
        <?php else : ?>
            <p>Doctor not found or invalid staff ID.</p>
        <?php endif; ?>
        <a href="index_doctors.php">Back to Doctor List</a>
    </div>
</body>
</html>
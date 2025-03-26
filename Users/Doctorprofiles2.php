<?php
require_once('../dataconnect.php'); // Ensure correct database connection

// Handle profile update
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_staff'])) {
    $staff_id = intval($_POST['staff_id']);
    $first_name = mysqli_real_escape_string($conp, $_POST['first_name']);
    $last_name = mysqli_real_escape_string($conp, $_POST['last_name']);
    $specialization = mysqli_real_escape_string($conp, $_POST['specialization']);
    $department = mysqli_real_escape_string($conp, $_POST['department']);
    $phone_extension = mysqli_real_escape_string($conp, $_POST['phone_extension']);
    $shift = mysqli_real_escape_string($conp, $_POST['shift']);
    $email = mysqli_real_escape_string($conp, $_POST['email']);
    $phone_number = mysqli_real_escape_string($conp, $_POST['phone_number']);
    $address = mysqli_real_escape_string($conp, $_POST['address']);
    $role = mysqli_real_escape_string($conp, $_POST['role']);

    $query = "UPDATE staff SET 
              first_name='$first_name',
              last_name='$last_name',
              specialization='$specialization',
              department='$department',
              phone_extension='$phone_extension',
              shift='$shift',
              email='$email',
              phone_number='$phone_number',
              address='$address',
              role='$role'
              WHERE staff_id=$staff_id";

    if (mysqli_query($conp, $query)) {
        echo "Staff profile updated successfully.";
    } else {
        echo "Error updating staff profile: " . mysqli_error($conp);
    }
}

// Fetch staff profiles
$staffQuery = "SELECT * FROM staff";
$staffResult = mysqli_query($conp, $staffQuery);
if (!$staffResult) {
    die("Error fetching staff: " . mysqli_error($conp));
}
$staffMembers = [];
while ($row = mysqli_fetch_assoc($staffResult)) {
    $staffMembers[] = $row;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Profiles</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px; }
        .container { width: 100%; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { padding: 10px; border: 1px solid #ddd; text-align: left; }
        th { background-color: #017d73; color: white; }
        tr:nth-child(even) { background-color: #f9f9f9; }
        .edit-form { margin-top: 20px; }
        input, select, button { padding: 5px; margin-right: 10px; }
        button { background: #017d73; color: white; border: none; cursor: pointer; }
    </style>
</head>
<body>
<div class="container">
    <h2>Staff Profiles</h2>
    <table>
        <thead>
            <tr>
                <th>Staff ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Specialization</th>
                <th>Department</th>
                <th>Phone Extension</th>
                <th>Shift</th>
                <th>Email</th>
                <th>Phone Number</th>
                <th>Address</th>
                <th>Role</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($staffMembers as $staff): ?>
                <tr>
                    <td><?php echo htmlspecialchars($staff['staff_id']); ?></td>
                    <td><?php echo htmlspecialchars($staff['first_name']); ?></td>
                    <td><?php echo htmlspecialchars($staff['last_name']); ?></td>
                    <td><?php echo htmlspecialchars($staff['specialization']); ?></td>
                    <td><?php echo htmlspecialchars($staff['department']); ?></td>
                    <td><?php echo htmlspecialchars($staff['phone_extension']); ?></td>
                    <td><?php echo htmlspecialchars($staff['shift']); ?></td>
                    <td><?php echo htmlspecialchars($staff['email']); ?></td>
                    <td><?php echo htmlspecialchars($staff['phone_number']); ?></td>
                    <td><?php echo htmlspecialchars($staff['address']); ?></td>
                    <td><?php echo htmlspecialchars($staff['role']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    
    <h2>Edit Staff Details</h2>
    <form class="edit-form" method="post">
        <input type="text" name="staff_id" placeholder="Staff ID" required>
        <input type="text" name="first_name" placeholder="First Name" required>
        <input type="text" name="last_name" placeholder="Last Name" required>
        <input type="text" name="specialization" placeholder="Specialization">
        <input type="text" name="department" placeholder="Department">
        <input type="text" name="phone_extension" placeholder="Phone Extension">
        <input type="text" name="shift" placeholder="Shift">
        <input type="email" name="email" placeholder="Email" required>
        <input type="text" name="phone_number" placeholder="Phone Number">
        <input type="text" name="address" placeholder="Address">
        <input type="text" name="role" placeholder="Role">
        <button type="submit" name="update_staff">Update</button>
    </form>
</div>
</body>
</html>

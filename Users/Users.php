<?php
require_once('../dataconnect.php');  // Include your database connection file

// Fetch all users from the users table
$query = "SELECT user_id, staff_id, role, email, contactno, address, registration_date FROM users";
$result = mysqli_query($conp, $query);

if (!$result) {
    die("Error fetching users: " . mysqli_error($conp));
}

$users = [];
while ($row = mysqli_fetch_assoc($result)) {
    $users[] = $row;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users List</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
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
            max-width: 800px;
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
    </style>
</head>
<body>
<div class="container">
    <h2>Users List</h2>
    <table>
        <thead>
            <tr>
                <th>User ID</th>
                <th>Staff ID</th>
                <th>Role</th>
                <th>Email</th>
                <th>Phone Number</th>
                <th>Address</th>
                <th>Registration Date</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?php echo htmlspecialchars($user['user_id']); ?></td>
                    <td><?php echo htmlspecialchars($user['staff_id']); ?></td>
                    <td><?php echo htmlspecialchars($user['role']); ?></td>
                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                    <td><?php echo htmlspecialchars($user['contactno']); ?></td>
                    <td><?php echo htmlspecialchars($user['address']); ?></td>
                    <td><?php echo htmlspecialchars($user['registration_date']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>
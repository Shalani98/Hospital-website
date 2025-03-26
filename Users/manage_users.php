<?php
session_start();
require_once('../dataconnect.php');

// Ensure only the Administrator can access this page
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'Administrator') {
    header("Location: UserLogin.php");
    exit;
}

// Handle user actions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'] ?? null;
    $user_id = $_POST['user_id'] ?? null;
    $role = $_POST['role'] ?? null;
    $password = $_POST['password'] ?? null;
    $status = $_POST['status'] ?? null;

    if ($action === 'add' && $user_id && $role && $password) {
        $query = "INSERT INTO userslogin (user_id, role, password, status) VALUES (?, ?, ?, 'active')";
        $stmt = mysqli_prepare($conp, $query);
        mysqli_stmt_bind_param($stmt, 'sss', $user_id, $role, $password);
        mysqli_stmt_execute($stmt);
        $message = "User added successfully!";
    } elseif ($action === 'update' && $user_id && $role && $status) {
        $query = "UPDATE userslogin SET role = ?, status = ? WHERE user_id = ?";
        $stmt = mysqli_prepare($conp, $query);
        mysqli_stmt_bind_param($stmt, 'sss', $role, $status, $user_id);
        mysqli_stmt_execute($stmt);
        $message = "User updated successfully!";
    } elseif ($action === 'delete' && $user_id) {
        $query = "DELETE FROM userslogin WHERE user_id = ?";
        $stmt = mysqli_prepare($conp, $query);
        mysqli_stmt_bind_param($stmt, 's', $user_id);
        mysqli_stmt_execute($stmt);
        $message = "User deleted successfully!";
    } elseif (isset($_POST['toggle_staff_status'])) {
        $user_id = $_POST['user_id'];
        $new_status = $_POST['new_status'];

        $query = "UPDATE userslogin SET status = ? WHERE user_id = ?";
        $stmt = mysqli_prepare($conp, $query);
        mysqli_stmt_bind_param($stmt, 'ss', $new_status, $user_id);
        mysqli_stmt_execute($stmt);
        $message = "Staff status updated successfully!";
    }
}

// Fetch all users
$query = "SELECT user_id, role, status FROM userslogin";
$result = mysqli_query($conp, $query);
$users = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Fetch patients data
$query = "SELECT id, fullname, status FROM patients";
$result = mysqli_query($conp, $query);
$patients = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .form-container, .table-container {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        table th, table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }
        button, select, input[type="text"], input[type="password"] {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f9f9f9;
            cursor: pointer;
            font-size: 14px;
        }
        button {
            background-color: #017d73;
            color: white;
        }
        button:hover {
            background-color: #016a63;
        }
        .message {
            color: green;
            text-align: center;
        }
    </style>
</head>
<body>
    <h2>Manage Users</h2>

    <?php if (!empty($message)): ?>
        <p class="message"><?php echo htmlspecialchars($message); ?></p>
    <?php endif; ?>

    <div class="form-container">
        <h3>Add or Update User</h3>
        <form method="POST" action="">
            <label>User ID:</label>
            <input type="text" name="user_id" required>
            <label>Role:</label>
            <select name="role" required>
                <option value="Administrator">Administrator</option>
                <option value="Doctor">Doctor</option>
                <option value="Lab Technician">Lab Technician</option>
                <option value="Nurse">Nurse</option>
            </select>
            <label>Password (for Add):</label>
            <input type="password" name="password">
            <label>Status (for Update):</label>
            <select name="status">
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
            </select>
            <button type="submit" name="action" value="add">Add User</button>
            <button type="submit" name="action" value="update">Update User</button>
        </form>
    </div>

    <div class="table-container">
        <h3>Existing Users (Staff)</h3>
        <table>
            <thead>
                <tr>
                    <th>User ID</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($user['user_id']); ?></td>
                        <td><?php echo htmlspecialchars($user['role']); ?></td>
                        <td><?php echo htmlspecialchars($user['status']); ?></td>
                        <td>
                            <form method="POST" action="" style="display: inline;">
                                <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($user['user_id']); ?>">
                                <input type="hidden" name="new_status" value="<?php echo ($user['status'] === 'active') ? 'inactive' : 'active'; ?>">
                                <button type="submit" name="toggle_staff_status">
                                    <?php echo ($user['status'] === 'active') ? 'Deactivate' : 'Activate'; ?>
                                </button>
                            </form>
                            <form method="POST" action="" style="display: inline;">
                                <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($user['user_id']); ?>">
                                <button type="submit" name="action" value="delete">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="table-container">
        <h3>Patients</h3>
        <table>
            <thead>
                <tr>
                    <th>Patient ID</th>
                    <th>Full Name</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($patients as $patient): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($patient['id']); ?></td>
                        <td><?php echo htmlspecialchars($patient['fullname']); ?></td>
                        <td><?php echo htmlspecialchars($patient['status'] ?? 'inactive'); ?></td>
                        <td>
                            <form method="POST" action="" style="display: inline;">
                                <input type="hidden" name="patient_id" value="<?php echo htmlspecialchars($patient['id']); ?>">
                                <input type="hidden" name="new_status" value="<?php echo ($patient['status'] ?? 'inactive') === 'active' ? 'inactive' : 'active'; ?>">
                                <button type="submit" name="toggle_patient_status">
                                    <?php echo ($patient['status'] ?? 'inactive') === 'active' ? 'Deactivate' : 'Activate'; ?>
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>

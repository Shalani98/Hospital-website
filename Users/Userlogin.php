<?php
session_start();
require_once('../dataconnect.php');

// Ensure database connection is established
if (!$conp) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Set character set to utf8
mysqli_set_charset($conp, 'utf8');

// Function to synchronize staff data with userslogin
function syncStaffToUsersLogin($conp) {
    $staff_query = "SELECT user_id, password, role FROM staff";
    $staff_result = mysqli_query($conp, $staff_query);

    if ($staff_result) {
        while ($staff_row = mysqli_fetch_assoc($staff_result)) {
            $check_query = "SELECT * FROM userslogin WHERE user_id = ?";
            $check_stmt = mysqli_prepare($conp, $check_query);

            if ($check_stmt) {
                mysqli_stmt_bind_param($check_stmt, 's', $staff_row['user_id']);
                mysqli_stmt_execute($check_stmt);
                $check_result = mysqli_stmt_get_result($check_stmt);

                if ($check_result && mysqli_num_rows($check_result) == 0) {
                    $insert_query = "INSERT INTO userslogin (user_id, password, role, status) VALUES (?, ?, ?, ?)";
                    $insert_stmt = mysqli_prepare($conp, $insert_query);

                    if ($insert_stmt) {
                        $status = 'active';
                        $password = ($staff_row['password']);
                        mysqli_stmt_bind_param(
                            $insert_stmt,
                            'ssss',
                            $staff_row['user_id'],
                            $password,
                            $staff_row['role'],
                            $status
                        );
                        mysqli_stmt_execute($insert_stmt);
                    }
                }
            }
        }
    } else {
        die("Failed to fetch data from staff table: " . mysqli_error($conp));
    }
}

// Synchronize staff data with userslogin
syncStaffToUsersLogin($conp);

// Login functionality
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = trim($_POST['user_id']);
    $password = trim($_POST['password']);
    $role = trim($_POST['role']);

    if (!empty($user_id) && !empty($password) && !empty($role)) {
        $query = "SELECT user_id, role, password, status FROM userslogin WHERE user_id = ? AND role = ?";
        $stmt = mysqli_prepare($conp, $query);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, 'ss', $user_id, $role);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if ($result && $user = mysqli_fetch_assoc($result)) {
                if ($password === $user['password']) {
                    $_SESSION['user'] = [
                        'user_id' => $user['user_id'],
                        'role' => $user['role'],
                        'status' => $user['status'],
                        'loggedin' => true,
                    ];
                    
                    switch ($role) {
                        case 'Administrator':
                            header("Location: AdminDashboard.php");
                            break;
                        case 'Doctor':
                            header("Location: DoctorDashboard.php");
                            break;
                        case 'Lab Technician':
                            header("Location: Labtechniciandashboard.php");
                            break;
                        case 'Nurse':
                            header("Location: Nursedashboard.php");
                            break;
                        default:
                            $error = "Invalid role.";
                            break;
                    }
                    exit;
                } else {
                    $error = "Invalid password.";
                }
            } else {
                $error = "Invalid User ID or Role.";
            }
        } else {
            $error = "Database query preparation failed: " . mysqli_error($conp);
        }
    } else {
        $error = "Please fill in all fields.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #121212;
            margin: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
            color: white;
        }

        /* Calm and professional animated background */
        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(45deg, #6a9ecf, #4a90e2, #8bc34a, #9c27b0);
            background-size: 400% 400%;
            animation: gradientShift 15s ease infinite;
            filter: blur(30px);
            z-index: -1;
        }

        @keyframes gradientShift {
            0% {
                background-position: 0% 50%;
            }
            50% {
                background-position: 100% 50%;
            }
            100% {
                background-position: 0% 50%;
            }
        }

        .login-container {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            padding: 40px 30px;
            width: 100%;
            max-width: 450px;
            text-align: center;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(10px);
            transition: transform 0.3s ease-in-out;
        }

        .login-container:hover {
            transform: scale(1.05);
        }

        h2 {
            font-size: 28px;
            color: #fff;
            margin-bottom: 30px;
            letter-spacing: 2px;
            text-transform: uppercase;
        }

        .form-group {
            margin-bottom: 18px;
        }

        label {
            display: block;
            margin-bottom: 6px;
            font-weight: bold;
            font-size: 16px;
            color: #ddd;
        }

        input[type="text"],
        input[type="password"],
        select {
            width: 100%;
            padding: 12px;
            border: 2px solid #1f1f1f;
            border-radius: 8px;
            background-color: transparent;
            color:rgb(9, 79, 88);
            font-size: 16px;
            margin-bottom: 16px;
            transition: border 0.3s ease;
        }

        input[type="text"]:focus,
        input[type="password"]:focus,
        select:focus {
            border-color: #00bcd4;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #00bcd4;
            color: black;
            border: none;
            border-radius: 8px;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #ff0080;
        }

        .error {
            color: red;
            font-size: 14px;
            margin-top: 15px;
        }
    </style>
</head>
<body>

<img src="../src/CareCompass.png" alt="CareCompass Logo">
<div class="login-container">
    <h2>Staff Login</h2>
    <form action="" method="POST">
        <div class="form-group">
            <label for="user_id">User ID</label>
            <input type="text" id="user_id" name="user_id" placeholder="Enter your User ID" required>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Enter your Password" required>
        </div>
        <div class="form-group">
            <label for="role">Role</label>
            <select id="role" name="role" required>
                <option value="">Select your role</option>
                <option value="Lab Technician">Lab Technician</option>
                <option value="Doctor">Doctor</option>
                <option value="Administrator">Administrator</option>
                <option value="Nurse">Nurse</option>
            </select>
        </div>
        <button type="submit">Login</button>
    </form>

    <?php if (!empty($error)): ?>
        <div class="error"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>
</div>

</body>
</html>

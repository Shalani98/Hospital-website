<?php
require_once('../dataconnect.php');
session_start();

if (isset($_POST['submit'])) {
    $email = mysqli_real_escape_string($conp, $_POST['email']);
    $password = mysqli_real_escape_string($conp, $_POST['password']);

    // Debugging for connection is established
    if (!$conp) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Updated SQL query with correct column names and status check
    $query = "SELECT * FROM patients WHERE email='{$email}' LIMIT 1";
    $result = mysqli_query($conp, $query);

    // Debugging: Check if the query executed successfully
    if (!$result) {
        die("Query failed: " . mysqli_error($conp));
    }

    // Debugging: Check if any results are returned
    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);

        // Check if the account is active
        if ($row['status'] !== 'active') {
            echo "<script>alert('Your account is deactivated. Please contact the administrator.');</script>";
        } elseif (password_verify($password, $row['password'])) {
            $_SESSION['user'] = [
                'id' => $row['id'],
                'email' => $email,
                'loggedin' => true
            ];

            header('Location: Portal.php');
            exit();
        } else {
            echo "<script>alert('Invalid login details');</script>";
        }
    } else {
        echo "<script>alert('Invalid login details');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
<form action="" method="POST">
    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required><br><br>
    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required><br><br>
    <button type="submit" name="submit">Login</button>
</form>
</body>
</html>

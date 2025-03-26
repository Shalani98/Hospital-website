<?php
// Linking database connection
require_once('../dataconnect.php');
session_start();

// Check whether registration form is submitted
if (isset($_POST['register'])) {
    // Retrieve form data for patient
    $FullName = mysqli_real_escape_string($conp, $_POST['fullname']);
    $Address = mysqli_real_escape_string($conp, $_POST['address']);
    $Birthday = mysqli_real_escape_string($conp, $_POST['birthday']);
    $MedicalHistories = mysqli_real_escape_string($conp, $_POST['records']);
    $ContactNo = mysqli_real_escape_string($conp, $_POST['contactNo']);
    $Email = mysqli_real_escape_string($conp, $_POST['email']);
    $Password = mysqli_real_escape_string($conp, $_POST['password']);

    $hashedPassword = password_hash($Password, PASSWORD_DEFAULT);

    // Patient Data  insert into the database
    $Insert = "INSERT INTO patients (fullname, address, birthday, records, contactNo, email, password, status)
               VALUES ('$FullName','$Address', '$Birthday', '$MedicalHistories', '$ContactNo', '$Email', '$hashedPassword', 'active')";

    if (mysqli_query($conp, $Insert)) {
        $last_id = mysqli_insert_id($conp);
        echo "<script>alert('Patient Record Added Successfully! Your Patient ID is: $last_id');</script>";
        echo "<script>window.location.href='Patients.php';</script>";
    } else {
        echo "<script>alert('Patient Record Addition Failed!');</script>";
        echo "<script>window.location.href='register.php';</script>";
    }
}

// Checking whether the login form is submitted
if (isset($_POST['login'])) {
    $Email = mysqli_real_escape_string($conp, $_POST['email']);
    $Password = mysqli_real_escape_string($conp, $_POST['password']);

    // check if patient exists and if the account is active
    $Query = "SELECT * FROM patients WHERE email = '$Email' AND status = 'active'";
    $Result = mysqli_query($conp, $Query);

    if ($Result && mysqli_num_rows($Result) > 0) {
        $Patient = mysqli_fetch_assoc($Result);
        
        // Verify password
        if (password_verify($Password, $Patient['password'])) {
            // Set session variables
            $_SESSION['user']['loggedin'] = true;
            $_SESSION['user']['id'] = $Patient['id'];
            $_SESSION['user']['fullname'] = $Patient['fullname'];

            // Redirect to patient portal
            echo "<script>alert('Login Successful!');</script>";
            echo "<script>window.location.href='Portal.php';</script>";
        } else {
            echo "<script>alert('Invalid Email or Password!');</script>";
        }
    } else {
        // If account is deactivated or email is incorrect
        echo "<script>alert('Account is deactivated or Invalid Email!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Registration and Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
            background-image: url('../src/lobby.jpg'); /* Set the background image */
            background-size: cover; /* Make the image cover the entire background */
            background-position: center; /* Center the image */
            background-repeat: no-repeat; /* Avoid tiling */
           
        }

        main {
    max-width: 600px;
    margin: 0 auto;
    background-color: rgba(255, 255, 255, 0.8); /* Add transparency to the background */
    padding: 30px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
        }

        input {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 4px;
            border: 1px solid #ddd;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #017d73;
            color: white;
            font-size: 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #005e57;
        }

        .form-container {
            margin-bottom:20px;
        }
    </style>
</head>
<body>


    <main>
        <section class="form-container">
            <h2>Patient Registration</h2>
            <form action="" method="POST">
                <label for="fullname">Full Name:</label>
                <input type="text" id="fullname" name="fullname" required><br>

                <label for="address">Address:</label>
                <input type="text" id="address" name="address" required><br>

                <label for="contactNo">Contact No:</label>
                <input type="tel" id="contactNo" name="contactNo" required><br>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required><br>

                <label for="birthday">Birthday:</label>
                <input type="date" id="birthday" name="birthday" required><br>

                <label for="records">Medical Histories:</label>
                <input type="text" id="records" name="records" required><br>

                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required><br>

                <button type="submit" name="register">Register</button>
            </form>
        </section>

        <section class="form-container">
            <h2>Patient Login</h2>
            <form action="" method="POST">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required><br>

                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required><br>

                <button type="submit" name="login">Login</button>
            </form>
        </section>
    </main>
</body>
</html>

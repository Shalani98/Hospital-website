<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Link database connection
require_once('../dataconnect.php');
session_start();

// Initialize a message variable
$message = "";

// Check if registration form is submitted
if (isset($_POST['register'])) {
    // Retrieve form data and sanitize it
    $firstName = mysqli_real_escape_string($conp, trim($_POST['first_name']));
    $lastName = mysqli_real_escape_string($conp, trim($_POST['last_name']));
    $email = mysqli_real_escape_string($conp, trim($_POST['email']));
    $password = mysqli_real_escape_string($conp, trim($_POST['password']));
    $specialization = mysqli_real_escape_string($conp, trim($_POST['specialization']));
    $department = mysqli_real_escape_string($conp, trim($_POST['department']));
    $phoneExtension = mysqli_real_escape_string($conp, trim($_POST['phone_extension']));
    $shift = mysqli_real_escape_string($conp, trim($_POST['shift']));
    $phoneNumber = mysqli_real_escape_string($conp, trim($_POST['phone_number']));
    $address = mysqli_real_escape_string($conp, trim($_POST['address']));
    $registrationDate = mysqli_real_escape_string($conp, trim($_POST['registration_date']));
    $role = mysqli_real_escape_string($conp, trim($_POST['role']));
    $qualifications = mysqli_real_escape_string($conp, trim($_POST['qualifications']));
    $price = isset($_POST['price']) ? mysqli_real_escape_string($conp, trim($_POST['price'])) : NULL;

    $insertUser = "INSERT INTO users (email, password, phone_number) VALUES ('$email', '$password', '$phoneNumber')";

    if (mysqli_query($conp, $insertUser)) {
        $user_id = mysqli_insert_id($conp); // Retrieve the last inserted ID for user_id

        $insertStaff = "INSERT INTO staff 
        (user_id, first_name, last_name, email, password, specialization, department, phone_extension, shift, phone_number, address, registration_date, role, qualifications, price)
        VALUES 
        ('$user_id', '$firstName', '$lastName', '$email', '$password', '$specialization', '$department', '$phoneExtension', '$shift', '$phoneNumber', '$address', '$registrationDate', '$role', '$qualifications', NULLIF('$price', ''))";

        if (mysqli_query($conp, $insertStaff)) {
            $message = "Staff Registered Successfully! User ID: $user_id";
        } else {
            $message = "Staff Record Addition Failed: " . mysqli_error($conp);
        }
    } else {
        $message = "User Registration Failed: " . mysqli_error($conp);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Registration</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px; }
        main { max-width: 600px; margin: 0 auto; background-color: white; padding: 20px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); }
        h2 { text-align: center; margin-bottom: 20px; }
        label { display: block; margin-bottom: 8px; }
        input, select { width: 100%; padding: 10px; margin-bottom: 15px; border-radius: 4px; border: 1px solid #ddd; }
        button { width: 100%; padding: 12px; background-color: #017d73; color: white; font-size: 16px; border: none; border-radius: 4px; cursor: pointer; }
        button:hover { background-color: #005e57; }
        .message { text-align: center; font-weight: bold; margin-bottom: 20px; }
        .message.success { color: green; }
        .message.error { color: red; }
    </style>
</head>
<body>
    <main>
        <section>
            <h2>Staff Registration</h2>
            <?php if (!empty($message)) : ?>
                <div class="message <?php echo strpos($message, 'Failed') === false ? 'success' : 'error'; ?>">
                    <?php echo htmlspecialchars($message); ?>
                </div>
            <?php endif; ?>

            <form action="" method="POST">
                <label for="first_name">First Name:</label>
                <input type="text" id="first_name" name="first_name" required>

                <label for="last_name">Last Name:</label>
                <input type="text" id="last_name" name="last_name" required>

                <label for="specialization">Specialization:</label>
                <input type="text" id="specialization" name="specialization" required>

                <label for="department">Department:</label>
                <input type="text" id="department" name="department" required>

                <label for="phone_extension">Phone Extension:</label>
                <input type="text" id="phone_extension" name="phone_extension" required>

                <label for="shift">Shift:</label>
                <input type="text" id="shift" name="shift" required>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>

                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>

                <label for="phone_number">Phone Number:</label>
                <input type="tel" id="phone_number" name="phone_number" required>

                <label for="address">Address:</label>
                <input type="text" id="address" name="address" required>

                <label for="registration_date">Registration Date:</label>
                <input type="date" id="registration_date" name="registration_date" required>

                <label for="qualifications">Qualifications:</label>
                <input type="text" id="qualifications" name="qualifications" required>

                <label for="role">Role:</label>
                <select id="role" name="role" required>
                    <option value="Doctor">Doctor</option>
                    <option value="Lab Technician">Lab Technician</option>
                    <option value="Administrator">Administrator</option>
                    <option value="Nurse">Nurse</option>
                </select>

                <label for="price" id="priceLabel">Channelling Price:</label>
                <input type="number" id="price" name="price">

                <button type="submit" name="register">Register</button>
            </form>
        </section>
    </main>
    <script>
        document.getElementById("role").addEventListener("change", function() {
            let priceField = document.getElementById("price");
            let priceLabel = document.getElementById("priceLabel");
            priceField.style.display = this.value === "Doctor" ? "block" : "none";
            priceLabel.style.display = priceField.style.display;
        });
    </script>
</body>
</html>

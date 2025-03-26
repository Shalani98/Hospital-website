<?php
// Link database connection
require_once('../dataconnect.php');
session_start();

// Check if the form is submitted
if (isset($_POST['update_hospital_info'])) {
    // Retrieve form data
    $branch_name = mysqli_real_escape_string($conp, $_POST['branch_name']);
    $service_details = mysqli_real_escape_string($conp, $_POST['service_details']);
    $contact_info = mysqli_real_escape_string($conp, $_POST['contact_info']);
    $address = mysqli_real_escape_string($conp, $_POST['address']);

    // Get the current timestamp
    $updated_at = date('Y-m-d H:i:s');

    // Update the hospital information in the database
    $updateQuery = "UPDATE hospital_info 
                    SET branch_name = '$branch_name', 
                        service_details = '$service_details', 
                        contact_info = '$contact_info', 
                        address = '$address',
                        updated_at = '$updated_at' 
                    WHERE id = 1"; // Assuming '1' is the hospital's ID

    // Execute the query and check if the update was successful
    if (mysqli_query($conp, $updateQuery)) {
        echo "<script>alert('Hospital Information Updated Successfully!');</script>";
        echo "<script>window.location.href='dashboard.php';</script>"; // Redirect to a dashboard or admin page
    } else {
        echo "<script>alert('Failed to Update Hospital Information.');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Hospital Information</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet"> <!-- Font Awesome Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet"> <!-- Google Font -->
    <style>
        /* General Styles */
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f4f7f9;
            margin: 0;
            padding: 0;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        .form-container {
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 80%;
            max-width: 600px;
            margin: 30px auto;
        }

        .form-container label {
            font-size: 16px;
            font-weight: 500;
            margin-bottom: 8px;
            color: #333;
        }

        .form-container input[type="text"],
        .form-container textarea {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
            color: #333;
            background-color: #f9f9f9;
        }

        .form-container textarea {
            resize: vertical;
        }

        .form-container button {
            background-color: #017d73;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            width: 100%;
            transition: background-color 0.3s ease;
        }

        .form-container button:hover {
            background-color: #016a63;
        }

        /* Responsive Design */
        @media screen and (max-width: 768px) {
            .form-container {
                width: 90%;
                padding: 20px;
            }
        }

        /* Message Container */
        .message {
            color: green;
            text-align: center;
            margin-top: 20px;
        }

        /* Footer */
        footer {
            background-color: #2c3e50;
            color: white;
            text-align: center;
            padding: 15px;
            position: fixed;
            width: 100%;
            bottom: 0;
        }
    </style>
</head>
<body>

    <!-- Form Container -->
    <div class="form-container">
        <h2>Update Hospital Information</h2>
        <form action="hospitalinformation.php" method="POST">
            <label for="branch_name">Branch Name:</label>
            <input type="text" id="branch_name" name="branch_name" required>

            <label for="service_details">Service Details:</label>
            <textarea id="service_details" name="service_details" rows="4" required></textarea>

            <label for="contact_info">Contact Information:</label>
            <input type="text" id="contact_info" name="contact_info" required>

            <label for="address">Address:</label>
            <input type="text" id="address" name="address" required>

            <button type="submit" name="update_hospital_info">Update</button>
        </form>
    </div>

    <!-- Footer -->
    <footer>
        <p>&copy; 2025 CareCompass Hospital. All Rights Reserved.</p>
    </footer>

</body>
</html>

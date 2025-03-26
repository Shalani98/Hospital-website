<?php
require_once('../dataconnect.php');
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user']['loggedin']) || $_SESSION['user']['loggedin'] !== true) {
    header('Location: login.php');
    exit;
}




       
// Query to fetch all lab results from the labresults table
            $labresults_query = "SELECT * FROM labresults";
            $labresults_result = mysqli_query($conp, $labresults_query);

            if ($labresults_result) {
                $labresults = [];
                while ($row = mysqli_fetch_assoc($labresults_result)) {
                    $labresults[] = $row;
                }
            } else {
                die("Error fetching lab results: " . mysqli_error($conp));
            }
     

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lab Results - <?php echo htmlspecialchars($requested_id); ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }

        main {
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

        .labresults table {
            width: 100%;
            border-collapse: collapse;
        }

        .labresults th, .labresults td {
            border: 1px solid #ddd;
            padding: 8px;
        }

        .labresults th {
            background-color: #f2f2f2;
            text-align: left;
        }

        .back-button {
            text-align: center;
            margin-top: 20px;
        }

        .back-button a {
            text-decoration: none;
            background-color: #017d73;
            color: white;
            padding: 10px 20px;
            border-radius: 4px;
        }

        .back-button a:hover {
            background-color: #005e57;
        }
    </style>
</head>
<body>
<main>
    <h2>Lab Results </h2>

    <div class="labresults">
        <h3>Lab Results:</h3>
        <?php if (!empty($labresults)) { ?>
            <table>
                <thead>
                    <tr>
                        <th>Lab Result ID</th>
                        <th>Staff ID</th>
                        <th>Test ID</th>
                        <th>Result</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($labresults as $result) { ?>
                        <tr>
                            <td><?php echo htmlspecialchars($result['labresult_id']); ?></td>
                            <td><?php echo htmlspecialchars($result['staff_id']); ?></td>
                            <td><?php echo htmlspecialchars($result['test_id']); ?></td>
                            <td><?php echo htmlspecialchars($result['result']); ?></td>
                            <td><?php echo htmlspecialchars($result['date']); ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php } else { ?>
            <p>No lab results available.</p>
        <?php } ?>
    </div>

    <div class="back-button">
        <a href="medicalrecords.php">Back to Patients List</a>
    </div>
</main>
</body>
</html>
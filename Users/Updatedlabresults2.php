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

// Query to fetch all test details from the laboratory_tests table
$laboratory_tests_query = "SELECT * FROM laboratory_tests";
$laboratory_tests_result = mysqli_query($conp, $laboratory_tests_query);

if ($laboratory_tests_result) {
    $laboratory_tests = [];
    while ($row = mysqli_fetch_assoc($laboratory_tests_result)) {
        $laboratory_tests[] = $row;
    }
} else {
    die("Error fetching laboratory tests: " . mysqli_error($conp));
}

// If the form is submitted to update lab results
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    $labresult_id = mysqli_real_escape_string($conp, $_POST['labresult_id']);
    $result = mysqli_real_escape_string($conp, $_POST['result']);
    $date = mysqli_real_escape_string($conp, $_POST['date']);

    // Update query
    $update_query = "UPDATE labresults SET result='$result', date='$date' WHERE labresult_id='$labresult_id'";
    $update_result = mysqli_query($conp, $update_query);

    if ($update_result) {
        echo "Lab result updated successfully.";
        // Refresh the page to reflect the update
        header("Location: ".$_SERVER['PHP_SELF']);
        exit;
    } else {
        die("Error updating lab result: " . mysqli_error($conp));
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lab Results</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }

        main {
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

        .labresults table, .laboratory-tests table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .labresults th, .labresults td, .laboratory-tests th, .laboratory-tests td {
            border: 1px solid #ddd;
            padding: 8px;
        }

        .labresults th, .laboratory-tests th {
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

        .update-form {
            display: inline-block;
        }

        .update-form input, .update-form button {
            padding: 5px;
            margin: 5px;
        }

        .update-form button {
            background-color: #017d73;
            color: white;
            border: none;
            border-radius: 4px;
        }

        .update-form button:hover {
            background-color: #005e57;
        }
    </style>
</head>
<body>
<main>
    <h2>Laboratory Tests & Lab Results</h2>
    <div class="laboratory-tests">
        <h3>Laboratory Tests:</h3>
        <?php if (!empty($laboratory_tests)) { ?>
            <table>
                <thead>
                    <tr>
                        <th>Test ID</th>
                        <th>Test Name</th>
                        <th>Description</th>
                        <th>Preparation Guidelines</th>
                        <th>Price</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($laboratory_tests as $test) { ?>
                        <tr>
                            <td><?php echo htmlspecialchars($test['test_id']); ?></td>
                            <td><?php echo htmlspecialchars($test['test_name']); ?></td>
                            <td><?php echo htmlspecialchars($test['description']); ?></td>
                            <td><?php echo htmlspecialchars($test['preparation_guidelines']); ?></td>
                            <td><?php echo htmlspecialchars($test['price']); ?></td>
                            
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php } else { ?>
            <p>No laboratory tests available.</p>
        <?php } ?>
    </div>
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
                        <th>Action</th>
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
                            <td>
                                <form class="update-form" action="" method="post">
                                    <input type="hidden" name="labresult_id" value="<?php echo htmlspecialchars($result['labresult_id']); ?>">
                                    <input type="text" name="result" value="<?php echo htmlspecialchars($result['result']); ?>" required>
                                    <input type="date" name="date" value="<?php echo htmlspecialchars($result['date']); ?>" required>
                                    <button type="submit" name="update">Update</button>
                                </form>
                            </td>
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
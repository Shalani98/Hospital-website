<?php
// Start the session
session_start();

// Include the database connection
require_once('../dataconnect.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['tests'])) {
    $test_ids = $_POST['tests'];
    $total_price = 0;
    $tests_details = [];

    foreach ($test_ids as $id) {
        $id = intval($id); // Sanitize input
        $sql = "SELECT * FROM laboratory_tests WHERE test_id = $id";
        $result = mysqli_query($conp, $sql);
        if ($result && $row = mysqli_fetch_assoc($result)) {
            $tests_details[] = $row;
            $total_price += $row['price'];
        }
    }

    if (empty($tests_details)) {
        die("No valid tests selected.");
    }
} else {
    die("No tests selected.");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link rel="stylesheet" href="styles.css"> <!-- Link to an external CSS file -->
    <style>
        /*  Styling */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            padding: 20px;
            margin: 0;
        }
        h1 {
            text-align: center;
            color: #2c3e50;
        }
        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        th, td {
            padding: 12px 20px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #3498db;
            color: white;
        }
        tr:hover {
            background-color: #ecf0f1;
        }
        .total-row {
            font-weight: bold;
            background-color: #3498db;
            color: white;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            margin: 20px 0;
            background-color: #2ecc71;
            color: white;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }
        .btn:hover {
            background-color: #27ae60;
        }
        .container {
            max-width: 1000px;
            margin: 0 auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .checkout-header {
            text-align: center;
            margin-bottom: 30px;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="checkout-header">
            <h1>Checkout</h1>
            <p>Please review your selected tests and proceed to payment</p>
        </div>

        <table>
            <tr>
                <th>Test Name</th>
                <th>Price</th>
            </tr>
            <?php foreach ($tests_details as $test): ?>
                <tr>
                    <td><?= htmlspecialchars($test['test_name']) ?></td>
                    <td><?= htmlspecialchars($test['price']) ?> USD</td>
                </tr>
            <?php endforeach; ?>
            <tr class="total-row">
                <td>Total</td>
                <td><?= htmlspecialchars($total_price) ?> USD</td>
            </tr>
        </table>

        <form action="payment_success.php" method="post" class="payment-form">
            <input type="hidden" name="tests" value="<?= htmlspecialchars(implode(',', $test_ids)) ?>">
            <input type="hidden" name="total_price" value="<?= htmlspecialchars($total_price) ?>">
            <button type="submit" class="btn">Confirm and Pay</button>
        </form>
    </div>

</body>
</html>

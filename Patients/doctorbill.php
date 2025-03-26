<?php
// Database connection
include '../dataconnect.php';

$payment_id = null; 

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Capture form input
    $card_name = $_POST['card_name'];
    $price = $_POST['price'];
    $payment_status = "paid"; // Set default payment status as 'paid'

    // Prepare the SQL query to insert data into the bill table
    $sql = "INSERT INTO bill (name_on_card, price, payment_status)
            VALUES ('$card_name', '$price', '$payment_status')";
 
    // Checking  if the query was successful
    if ($conp->query($sql) === TRUE) {
        $message = "Paid successfully.!";
        $payment_id = $conp->insert_id; // Get the last inserted payment ID
    } else {
        $message = "Error: Unable to save payment details. Please try again.";
    }

   
    $conp->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Form</title>
    <!-- Add Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<style>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap');

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Poppins', sans-serif;
}

body {
    background-color: #f4f6f9;
    padding: 30px;
}

.container {
    max-width: 800px;
    margin: 0 auto;
}

.card {
    box-shadow: rgba(0, 0, 0, 0.1) 0px 4px 6px;
    background: #fff;
    border-radius: 10px;
    margin-bottom: 20px;
    padding: 30px;
}

.img-box {
    width: 80px;
    height: 50px;
    margin-bottom: 15px;
}

img {
    width: 100%;
    object-fit: fill;
}

.fw-bold {
    font-weight: bold;
}

.form__div {
    height: 50px;
    position: relative;
    margin-bottom: 20px;
}

.form-control {
    width: 100%;
    height: 45px;
    font-size: 14px;
    border: 1px solid #DADCE0;
    border-radius: 8px;
    outline: none;
    padding: 10px;
    background: none;
    z-index: 1;
    box-shadow: none;
}

.form__label {
    position: absolute;
    left: 16px;
    top: 10px;
    background-color: #fff;
    color: #80868B;
    font-size: 16px;
    transition: .3s;
    text-transform: uppercase;
}

.form-control:focus + .form__label {
    top: -8px;
    left: 12px;
    color: #1A73E8;
    font-size: 12px;
    font-weight: 500;
    z-index: 10;
}

.form-control:focus {
    border: 2px solid #1A73E8;
}

.btn-primary {
    background-color: #1c6acf;
    color: white;
    border-radius: 8px;
    width: 100%;
    padding: 12px;
    font-size: 16px;
    border: none;
}

.btn-primary:hover {
    background-color: #154c87;
}
</style>
<body>

<div class="container">
    <div class="row">
        <div class="col-12 mb-4">
            <div class="card p-3">
                <p class="fw-bold h4">Payment Information</p>
                <!-- Display the message -->
                <?php if (!empty($message)): ?>
                    <div class="alert alert-info" role="alert">
                        <?= htmlspecialchars($message); ?>
                    </div>
                <?php else: ?>
                    <p class="text-muted">Please fill in the details to make a payment.</p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Payment Form -->
        <div class="col-12">
            <div class="card p-3">
                <?php if ($payment_id): ?>
                
                    <div class="text-center">
                        <form method="POST" action="process_payment.php">
                            <input type="hidden" name="payment_id" value="<?= $payment_id ?>">
                            <button type="submit" class="btn btn-success">Pay Now</button>
                        </form>
                    </div>
                <?php else: ?>
                    <form method="POST" action="">
                        <div class="row">
                            <div class="col-12">
                                <div class="form__div">
                                    <input type="text" class="form-control" name="card_name" placeholder=" " required>
                                    <label for="card_name" class="form__label">Name on Card</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form__div">
                                    <input type="number" class="form-control" name="price" placeholder=" " required>
                                    <label for="price" class="form__label">Price</label>
                                </div>
                            </div>

                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">Pay</button>
                            </div>
                        </div>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Add Bootstrap JS and dependencies -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

</body>
</html>

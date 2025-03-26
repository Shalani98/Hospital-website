<?php
require_once('../dataconnect.php');
session_start();

// Check if user is logged in
if (!isset($_SESSION['user']['user_id'])) {
    header('Location: login.php');
    exit();
}

// Get the current user's ID from session
$user_id = $_SESSION['user']['user_id']; // This is 'Shalani98'

// Get the staff_id for the current user from the staff table
$stmt = $conp->prepare("SELECT staff_id FROM staff WHERE user_id = ?");
$stmt->bind_param("s", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $staff_id = $row['staff_id'];
} else {
    echo "<div class='alert alert-danger'>Error: Staff ID not found for this user.</div>";
    exit();
}

$current_datetime = date('Y-m-d H:i:s'); // Current date and time

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['update_care_plan'])) {
        $patient_id = $_POST['id'];
        $care_plan = $_POST['care_plan'];

        // Check if patient exists
        $check_patient = $conp->prepare("SELECT id FROM patients WHERE id = ?");
        $check_patient->bind_param("i", $patient_id);
        $check_patient->execute();
        if ($check_patient->get_result()->num_rows > 0) {
            // Insert care plan
            $sql = "INSERT INTO care_plans (id, care_plan, update_date, staff_id) VALUES (?, ?, ?, ?)";
            $stmt = $conp->prepare($sql);
            $stmt->bind_param("issi", $patient_id, $care_plan, $current_datetime, $staff_id);

            if ($stmt->execute()) {
                $_SESSION['alert'] = ['type' => 'success', 'message' => 'Care plan updated successfully!'];
            } else {
                $_SESSION['alert'] = ['type' => 'danger', 'message' => 'Error: ' . $stmt->error];
            }
        } else {
            $_SESSION['alert'] = ['type' => 'danger', 'message' => 'Error: Patient ID does not exist.'];
        }
    } 
    elseif (isset($_POST['add_medication'])) {
        $medication_update = $_POST['medication'];

        // Insert medication update
        $sql = "INSERT INTO medications (staff_id, medication_update, update_date) VALUES (?, ?, ?)";
        $stmt = $conp->prepare($sql);
        $stmt->bind_param("iss", $staff_id, $medication_update, $current_datetime);

        if ($stmt->execute()) {
            $_SESSION['alert'] = ['type' => 'success', 'message' => 'Medication update added successfully!'];
        } else {
            $_SESSION['alert'] = ['type' => 'danger', 'message' => 'Error: ' . $stmt->error];
        }
    } 
    elseif (isset($_POST['add_followup'])) {
        $patient_id = $_POST['id'];
        $followup_details = $_POST['followup_details'];

        // Check if patient exists
        $check_patient = $conp->prepare("SELECT id FROM patients WHERE id = ?");
        $check_patient->bind_param("i", $patient_id);
        $check_patient->execute();
        if ($check_patient->get_result()->num_rows > 0) {
            // Insert follow-up details
            $sql = "INSERT INTO follow_ups (id, staff_id, follow_up_details, follow_up_date) VALUES (?, ?, ?, ?)";
            $stmt = $conp->prepare($sql);
            $stmt->bind_param("iiss", $patient_id, $staff_id, $followup_details, $current_datetime);

            if ($stmt->execute()) {
                $_SESSION['alert'] = ['type' => 'success', 'message' => 'Follow-up details added successfully!'];
            } else {
                $_SESSION['alert'] = ['type' => 'danger', 'message' => 'Error: ' . $stmt->error];
            }
        } else {
            $_SESSION['alert'] = ['type' => 'danger', 'message' => 'Error: Patient ID does not exist.'];
        }
    }
}

// Fetch Nurse Profiles
function getNurseProfiles() {
    global $conp;
    $result = $conp->query("SELECT * FROM nurses");

    if ($result->num_rows > 0) {
        $html = '';
        while ($nurse = $result->fetch_assoc()) {
            $html .= '<div class="col-md-4 mb-3">';
            $html .= '<div class="card p-3">';
            $html .= '<h3>' . htmlspecialchars($nurse['name']) . '</h3>';
            $html .= '<p><strong>Specialty:</strong> ' . htmlspecialchars($nurse['specialty']) . '</p>';
            $html .= '<p><strong>Experience:</strong> ' . htmlspecialchars($nurse['experience']) . '</p>';
            $html .= '</div>';
            $html .= '</div>';
        }
        return $html;
    } else {
        return '<p>No nurses found.</p>';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nurse Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .header {
            background-color: #007bff;
            color: white;
            padding: 20px;
            text-align: center;
        }
        .section-title {
            color: #007bff;
            font-weight: bold;
            margin-bottom: 20px;
        }
        .card {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .icon {
            font-size: 2rem;
            margin-right: 10px;
        }
        
        footer {
            background-color: #444; /* Dark shade */
            color: white;
            text-align: center;
            padding: 20px;
            margin-top: 40px;
        }
    </style>
</head>
<body>

<header class="header">
    <h1>CareCompass Nurse Dashboard</h1>
    <p>Current User's Login: <?php echo htmlspecialchars($user_id); ?></p>
    <p>Current Date and Time (UTC): <?php echo $current_datetime; ?></p>
    <p>Staff ID: <?php echo $staff_id; ?></p>
    <a href="Userlogin.php" class="btn btn-light">Logout</a>
</header>

<main class="container py-4">
    <!-- Display alert message if it exists -->
    <?php
    if (isset($_SESSION['alert'])) {
        $alert = $_SESSION['alert'];
        echo '<div class="alert alert-' . htmlspecialchars($alert['type']) . ' alert-dismissible fade show" role="alert">';
        echo htmlspecialchars($alert['message']);
        echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
        echo '</div>';

        // Clear the session alert after it's displayed
        unset($_SESSION['alert']);
    }
    ?>

    <div class="row">
        <!-- Patient Care Plans -->
        <div class="col-md-4 mb-4">
            <div class="card text-center">
                <div class="card-body">
                    <i class="fas fa-file-medical icon text-primary"></i>
                    <h5 class="card-title">Patient Care Plans</h5>
                    <p class="card-text">View and update patient care plans to ensure effective treatment.</p>
                    <a href="#care-plans-section" class="btn btn-primary">Manage Care Plans</a>
                </div>
            </div>
        </div>

        <!-- Add Medication -->
        <div class="col-md-4 mb-4">
            <div class="card text-center">
                <div class="card-body">
                    <i class="fas fa-pills icon text-success"></i>
                    <h5 class="card-title">Add Medication</h5>
                    <p class="card-text">Update medication or lifestyle changes for patients.</p>
                    <a href="#medication-section" class="btn btn-success">Add Medication</a>
                </div>
            </div>
        </div>

        <!-- Follow-Up -->
        <div class="col-md-4 mb-4">
            <div class="card text-center">
                <div class="card-body">
                    <i class="fas fa-user-check icon text-info"></i>
                    <h5 class="card-title">Follow-Up</h5>
                    <p class="card-text">Record follow-up details to track patient progress.</p>
                    <a href="#follow-up-section" class="btn btn-info">Add Follow-Up</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Patient Care Plans Section -->
    <section id="care-plans-section" class="form-section mb-5">
        <h2 class="section-title">Update Patient Care Plans</h2>
        <form method="POST" action="">
            <div class="mb-3">
                <label for="patient-id" class="form-label">Patient ID:</label>
                <input type="text" id="id" name="id" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="care-plan" class="form-label">Care Plan Update:</label>
                <textarea id="care-plan" name="care_plan" class="form-control" rows="4" required></textarea>
            </div>
            <button type="submit" name="update_care_plan" class="btn btn-primary">Update Care Plan</button>
        </form>
    </section>

    <!-- Add Medication Section -->
    <section id="medication-section" class="form-section mb-5">
        <h2 class="section-title">Add Medication</h2>
        <form method="POST" action="">
            <div class="mb-3">
                <label for="medication" class="form-label">Medication / Lifestyle Update:</label>
                <textarea id="medication" name="medication" class="form-control" rows="4" required></textarea>
            </div>
            <button type="submit" name="add_medication" class="btn btn-success">Add Medication</button>
        </form>
    </section>

    <!-- Follow-Up Section -->
    <section id="follow-up-section" class="form-section">
        <h2 class="section-title">Follow-Up</h2>
        <form method="POST" action="">
            <div class="mb-3">
                <label for="patient-followup-id" class="form-label">Patient ID:</label>
                <input type="text" id="patient-followup-id" name="id" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="followup-details" class="form-label">Follow-Up Details:</label>
                <textarea id="followup-details" name="followup_details" class="form-control" rows="4" required></textarea>
            </div>
            <button type="submit" name="add_followup" class="btn btn-info">Add Follow-Up</button>
        </form>
    </section>
</main>

<!-- Bootstrap JS and Popper -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

<footer>
    <p>&copy; 2025 CareCompass Hospital. All Rights Reserved.</p>
</footer>
</body>
</html>

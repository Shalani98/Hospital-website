<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
if (!isset($_SESSION['user']['loggedin']) || $_SESSION['user']['loggedin'] !== true) {
    header("Location: login.php");
    exit();
}

require_once('../dataconnect.php');
require_once('../TCPDF-main/tcpdf.php'); // Include the TCPDF library

// Select the correct database
mysqli_select_db($conp, 'care_compass_hospitals');

// Check if the connection is successful
if (!$conp) {
    die("Database connection failed: " . mysqli_connect_error());
}

$appointmentsQuery = "
    SELECT 
        a.appointment_id, 
        a.user_id, 
        a.id, 
        a.date, 
        a.start_time, 
        a.end_time, 
        a.status,
        s.first_name AS doctor_first_name,
        s.last_name AS doctor_last_name,
        s.price AS doctor_price
    FROM appointments a
    LEFT JOIN staff s ON a.user_id = s.user_id
";
$appointmentsResult = mysqli_query($conp, $appointmentsQuery);

if (!$appointmentsResult) {
    die("Error fetching appointments: " . mysqli_error($conp));
}

$rest_list = "";
while ($row = mysqli_fetch_assoc($appointmentsResult)) {
    $rest_list .= "<tr>";

    $rest_list .= "<td>" . htmlspecialchars($row['appointment_id']) . "</td>";
    $rest_list .= "<td>" . htmlspecialchars($row['user_id']) . "</td>";
    $rest_list .= "<td>" . htmlspecialchars($row['id']) . "</td>";
    $rest_list .= "<td>" . htmlspecialchars($row['date']) . "</td>";
    $rest_list .= "<td>" . htmlspecialchars($row['start_time']) . "</td>";
    $rest_list .= "<td>" . htmlspecialchars($row['end_time']) . "</td>";
    $rest_list .= "<td>" . htmlspecialchars($row['status']) . "</td>";
    $rest_list .= "<td><form method='POST'><button type='submit' name='download_single_pdf' value='" . $row['appointment_id'] . "' style='background-color: #017d73; color: white; padding: 5px 10px; border: none; cursor: pointer;'>Download</button></form></td>";
    $rest_list .= "</tr>";
}

// Handle PDF download for a single appointment
if (isset($_POST['download_single_pdf'])) {
    $appointment_id = $_POST['download_single_pdf'];

    $appointmentQuery = "
    SELECT 
        a.appointment_id, 
        a.user_id, 
        a.id, 
        a.date, 
        a.start_time, 
        a.end_time, 
        a.status,
        s.first_name AS doctor_first_name,
        s.last_name AS doctor_last_name,
        s.price AS doctor_price
    FROM 
        appointments a
    LEFT JOIN staff s ON a.user_id = s.user_id
    WHERE 
        a.appointment_id = $appointment_id
";

    $appointmentResult = mysqli_query($conp, $appointmentQuery);
    $appointment = mysqli_fetch_assoc($appointmentResult);

    if ($appointment) {
        // Create a new PDF document
        $pdf = new TCPDF();
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Care Compass Hospitals');
        $pdf->SetTitle('Appointment Details');
        $pdf->SetSubject('Appointment PDF');
        $pdf->SetKeywords('TCPDF, PDF, appointment, care compass, hospitals');

        // Add a page
        $pdf->AddPage();

        // Set font
        $pdf->SetFont('helvetica', '', 12);

        // Title
        $pdf->SetFont('helvetica', 'B', 16);
        $pdf->Cell(0, 10, 'Care Compass Hospital', 0, 1, 'C');
       
        $pdf->Ln(10);
        
        $html = '
        <h2 style="text-align: center; color: #017d73;">Appointment Details</h2>
        <table border="1" cellpadding="5" cellspacing="0" style="width: 100%; font-family: Arial, sans-serif; border-collapse: collapse;">
            <thead>
                <tr style="background-color: #017d73; color: white;">
                    <th style="text-align: left;">Field</th>
                    <th style="text-align: left;">Value</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="background-color: #f9f9f9;">Appointment ID</td>
                    <td>' . htmlspecialchars($appointment['appointment_id']) . '</td>
                </tr>
                <tr>
                    <td style="background-color: #f9f9f9;">User ID</td>
                    <td>' . htmlspecialchars($appointment['user_id']) . '</td>
                </tr>
                <tr>
                    <td style="background-color: #f9f9f9;">Patient ID</td>
                    <td>' . htmlspecialchars($appointment['id']) . '</td>
                </tr>
                <tr>
                    <td style="background-color: #f9f9f9;">Doctor Name</td>
                    <td>' . htmlspecialchars($appointment['doctor_first_name']) . ' ' . htmlspecialchars($appointment['doctor_last_name']) . '</td>
                </tr>
                <tr>
                    <td style="background-color: #f9f9f9;">Doctor Price</td>
                    <td>' . htmlspecialchars($appointment['doctor_price']) . ' LKR</td>
                </tr>
                <tr>
                    <td style="background-color: #f9f9f9;">Date</td>
                    <td>' . htmlspecialchars($appointment['date']) . '</td>
                </tr>
                <tr>
                    <td style="background-color: #f9f9f9;">Start Time</td>
                    <td>' . htmlspecialchars($appointment['start_time']) . '</td>
                </tr>
                <tr>
                    <td style="background-color: #f9f9f9;">End Time</td>
                    <td>' . htmlspecialchars($appointment['end_time']) . '</td>
                </tr>
                <tr>
                    <td style="background-color: #f9f9f9;">Status</td>
                    <td>' . htmlspecialchars($appointment['status']) . '</td>
                </tr>
            </tbody>
        </table>
        ';
        
        // Write the HTML content to the PDF
        $pdf->writeHTML($html, true, false, true, false, '');

        // Close and output the PDF
        $filename = "appointment_$appointment_id.pdf";
        $pdf->Output($filename, 'D');
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment History</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }
        .container {
            width: 100%;
            max-width: none;
            margin: 0 auto;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow-x: auto;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #017d73;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
    </style>
</head>
<body>
<div class="container">

    <h2>Appointment History</h2>
   

    <table>
        <thead>
            <tr>
                <th>Appointment ID</th>
                <th>Doctor ID</th>
                <th>Patient ID</th>
                <th>Date</th>
                <th>Start Time</th>
                <th>End Time</th>
                <th>Status</th>
                <th>Download</th>
            </tr>
        </thead>
        <tbody>
            <?php echo $rest_list; ?>
        </tbody>
    </table>
</div>
</body>
</html>

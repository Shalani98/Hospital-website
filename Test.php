<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lab Tests</title>
</head>
<style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-image: url('path/to/your/image/lt1.jpeg'); /* Ensure the correct path to your image */
        background-size: cover; /* Make the image cover the entire background */
        background-position: center; /* Center the image */
        background-repeat: no-repeat; /* Avoid tiling */
        background-attachment: fixed; /* Ensure the background stays in place when scrolling */
    }

    .container {
        max-width: 1200px;
        margin: 20px auto;
        padding: 20px;
        background: rgba(255, 255, 255, 0.8); /* Semi-transparent background to allow image visibility */
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    h1 {
        text-align: center;
        color: #333;
        margin-bottom: 20px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
    }

    th, td {
        padding: 12px;
        text-align: left;
        border: 1px solid #ddd;
    }

    th {
        background-color: #f4f4f4;
        color: #333;
        font-weight: bold;
    }

    tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    tr:hover {
        background-color: #f1f1f1;
    }
</style>
<body>
    <div class="container">
        <h1>Lab Tests</h1>
        <table>
            <thead>
                <tr>
                    <th>Test Name</th>
                    <th>Description</th>
                    <th>Preparation Guidelines</th>
                    <th>Price (LKR)</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $tests = [
                    ["Complete Blood Count", "A test to evaluate overall health and detect a variety of disorders.", "No special preparation is needed.", 2050.00],
                    ["Lipid Panel", "A test to measure cholesterol and triglycerides in the blood.", "Fast for 9-12 hours before the test.", 2075.00],
                    ["Glucose Test", "A test to measure the amount of glucose in the blood.", "Fast for at least 8 hours before the test.", 2040.00],
                    ["Thyroid Function Test", "A test to check the function of the thyroid gland.", "No special preparation is needed.", 2060.00],
                    ["Urinalysis", "A test to examine the urine for various substances.", "Collect a midstream sample of urine.", 2030.00],
                    ["Cholesterol Test", "Measures the levels of cholesterol and triglycerides in the blood to assess heart health", "Fasting is required for 12 hours before the test.", 2075.00],
                    ["ECG Test", "Records the electrical activity of the heart to detect abnormalities in heart rhythm and function", "Avoid caffeine before the test.", 2200.00],
                    ["Lung Capacity Test", "Evaluates lung function and measures the amount of air the lungs can hold and how efficiently air is exhaled.", "Avoid heavy meals and smoking before the test.", 2100.00],
                    ["Kidney Function Test", "Measures levels of creatinine, urea, and other markers to assess kidney health and filtration efficiency", "Avoid high-protein meals 24 hours before the test and stay hydrated.", 2200.00],
                    ["Rheumatoid Factor Test", "Detects the presence of rheumatoid factor antibodies to help diagnose rheumatoid arthritis and other autoimmune conditions.", "No special preparation required.", 2060.00],
                    ["General Health Parameters Test", "Provides a comprehensive overview of general health through multiple key health indicators", "No special preparation required.", 2080.00],
                    ["Liver Function Test", "Evaluates the levels of liver enzymes, proteins, and bilirubin to check liver health and function.", "Fast for 8-12 hours before the test to ensure accurate results", 2050.00],
                    ["Comprehensive Health Test", "Offers an extensive evaluation of overall health, including tests for multiple organ functions and disease markers.", "Fasting is required for 8 hours before the test.", 2120.00],
                    ["Blockage Detection Test", "Identifies blockages in blood vessels to assess the risk of cardiovascular conditions.", "Avoid heavy meals and caffeine before the test.", 2180.00],
                    ["Vitamin D Test", "Determines the level of vitamin D in the blood to assess bone health and potential deficiencies.", "No special preparation required, but avoid taking vitamin D supplements 24 hours before the test", 2080.00],
                    ["MRI Scan", "Uses magnetic fields and radio waves to produce detailed images of organs and tissues for diagnostic purposes.", "Remove all metal objects and follow specific instructions.", 2500.00],
                    ["Cardiac Stress Test", "Assesses heart function under physical stress to identify abnormalities in blood flow or rhythm.", "Wear comfortable clothing and avoid caffeine or heavy meals for at least 4 hours before the test", 2080.00],
                    ["Hemoglobin Test", "Measures the hemoglobin level in the blood to diagnose anemia and assess oxygen-carrying capacity.", "No special preparation required.", 2040.00],
                    ["Allergy Panel Test", "Detects specific allergens causing adverse reactions, including food, pollen, and environmental triggers.", "Avoid antihistamines for 5-7 days prior to the test as they can interfere with results.", 2050.00]
                ];

                foreach ($tests as $test) {
                    echo "<tr>
                            <td>{$test[0]}</td>
                            <td>{$test[1]}</td>
                            <td>{$test[2]}</td>
                            <td>" . number_format($test[3], 2) . "</td>
                          </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>

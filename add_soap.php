<?php
require 'db.php'; // Ensure db.php contains a secure PDO connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize form data
    $data = [
        'patient_id' => filter_input(INPUT_POST, 'patient_id', FILTER_SANITIZE_NUMBER_INT),
        'patient_name' => filter_input(INPUT_POST, 'patient_name', FILTER_SANITIZE_STRING),
        'date_of_visit' => $_POST['date_of_visit'],
        'chief_complaint' => filter_input(INPUT_POST, 'chief_complaint', FILTER_SANITIZE_STRING),
        'history_present_illness' => filter_input(INPUT_POST, 'history_present_illness', FILTER_SANITIZE_STRING),
        'past_medical_history' => filter_input(INPUT_POST, 'past_medical_history', FILTER_SANITIZE_STRING),
        'family_history' => filter_input(INPUT_POST, 'family_history', FILTER_SANITIZE_STRING),
        'social_history' => filter_input(INPUT_POST, 'social_history', FILTER_SANITIZE_STRING),
        'review_of_systems' => filter_input(INPUT_POST, 'review_of_systems', FILTER_SANITIZE_STRING),
        'temperature' => filter_input(INPUT_POST, 'temperature', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION),
        'blood_pressure' => filter_input(INPUT_POST, 'blood_pressure', FILTER_SANITIZE_STRING),
        'heart_rate' => filter_input(INPUT_POST, 'heart_rate', FILTER_SANITIZE_NUMBER_INT),
        'respiratory_rate' => filter_input(INPUT_POST, 'respiratory_rate', FILTER_SANITIZE_NUMBER_INT),
        'physical_exam_findings' => filter_input(INPUT_POST, 'physical_exam_findings', FILTER_SANITIZE_STRING),
        'lab_results' => filter_input(INPUT_POST, 'lab_results', FILTER_SANITIZE_STRING),
        'imaging_results' => filter_input(INPUT_POST, 'imaging_results', FILTER_SANITIZE_STRING),
        'primary_diagnosis' => filter_input(INPUT_POST, 'primary_diagnosis', FILTER_SANITIZE_STRING),
        'differential_diagnosis' => filter_input(INPUT_POST, 'differential_diagnosis', FILTER_SANITIZE_STRING),
        'medications_prescribed' => filter_input(INPUT_POST, 'medications_prescribed', FILTER_SANITIZE_STRING),
        'additional_tests' => filter_input(INPUT_POST, 'additional_tests', FILTER_SANITIZE_STRING),
        'referrals' => filter_input(INPUT_POST, 'referrals', FILTER_SANITIZE_STRING),
        'patient_instructions' => filter_input(INPUT_POST, 'patient_instructions', FILTER_SANITIZE_STRING),
        'follow_up_date' => $_POST['follow_up_date']
    ];

    try {
        // Insert data using prepared statements
        $sql = "INSERT INTO soap_notes (
            patient_id, patient_name, date_of_visit, chief_complaint, history_present_illness,
            past_medical_history, family_history, social_history, review_of_systems, temperature, 
            blood_pressure, heart_rate, respiratory_rate, physical_exam_findings, lab_results, 
            imaging_results, primary_diagnosis, differential_diagnosis, medications_prescribed, 
            additional_tests, referrals, patient_instructions, follow_up_date
        ) VALUES (
            :patient_id, :patient_name, :date_of_visit, :chief_complaint, :history_present_illness,
            :past_medical_history, :family_history, :social_history, :review_of_systems, :temperature, 
            :blood_pressure, :heart_rate, :respiratory_rate, :physical_exam_findings, :lab_results, 
            :imaging_results, :primary_diagnosis, :differential_diagnosis, :medications_prescribed, 
            :additional_tests, :referrals, :patient_instructions, :follow_up_date
        )";

        $stmt = $pdo->prepare($sql);
        $stmt->execute($data);

        echo "<script>alert('New SOAP note added successfully');</script>";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add SOAP Note</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 700px;
            margin: 40px auto;
            padding: 25px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #2c3e50;
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 18px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #2c3e50;
        }
        .form-group input,
        .form-group textarea,
        .form-group select {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 6px;
            background-color: #fff;
            color: #333;
            font-size: 14px;
            outline: none;
            transition: all 0.3s ease;
            box-sizing: border-box;
        }
        .form-group input:focus,
        .form-group textarea:focus,
        .form-group select:focus{
            border-color: #3498db;
        }
        .form-group textarea {
            resize: vertical;
            min-height: 80px;
        }
        .form-group select {
            padding: 10px;
        }
        .form-group input[type="submit"] {
            background-color: #3498db;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
            border: none;
            font-weight: bold;
            transition: all 0.3s ease;
        }
        .form-group input[type="submit"]:hover {
            background-color: #2980b9;
        }
        .form-group select[multiple] {
            height: 100px;
        }
        .form-row {
            display: flex;
            gap: 15px;
        }
        .form-row .form-group {
            flex: 1;
        }
        @media (max-width: 600px) {
            .form-row {
                flex-direction: column;
            }
        }
        button {
            background-color: #3498db;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
            width: 100%;
            font-weight: bold;
        }
        button:hover {
            background-color: #2980b9;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Add SOAP Note</h1>
        <button onclick="window.location.href='index.php'">Back to Home</button>
        <br> <br> <br>
        <form method="post" action="">
            <div class="form-row">
                <div class="form-group">
                    <label>Patient ID:</label>
                    <input type="text" name="patient_id" placeholder="Enter patient ID" required>
                </div>
                <div class="form-group">
                    <label>Patient Name:</label>
                    <input type="text" name="patient_name" placeholder="Enter patient name" required>
                </div>
            </div>

            <div class="form-group">
                <label>Date of Visit:</label>
                <input type="date" name="date_of_visit" required>
            </div>

            <div class="form-group">
                <label>Chief Complaint:</label>
                <textarea name="chief_complaint" placeholder="Describe the chief complaint" required></textarea>
            </div>

            <div class="form-group">
                <label>History of Present Illness:</label>
                <textarea name="history_present_illness" placeholder="Describe the history of present illness" required></textarea>
            </div>

            <div class="form-group">
                <label>Past Medical History:</label>
                <textarea name="past_medical_history" placeholder="Enter past medical history (e.g., Hypertension, Diabetes, Asthma) / None" required></textarea>
            </div>

            <div class="form-group">
                <label>Family History:</label>
                <textarea name="family_history" placeholder="Enter family history"></textarea>
            </div>

            <div class="form-group">
                <label>Social History:</label>
                <textarea name="social_history" placeholder="Enter social history"></textarea>
            </div>

            <div class="form-group">
                <label>Review of Systems:</label>
                <textarea name="review_of_systems" placeholder="Enter review of systems"></textarea>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Temperature (°F):</label>
                    <input type="number" step="0.1" name="temperature" placeholder="e.g., 98.6">
                </div>
                <div class="form-group">
                    <label>Blood Pressure (mmHg):</label>
                    <input type="text" name="blood_pressure" placeholder="e.g., 120/80">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Heart Rate (bpm):</label>
                    <input type="number" name="heart_rate" placeholder="e.g., 72">
                </div>
                <div class="form-group">
                    <label>Respiratory Rate:</label>
                    <input type="number" name="respiratory_rate" placeholder="e.g., 16">
                </div>
            </div>

            <div class="form-group">
                <label>Physical Exam Findings:</label>
                <textarea name="physical_exam_findings" placeholder="Enter physical exam findings"></textarea>
            </div>

            <div class="form-group">
                <label>Lab Results:</label>
                <textarea name="lab_results" placeholder="Enter lab results"></textarea>
            </div>

            <div class="form-group">
                <label>Imaging Results:</label>
                <textarea name="imaging_results" placeholder="Enter imaging results"></textarea>
            </div>

            <div class="form-group">
                <label>Primary Diagnosis:</label>
                <input type="text" name="primary_diagnosis" placeholder="Enter primary diagnosis">
            </div>

            <div class="form-group">
                <label>Differential Diagnosis:</label>
                <textarea name="differential_diagnosis" placeholder="Enter differential diagnosis"></textarea>
            </div>

            <div class="form-group">
                <label>Medications Prescribed:</label>
                <textarea name="medications_prescribed" placeholder="List medications prescribed"></textarea>
            </div>

            <div class="form-group">
                <label>Additional Tests:</label>
                <textarea name="additional_tests" placeholder="Enter additional tests"></textarea>
            </div>

            <div class="form-group">
                <label>Referrals:</label>
                <textarea name="referrals" placeholder="Enter referrals"></textarea>
            </div>

            <div class="form-group">
                <label>Patient Instructions:</label>
                <textarea name="patient_instructions" placeholder="Enter patient instructions"></textarea>
            </div>

            <div class="form-group">
                <label>Follow-up Date:</label>
                <input type="date" name="follow_up_date">
            </div>

            <div class="form-group">
                <input type="submit" value="Add SOAP Note">
            </div>
        </form>
    </div>
</body>
</html>
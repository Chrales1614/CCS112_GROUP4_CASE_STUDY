<?php
session_start();
require 'db.php';

try {
    // Fetch patients
    $stmt = $pdo->query("SELECT id, name FROM patients");
    $patients = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Get patient ID and pagination data
    $patient_id = isset($_GET['patient_id']) ? (int)$_GET['patient_id'] : null;
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $notes_per_page = 10;
    $offset = ($page - 1) * $notes_per_page;

    if ($patient_id) {
        $stmt = $pdo->prepare("SELECT * FROM soap_notes WHERE patient_id = :patient_id ORDER BY created_at DESC LIMIT :offset, :limit");
        $stmt->bindParam(':patient_id', $patient_id, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->bindParam(':limit', $notes_per_page, PDO::PARAM_INT);
        $stmt->execute();
        $soap_notes = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $soap_notes = [];
    }
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SOAP Notes</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #ecf0f3;
            color: #333;
            margin: 0;
            padding: 20px;
        }

        h1, h2, h3 {
            color: #2c3e50;
        }

        .container {
            max-width: 900px;
            background: #fff;
            margin: 30px auto;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0px 10px 25px rgba(0, 0, 0, 0.15);
            transition: 0.3s ease-in-out;
        }

        .container:hover {
            transform: translateY(-5px);
        }

        button {
            background-color: #3498db;
            color: white;
            font-size: 1em;
            font-weight: 600;
            padding: 10px 15px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }

        button:hover {
            background-color: #2980b9;
            transform: scale(1.05);
        }

        .note {
            background: #ffffff;
            border-left: 5px solid #3498db;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 12px;
            box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease-in-out;
        }

        .note:hover {
            transform: translateY(-3px);
            box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.15);
        }

        .note-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid #3498db;
            padding-bottom: 10px;
            margin-bottom: 15px;
        }

        .note-header h2 {
            font-size: 1.8em;
            color: #2c3e50;
            margin: 0;
        }

        small {
            font-size: 0.9em;
            color: #7f8c8d;
        }

        #pagination {
            text-align: center;
            margin-top: 30px;
        }

        #pagination a {
            display: inline-block;
            text-decoration: none;
            background-color: #fff;
            color: #3498db;
            padding: 10px 15px;
            margin: 0 5px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-weight: bold;
            transition: all 0.3s ease-in-out;
        }

        #pagination a.active {
            background-color: #3498db;
            color: #fff;
        }

        #pagination a:hover {
            background-color: #2980b9;
            color: #fff;
            transform: scale(1.1);
        }

        .form-container {
            background: #fff;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        label {
            font-weight: bold;
            font-size: 1.1em;
        }

        select, button {
            padding: 12px;
            font-size: 1em;
            border: 1px solid #ddd;
            border-radius: 6px;
        }

        select {
            background: #fff;
            color: #333;
            cursor: pointer;
        }

        button {
            background-color: #3498db;
            color: white;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.3s ease-in-out;
        }

        button:hover {
            background-color: #2980b9;
        }

        p {
            font-size: 1em;
            line-height: 1.6;
            color: #34495e;
            margin-bottom: 15px;
            padding: 2%;
            background:rgb(255, 255, 255);
            border-left: 5px solid #3498db;
            border-radius: 3px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>SOAP Notes<?= $patient_id ? " for " . htmlspecialchars($patients[array_search($patient_id, array_column($patients, 'id'))]['name']) : "" ?></h1>
        <button onclick="window.location.href='index.php'">Back to Home</button>
        <?php if ($patient_id): ?>
            <button onclick="window.location.href='add_soap.php?patient_id=<?= htmlspecialchars($patient_id) ?>'">Add New SOAP Note</button>
        <?php endif; ?>
    </div>

    <?php if (isset($_SESSION['user_id']) && !$patient_id): ?>
        <div class="form-container">
            <h2>View SOAP Notes by Patient</h2>
            <form action="view_soap.php" method="GET">
                <label for="patient_id">Select Patient:</label>
                <select name="patient_id" id="patient_id" required>
                    <option value="" disabled selected>Choose a patient</option>
                    <?php foreach ($patients as $patient): ?>
                        <option value="<?= htmlspecialchars($patient['id']) ?>">
                            <?= htmlspecialchars($patient['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <button type="submit">View SOAP Notes</button>
            </form>
        </div>
    <?php endif; ?>

    <?php if ($patient_id !== null): ?>
        <?php if (empty($soap_notes)): ?>
            <p>No SOAP notes available for this patient.</p>
        <?php else: ?>
            <?php foreach ($soap_notes as $note): ?>
                <div class="note">
                    <h2>SOAP Note</h2>
                    <small><strong>ID:</strong> <?= htmlspecialchars($note['id']) ?> | <strong>Created at:</strong> <?= htmlspecialchars($note['created_at']) ?></small>
                    
                    <hr>
                    
                    <!-- Subjective Section -->
                    <h3>Subjective</h3>
                    <p><strong>Date of Visit:</strong> <?= htmlspecialchars($note['date_of_visit']) ?></p>
                    <p><strong>Chief Complaint:</strong> <?= htmlspecialchars($note['chief_complaint']) ?></p>
                    <p><strong>History of Present Illness:</strong> <?= htmlspecialchars($note['history_present_illness']) ?></p>
                    <p><strong>Past Medical History:</strong> <?= htmlspecialchars($note['past_medical_history']) ?></p>
                    <p><strong>Review of Systems:</strong> <?= htmlspecialchars($note['review_of_systems']) ?></p>
                    
                    <hr>

                    <!-- Objective Section -->
                    <h3>Objective</h3>
                    <p><strong>Vital Signs:</strong></p>
                    <ul>
                        <li><strong>Temperature:</strong> <?= htmlspecialchars($note['temperature']) ?> °C</li>
                        <li><strong>Blood Pressure:</strong> <?= htmlspecialchars($note['blood_pressure']) ?> mmHg</li>
                        <li><strong>Heart Rate:</strong> <?= htmlspecialchars($note['heart_rate']) ?> bpm</li>
                        <li><strong>Respiratory Rate:</strong> <?= htmlspecialchars($note['respiratory_rate']) ?> breaths/min</li>
                    </ul>
                    <p><strong>Physical Exam Findings:</strong> <?= htmlspecialchars($note['physical_exam_findings']) ?></p>
                    <p><strong>Lab Results:</strong> <?= htmlspecialchars($note['lab_results']) ?></p>
                    <p><strong>Imaging Results:</strong> <?= htmlspecialchars($note['imaging_results']) ?></p>
                    
                    <hr>

                    <!-- Assessment Section -->
                    <h3>Assessment</h3>
                    <p><strong>Primary Diagnosis:</strong> <?= htmlspecialchars($note['primary_diagnosis']) ?></p>
                    <p><strong>Differential Diagnosis:</strong> <?= htmlspecialchars($note['differential_diagnosis']) ?></p>
                    
                    <hr>

                    <!-- Plan Section -->
                    <h3>Plan</h3>
                    <p><strong>Medications Prescribed:</strong> <?= htmlspecialchars($note['medications_prescribed']) ?></p>
                    <p><strong>Additional Tests Ordered:</strong> <?= htmlspecialchars($note['additional_tests']) ?></p>
                    <p><strong>Referrals:</strong> <?= htmlspecialchars($note['referrals']) ?></p>
                    <p><strong>Patient Instructions:</strong> <?= htmlspecialchars($note['patient_instructions']) ?></p>
                    <p><strong>Follow-Up Date:</strong> <?= htmlspecialchars($note['follow_up_date']) ?></p>
                </div>

            <?php endforeach; ?>


            <?php
            $stmt = $pdo->prepare("SELECT COUNT(*) as total_notes FROM soap_notes WHERE patient_id = ?");
            $stmt->execute([$patient_id]);
            $totalNotes = $stmt->fetchColumn();
            $totalPages = ceil($totalNotes / $notes_per_page);
            ?>
            
            <div id='pagination'>
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <a href='?patient_id=<?= $patient_id ?>&page=<?= $i ?>' class='<?= ($i == $page ? "active" : "") ?>'><?= $i ?></a>
                <?php endfor; ?>
            </div>
        <?php endif; ?>
    <?php endif; ?>
</body>
</html>
<?php
require 'db.php';

// Handle search functionality
$search = isset($_GET['search']) ? $_GET['search'] : '';
$query = "SELECT * FROM patients";
if ($search) {
    $query .= " WHERE name LIKE :search";
}

$stmt = $pdo->prepare($query);
if ($search) {
    $stmt->execute(['search' => "%$search%"]);
} else {
    $stmt->execute();
}
$patients = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Patients</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .actions a {
            margin-right: 10px;
        }
    </style>
</head>
<body>
    <h1>Patient List</h1>
    <form method="GET" action="view_patients.php">
        <label for="search">Search:</label>
        <input type="text" id="search" name="search" value="<?= htmlspecialchars($search) ?>">
        <input type="submit" value="Search">
    </form>
    <br>
    <button onclick="window.location.href='add_patient.html'">Add Patient</button>
    <br><br>
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Age</th>
            <th>Actions</th>
        </tr>
        <?php if ($patients): ?>
            <?php foreach ($patients as $patient): ?>
                <tr>
                    <td><?= htmlspecialchars($patient['id']) ?></td>
                    <td><?= htmlspecialchars($patient['name']) ?></td>
                    <td><?= htmlspecialchars($patient['age']) ?></td>
                    <td class="actions">
                        <a href="update_patient.html?id=<?= htmlspecialchars($patient['id']) ?>">Edit</a>
                        <a href="delete_patient.php?id=<?= htmlspecialchars($patient['id']) ?>">Delete</a>
                        <a href="view_soap.php?patient_id=<?= htmlspecialchars($patient['id']) ?>">SOAP Notes</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="4">No patients found.</td>
            </tr>
        <?php endif; ?>
    </table>
    <br>
    <button onclick="window.location.href='index.php'">Back to Home</button>
</body>
</html>
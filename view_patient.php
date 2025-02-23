<?php
require 'db.php';

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
        /* General Styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 2rem;
        }

        h1 {
            color: #333;
        }

        /* Form Styles */
        form {
            display: flex;
            gap: 1rem;
            margin-bottom: 2rem;
        }

        input[type="text"] {
            padding: 0.75rem;
            border: 1px solid #ccc;
            border-radius: 20px;
            font-size: 1rem;
            width: 20rem;
        }

        input[type="submit"] {
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 20px;
            background-color: #007BFF;
            color: white;
            font-size: 1rem;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        /* Button Styles */
        button {
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 20px;
            background-color: #28a745;
            color: white;
            font-size: 1rem;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        button:hover {
            background-color: #218838;
        }

        /* Table Styles */
        table {
            width: 100%;
            max-width: 800px;
            border-collapse: collapse;
            margin-bottom: 2rem;
        }

        table, th, td {
            border: 1px solid #ccc;
        }

        th, td {
            padding: 1rem;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
            color: #333;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        /* Action Links */
        .actions a {
            margin-right: 1rem;
            color: #007BFF;
            text-decoration: none;
            font-weight: bold;
        }

        .actions a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <h1>Patient List</h1>
    
    <form method="GET" action="view_patient.php">
        <label for="search">Search:</label>
        <input type="text" id="search" name="search" value="<?= htmlspecialchars($search) ?>">
        <input type="submit" value="Search">
    </form>

    <br>
    <button onclick="window.location.href='add_patient.php'">Add Patient</button>
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
                        <a href="update_patient.php?id=<?= htmlspecialchars($patient['id']) ?>">Edit</a>
                        <a href="#" onclick="confirmDelete(<?= htmlspecialchars($patient['id']) ?>)">Delete</a>
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

    <script>
        function confirmDelete(id) {
            if (confirm('Are you sure you want to delete this patient?')) {
                fetch('delete_patient.php?id=' + id)
                    .then(response => response.text())
                    .then(data => {
                        if (data === 'success') {
                            alert('Patient deleted successfully.');
                            window.location.href = 'view_patient.php';
                        } else {
                            alert('Error deleting patient.');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Error deleting patient.');
                    });
            }
        }

        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.get('updated') === 'true') {
            alert('Patient updated successfully.');
            window.history.replaceState(null, null, window.location.pathname);
        }
    </script>
</body>
</html>
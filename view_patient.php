<?php
require 'db.php';

$search = isset($_GET['search']) ? $_GET['search'] : '';
$query = "SELECT * FROM patients";

if ($search) {
    $query .= " WHERE id LIKE :search OR name LIKE :search OR age LIKE :search";
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
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        h1 {
            color: #2c3e50;
        }
        form {
            margin-bottom: 20px;
        }
        input[type="text"] {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            width: 200px;
        }
        input[type="submit"], button {
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            background-color: #3498db;
            color: white;
            cursor: pointer;
        }
        input[type="submit"]:hover, button:hover {
            background-color: #2980b9;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #3498db;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .actions a {
            margin-right: 10px;
            color: #3498db;
            text-decoration: none;
        }
        .actions a:hover {
            text-decoration: underline;
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
                            window.location.href = 'view_patients.php';
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

        document.getElementById('search').addEventListener('input', function() {
            const searchValue = this.value.toLowerCase();
            const rows = document.querySelectorAll('table tr:not(:first-child)');
            rows.forEach(row => {
                const id = row.cells[0].textContent.toLowerCase();
                const name = row.cells[1].textContent.toLowerCase();
                const age = row.cells[2].textContent.toLowerCase();
                if (id.includes(searchValue) || name.includes(searchValue) || age.includes(searchValue)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    </script>
</body>
</html>
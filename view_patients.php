<?php

require 'db.php';

$search = isset($_GET['search']) ? $_GET['search'] : '';
$query = "SELECT id, name, dob, gender, phone_primary, email FROM patients";

if ($search) {
    $query .= " WHERE id LIKE :search OR name LIKE :search OR phone_primary LIKE :search OR email LIKE :search";
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
        .sidebar {
            width: 200px;
            padding: 20px;
            background-color: #2c3e50;
            color: #fff;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
        }
        .sidebar h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .sidebar a {
            display: block;
            color: #fff;
            padding: 10px;
            text-decoration: none;
            margin-bottom: 10px;
            border-radius: 4px;
        }
        .sidebar a:hover {
            background-color: #3498db;
        }
        .container {
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Patient List</h1>
        
        <form method="GET" action="view_patients.php">
            <label for="search">Search:</label>
            <input type="text" id="search" name="search" value="<?= htmlspecialchars($search) ?>">
            <input type="submit" value="Search">
        </form>

        <br>
        <button onclick="window.location.href='add_patient.php'">Add Patient</button>
        <br><br>

        <table border="1" cellspacing="0" cellpadding="5">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Age</th>
                <th>Gender</th>
                <th>Phone</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
            <?php if ($patients): ?>
                <?php foreach ($patients as $patient): ?>
                    <tr>
                        <td><?= htmlspecialchars($patient['id']) ?></td>
                        <td><?= htmlspecialchars($patient['name']) ?></td>
                        <td>
                            <?php
                            if ($patient['dob']) {
                                $dob = new DateTime($patient['dob']);
                                $today = new DateTime();
                                $age = $today->diff($dob)->y;
                                echo $age;
                            } else {
                                echo "N/A";
                            }
                            ?>
                        </td>
                        <td><?= htmlspecialchars(ucfirst($patient['gender'])) ?></td>
                        <td><?= htmlspecialchars($patient['phone_primary']) ?></td>
                        <td><?= htmlspecialchars($patient['email']) ?></td>
                        <td class="actions">
                            <a href="update_patient.php?id=<?= htmlspecialchars($patient['id']) ?>">Edit</a>
                            <a href="#" onclick="confirmDelete(<?= htmlspecialchars($patient['id']) ?>)">Delete</a>
                            <a href="view_soap.php?patient_id=<?= htmlspecialchars($patient['id']) ?>">SOAP Notes</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7">No patients found.</td>
                </tr>
            <?php endif; ?>
        </table>

        <br>
        <button onclick="window.location.href='index.php'">Back to Home</button>
    </div>
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
                const phone = row.cells[4].textContent.toLowerCase();
                const email = row.cells[5].textContent.toLowerCase();
                if (id.includes(searchValue) || name.includes(searchValue) || phone.includes(searchValue) || email.includes(searchValue)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    </script>
</body>
</html>

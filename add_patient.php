<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name']);
    $age = intval($_POST['age']);

    if (!empty($name) && $age > 0) {
        try {
            $stmt = $pdo->prepare("INSERT INTO patients (name, age) VALUES (:name, :age)");
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':age', $age);
            $stmt->execute();
            
            // Redirect with success message
            echo "<script>alert('Patient added successfully!'); window.location.href='view_patients.php';</script>";
            exit();
        } catch (PDOException $e) {
            echo "<script>alert('Error: " . $e->getMessage() . "');</script>";
        }
    } else {
        echo "<script>alert('Please provide valid name and age.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Patient</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Add Patient</h1>
        <form method="post" action="add_patient.php">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="age">Age:</label>
                <input type="number" id="age" name="age" required>
            </div>
            <div class="form-group">
                <input type="submit" value="Add Patient">
            </div>
        </form>
        <button onclick="window.location.href='index.php'">Back to Home</button>
    </div>
</body>
</html>
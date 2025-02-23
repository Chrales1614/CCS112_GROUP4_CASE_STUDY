<?php
require 'db.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
    $age = filter_input(INPUT_POST, 'age', FILTER_SANITIZE_NUMBER_INT);

    if ($id && $name && $age) {
        try {
            $stmt = $pdo->prepare("UPDATE patients SET name = ?, age = ? WHERE id = ?");
            if ($stmt->execute([$name, $age, $id])) {
                $message = "Patient updated successfully.";
            } else {
                $message = "Error updating patient.";
            }
        } catch (PDOException $e) {
            $message = "Database error: " . $e->getMessage();
        }
    } else {
        $message = "Invalid input.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Patient</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Update Patient</h1>
    <?php if ($message): ?>
        <p><?php echo htmlspecialchars($message); ?></p>
    <?php endif; ?>
    <form method="POST" action="update_patient.php">
        <input type="hidden" name="id" id="patient_id">
        <label for="name">Name:</label>
        <input type="text" name="name" id="name" required><br>
        <label for="age">Age:</label>
        <input type="number" name="age" id="age" required><br>
        <input type="submit" value="Update Patient">
    </form>
    <br>
    <button onclick="window.location.href='index.php'">Back to Home</button>
    
    <script>
        const urlParams = new URLSearchParams(window.location.search);
        document.getElementById("patient_id").value = urlParams.get("id");
    </script>
</body>
</html>
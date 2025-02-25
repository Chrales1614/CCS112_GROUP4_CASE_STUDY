<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
    $dob = filter_input(INPUT_POST, 'dob', FILTER_SANITIZE_STRING);
    $gender = filter_input(INPUT_POST, 'gender', FILTER_SANITIZE_STRING);
    $phone_primary = filter_input(INPUT_POST, 'phone_primary', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);

    if ($id && $name && $dob && $gender && $phone_primary && $email) {
        try {
            $stmt = $pdo->prepare("UPDATE patients SET name = ?, dob = ?, gender = ?, phone_primary = ?, email = ? WHERE id = ?");
            if ($stmt->execute([$name, $dob, $gender, $phone_primary, $email, $id])) {
                header("Location: view_patients.php?updated=true");
                exit();
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

$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
$patient = null;

if ($id) {
    $stmt = $pdo->prepare("SELECT * FROM patients WHERE id = ?");
    $stmt->execute([$id]);
    $patient = $stmt->fetch();
}

if (!$patient) {
    die("Patient not found.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Patient</title>
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
        .update-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: 0 auto;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            color: #2c3e50;
        }
        input[type="text"], input[type="date"], input[type="email"], select {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            width: 100%;
            box-sizing: border-box;
        }
        .btn-container {
            margin-top: 20px;
            display: flex;
            justify-content: space-between;
        }
        .btn-primary, .btn-secondary {
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            text-align: center;
        }
        .btn-primary {
            background-color: #3498db;
            color: white;
        }
        .btn-primary:hover {
            background-color: #2980b9;
        }
        .btn-secondary {
            background-color: #3498db;
            color: white;
        }
        .btn-secondary:hover {
            background-color: #2980b9;
        }
        p {
            color: red;
        }
    </style>
</head>
<body>
    <div class="update-container">
        <h1>Update Patient</h1>
        <?php if (!empty($message)): ?>
            <p><?php echo htmlspecialchars($message); ?></p>
        <?php endif; ?>
        <form method="POST" action="update_patient.php">
            <input type="hidden" name="id" value="<?= htmlspecialchars($patient['id']) ?>">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" name="name" id="name" value="<?= htmlspecialchars($patient['name']) ?>" required>
            </div>
            <div class="form-group">
                <label for="dob">Date of Birth:</label>
                <input type="date" name="dob" id="dob" value="<?= htmlspecialchars($patient['dob']) ?>" required>
            </div>
            <div class="form-group">
                <label for="gender">Gender:</label>
                <select name="gender" id="gender" required>
                    <option value="male" <?= $patient['gender'] == 'male' ? 'selected' : '' ?>>Male</option>
                    <option value="female" <?= $patient['gender'] == 'female' ? 'selected' : '' ?>>Female</option>
                    <option value="other" <?= $patient['gender'] == 'other' ? 'selected' : '' ?>>Other</option>
                </select>
            </div>
            <div class="form-group">
                <label for="phone_primary">Phone:</label>
                <input type="text" name="phone_primary" id="phone_primary" value="<?= htmlspecialchars($patient['phone_primary']) ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" name="email" id="email" value="<?= htmlspecialchars($patient['email']) ?>" required>
            </div>
            <div class="btn-container">
                <button type="button" class="btn-secondary" onclick="window.location.href='index.php'">Back to Home</button>
                <button type="submit" class="btn-primary">Update Patient</button>
            </div>
        </form>
    </div>
</body>
</html>
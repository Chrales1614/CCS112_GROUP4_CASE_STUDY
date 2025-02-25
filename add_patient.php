<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name']);
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];
    $address = trim($_POST['address']);
    $phone_primary = trim($_POST['phone_primary']);
    $phone_alternate = trim($_POST['phone_alternate']);
    $email = trim($_POST['email']);

    if (!empty($name) && !empty($dob) && !empty($gender) && !empty($address) && !empty($phone_primary) && !empty($email)) {
        try {
            $stmt = $pdo->prepare("INSERT INTO patients (name, dob, gender, address, phone_primary, phone_alternate, email) VALUES (:name, :dob, :gender, :address, :phone_primary, :phone_alternate, :email)");
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':dob', $dob);
            $stmt->bindParam(':gender', $gender);
            $stmt->bindParam(':address', $address);
            $stmt->bindParam(':phone_primary', $phone_primary);
            $stmt->bindParam(':phone_alternate', $phone_alternate);
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            
            // Redirect with success message
            echo "<script>alert('Patient added successfully!'); window.location.href='view_patients.php';</script>";
            exit();
        } catch (PDOException $e) {
            echo "<script>alert('Error: " . $e->getMessage() . "');</script>";
        }
    } else {
        echo "<script>alert('Please provide all required fields.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Patient</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #2c3e50;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            color: #2c3e50;
        }
        .form-group input[type="text"],
        .form-group input[type="number"],
        .form-group input[type="date"],
        .form-group input[type="email"],
        .form-group select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        .form-group input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #3498db;
            border: none;
            border-radius: 4px;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
        }
        .form-group input[type="submit"]:hover {
            background-color: #2980b9;
        }
        button {
            display: block;
            width: 100%;
            padding: 10px;
            background-color: #3498db;
            border: none;
            border-radius: 4px;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
            margin-top: 10px;
        }
        button:hover {
            background-color: #2980b9;
        }
    </style>
</head>
<body>
<div class="container">
        <h1>Add Patient</h1>
        <button onclick="window.location.href='index.php'">Back to Home</button>
        <br><br>
        <form method="post" action="add_patient.php">
            <div class="form-group">
                <label for="name">Full Name:</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="dob">Date of Birth:</label>
                <input type="date" id="dob" name="dob" required>
            </div>
            <div class="form-group">
                <label for="gender">Gender:</label>
                <select id="gender" name="gender" required>
                    <option value="">Select Gender</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                </select>
            </div>
            <div class="form-group">
                <label for="address">Home Address:</label>
                <input type="text" id="address" name="address" placeholder="Street, City, State/Province, Postal Code, Country" required>
            </div>
            <div class="form-group">
                <label for="phone_primary">Primary Phone Number:</label>
                <input type="text" id="phone_primary" name="phone_primary" placeholder="e.g., +63 912-345-6789" required>
            </div>
            <div class="form-group">
                <label for="phone_alternate">Alternate Phone Number:</label>
                <input type="text" id="phone_alternate" name="phone_alternate" placeholder="e.g., +63 912-345-6789">
            </div>
            <div class="form-group">
                <label for="email">Email Address:</label>
                <input type="email" id="email" name="email" placeholder="e.g., john.smith@email.com" required>
            </div>
            <div class="form-group">
                <input type="submit" value="Add Patient">
            </div>
        </form>
        <button onclick="window.location.href='view_patients.php'">View Patients</button>
    </div>
</body>
</html>
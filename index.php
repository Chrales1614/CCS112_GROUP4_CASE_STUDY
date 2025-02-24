<?php
session_start();
require 'db.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medical Clinic SOAP System</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            text-align: center;
        }
        .container {
            width: 50%;
            margin: auto;
        }
        .nav {
            margin-bottom: 20px;
        }
        .nav a {
            margin: 0 10px;
            text-decoration: none;
            padding: 10px;
            background: #3BBA9C;
            color: white;
            border-radius: 5px;
        }
        .nav a:hover {
            background: #2E3047;
        }
        .nav a:hover {
            background: #2E3047;
        }
    </style>
</head>
<body>

    <h1>Welcome to the Medical Clinic SOAP System</h1>
    
    <div class="nav">
        <?php if (isset($_SESSION['user_id'])): ?>
            <a href="view_patients.php">View Patients</a>
            <a href="add_patient.php">Add Patient</a>
            <a href="add_soap.php">Add SOAP Notes</a>
            <a href="view_soap.php">View SOAP Notes</a>
            <a href="logout.php">Logout</a>
        <?php else: ?>
            <a href="login.html">Login</a>
            <a href="register.html">Register</a>
        <?php endif; ?>
    </div>

    <p>This system allows medical professionals to manage patient records and create SOAP notes efficiently.</p>

</body>
</html>

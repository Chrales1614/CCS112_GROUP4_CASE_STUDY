<?php
session_start();
require 'db.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medical Clinic Management System</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 1000px;
            margin: 50px auto;
            background: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #2c3e50;
            margin-bottom: 20px;
        }
        .nav {
            display: flex;
            justify-content: space-around;
            background: #3498db;
            padding: 10px 0;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .nav a {
            color: white;
            text-decoration: none;
            padding: 12px 20px;
            font-size: 16px;
            font-weight: bold;
            transition: background 0.3s;
            border-radius: 5px;
            display: flex;
            align-items: center;
        }
        .nav a i {
            margin-right: 8px;
        }
        .nav a:hover {
            background: #2980b9;
        }
        .welcome-text {
            font-size: 18px;
            margin-bottom: 20px;
        }
        .footer {
            margin-top: 30px;
            font-size: 14px;
            color: #666;
            text-align: center;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Medical Clinic Management System</h1>
    
    <div class="nav">
        <?php if (isset($_SESSION['user_id'])): ?>
            <a href="view_patients.php"><i class="fas fa-users"></i> Patients</a>
            <a href="add_patient.php"><i class="fas fa-user-plus"></i> Add Patient</a>
            <a href="add_soap.php"><i class="fas fa-notes-medical"></i> New SOAP Note</a>
            <a href="view_soap.php"><i class="fas fa-file-medical-alt"></i> SOAP Notes</a>
            <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
        <?php else: ?>
            <a href="login.php"><i class="fas fa-sign-in-alt"></i> Login</a>
            <a href="register.php"><i class="fas fa-user-plus"></i> Register</a>
        <?php endif; ?>
    </div>

    <p class="welcome-text">
        Welcome to the Medical Clinic Management System, a streamlined platform for managing patient records 
        and creating comprehensive SOAP notes efficiently.
    </p>

    <div class="footer">
        &copy; <?= date("Y") ?> Medical Clinic. All rights reserved.
    </div>
</div>

</body>
</html>
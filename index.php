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
            background: url('https://source.unsplash.com/1600x900/?medical') no-repeat center center fixed;
            background-size: cover;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 800px;
            margin: 5px auto;
            padding: 200px;
            background: rgba(255, 255, 255, 0.9);
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #2c3e50;
            margin-bottom: 20px;
            text-align: center;
        }
        .nav {
            display: flex;
            flex-direction: row;
            background: #3498db;
            padding: 10px 0;
            border-radius: 5px;
            margin-bottom: 20px;
            justify-content: space-around;
        }
        .nav form {
            margin: 0;
        }
        .nav button {
            background: url('https://source.unsplash.com/1600x900/?medical') no-repeat center center;
            background-size: cover;
            border: none;
            color: white;
            text-decoration: none;
            padding: 20px;
            font-size: 16px;
            font-weight: bold;
            transition: background 0.3s, transform 0.3s;
            border-radius: 5px;
            display: flex;
            align-items: center;
            cursor: pointer;
            position: relative;
            overflow: hidden;
            justify-content: center;
        }
        .nav button i {
            margin-right: 8px;
        }
        .nav button:hover {
            background-position: right center;
            transform: translateX(10px);
        }
        .nav button::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: inherit;
            z-index: -1;
            transform: translateZ(-1px) scale(2);
            filter: blur(10px);
        }
        .welcome-text {
            font-size: 18px;
            margin-bottom: 20px;
            text-align: center;
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
            <form action="view_patients.php" method="get">
                <button type="submit"><i class="fas fa-users"></i> Patients</button>
            </form>
            <form action="add_patient.php" method="get">
                <button type="submit"><i class="fas fa-user-plus"></i> Add Patient</button>
            </form>
            <form action="view_soap.php" method="get">
                <button type="submit"><i class="fas fa-file-medical-alt"></i> SOAP Notes</button>
            </form>
            <form action="logout.php" method="get">
                <button type="submit"><i class="fas fa-sign-out-alt"></i> Logout</button>
            </form>
        <?php else: ?>
            <form action="login.php" method="get">
                <button type="submit"><i class="fas fa-sign-in-alt"></i> Login</button>
            </form>
            <form action="register.php" method="get">
                <button type="submit"><i class="fas fa-user-plus"></i> Register</button>
            </form>
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
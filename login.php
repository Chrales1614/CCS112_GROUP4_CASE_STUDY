<?php
session_start([
    'cookie_lifetime' => 86400, // 1 day (adjust according to your needs)
    'cookie_secure' => true, // Ensure HTTPS
    'cookie_samesite' => 'Lax', // Protect against CSRF
    'cookie_httponly' => true // Prevent JavaScript access
]);

require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];

    try {
        $stmt = $pdo->prepare("SELECT id, password FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            // Store only the user ID in the session
            $_SESSION['user_id'] = $user['id'];
            // Set a secure cookie with a token (optional, but recommended for added security)
            $token = bin2hex(random_bytes(16)); // Generate a random token
            setcookie(
                'auth_token', // Cookie name
                $token, // Token value
                [
                    'expires' => time() + 86400, // 1 day (adjust according to your needs)
                    'secure' => true, // Ensure HTTPS
                    'samesite' => 'Lax', // Protect against CSRF
                    'httponly' => true // Prevent JavaScript access
                ]
            );
            // Store the token in the user's session or database for verification
            $_SESSION['auth_token'] = $token;
            // Redirect to a protected page
            header("Location: index.php");
            exit();
        } else {
            $error = "Invalid email or password.";
        }
    } catch (PDOException $e) {
        $error = "An error occurred. Please try again later.";
        // Log the error (e.g., using a logging library or a simple log file)
        error_log($e->getMessage());
    }
}
?>

<!-- HTML remains the same, with the addition of a CSRF token (recommended) -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            color: #333;
            padding: 10%;
        }
        h2 {
            color: #2c3e50;
        }
        .container {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input[type="email"], input[type="password"] {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            width: 100%;
            box-sizing: border-box;
        }
        input[type="submit"] {
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            background-color: #3498db;
            color: white;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #2980b9;
        }
        .error {
            color: red;
            margin-bottom: 15px;
        }
        p {
            margin-top: 15px;
        }
        a {
            color: #3498db;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Login</h2>
        <?php if (isset($error)): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>
        <form method="post" action="login.php">
            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrfToken); ?>">
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" name="email" id="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" name="password" id="password" required>
            </div>
            <div class="form-group">
                <input type="submit" value="Login">
            </div>
            <p>Don't have an account? <a href="register.php">Register here!</a></p>
        </form>
    </div>
</body>
</html>
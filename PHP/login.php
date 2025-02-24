<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Mental Wellness</title>
    <link rel="stylesheet" href="../CSS/auth.css">
</head>

<body class="auth-body">
<div class="auth-container">
    <h2>Login</h2>
    <form action="index.php?action=login" method="post">
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
        </div>
        <button type="submit" class="auth-button">Login</button>
    </form>
    <p>Don't have an account? <a href="signup.php">Register here</a></p>
    <p><a href="Forgetpassword.php">Forgot Password?</a></p> <!-- Forgot password link -->
    <?php if (!empty($message)) echo "<p>" . htmlspecialchars($message) . "</p>"; ?>
</div>
</body>

</html>

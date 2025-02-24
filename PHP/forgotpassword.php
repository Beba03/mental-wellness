<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - Mental Wellness</title>
    <link rel="stylesheet" href="../CSS/auth.css">
</head>

<body class="auth-body">
<div class="auth-container">
    <h2>Forgot Password</h2>
    <form action="forgotpassword.php" method="post">
        <div class="form-group">
            <label for="email">Enter your email address:</label>
            <input type="email" id="email" name="email" required>
        </div>
        <button type="submit" class="auth-button">Reset Password</button>
    </form>
    <p><a href="login.php">Back to Login</a></p>

    <!-- Message box for errors/success -->
    <?php if (!empty($message)): ?>
        <div class="message-box">
            <?php echo htmlspecialchars($message); ?>
        </div>
    <?php endif; ?>
</div>
</body>

</html>

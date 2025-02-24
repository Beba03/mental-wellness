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
        <form id="forgetpass-form" action="index.php?action=forgetpass" method="post">

            <div class="form-group">
                <label for="email">Enter your email address:</label>
                <input type="email" id="email" name="email" required>
            </div>

            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>

            <div class="form-group">
                <label for="confirm-password">Confirm Password:</label>
                <input type="password" id="confirm-password" name="confirm-password" required>
            </div>

            <div id="error-messages" style="color: red;">
                <!-- Message box for errors/success -->
                <?php if (!empty($message)): ?>
                    <div class="message-box">
                        <?php echo htmlspecialchars($message); ?>
                    </div>
                <?php endif; ?>
            </div>

            <button type="submit" class="auth-button">Reset Password</button>
        </form>
        <p><a href="login.php">Back to Login</a></p>
    </div>

    <script>
        document.getElementById('forgetpass-form').addEventListener('submit', function(event) {
            const errorMessages = document.getElementById('error-messages');
            errorMessages.innerHTML = ''; // Clear previous messages

            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirm-password').value;
            const passwordRegex = /^(?=.*[A-Z])(?=.*[!@#$%^&*])(?=.{8,})/;
            let errors = [];
            if (!passwordRegex.test(password)) {
                errors.push('Password must be at least 8 characters long<br>contain one uppercase letter, and one special character.');
            }
            if (password !== confirmPassword) {
                errors.push('Passwords do not match.');
            }
            if (errors.length > 0) {
                event.preventDefault();
                errorMessages.innerHTML = errors.join('<br>');
            }
        });
    </script>

</body>

</html>
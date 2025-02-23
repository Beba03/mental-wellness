<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - Mental Wellness</title>
    <link rel="stylesheet" href="../CSS/auth.css">
</head>

<body class="auth-body">
    <div class="auth-container">
        <h2>Sign Up</h2>
        <form id="signup-form" action="index.php?action=signup" method="post">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email">
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="confirm-password">Confirm Password:</label>
                <input type="password" id="confirm-password" name="confirm-password" required>
            </div>
            <div class="form-group">
                <label for="gender">Gender:</label>
                <select id="gender" name="gender" required>
                    <option value="">Select Gender</option>
                    <option value="M">Male</option>
                    <option value="F">Female</option>
                    <option value="O">Other</option>
                </select>
            </div>
            <div id="error-messages" style="color: red;">
                <?php if (!empty($errors)): ?>
                    <?php foreach ($errors as $error): ?>
                        <p><?php echo htmlspecialchars($error); ?></p>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
            <button type="submit" class="auth-button">Sign Up</button>
        </form>
        <p>Already have an account? <a href="login.php">Login here</a></p>
    </div>

    <script>
        document.getElementById('signup-form').addEventListener('submit', function(event) {
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
<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Load PHPMailer

require_once("database.php");
$conn = getDatabaseConnection(); // Ensure the $conn variable is initialized

$message = ""; // Initialize message variable

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);

    if (!empty($email)) {
        // Check if the email exists in the database
        $query = "SELECT * FROM users WHERE email = ?";
        $stmt = $conn->prepare($query);

        if ($stmt === false) {
            $message = "Error: " . $conn->error;
        } else {
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result === false) {
                $message = "Error retrieving data: " . $stmt->error;
            } elseif ($result->num_rows > 0) {
                // User exists, generate a reset token
                $token = bin2hex(random_bytes(32));
                $expiry = date("Y-m-d H:i:s", strtotime("+1 hour")); // Token expires in 1 hour

                // Insert the token into the database
                $insertToken = "INSERT INTO password_resets (email, token, expires_at) VALUES (?, ?, ?)";
                $stmt2 = $conn->prepare($insertToken);

                if ($stmt2 === false) {
                    $message = "Database error: " . $conn->error;
                } else {
                    $stmt2->bind_param("sss", $email, $token, $expiry);
                    if (!$stmt2->execute()) {
                        $message = "Error inserting token: " . $stmt2->error;
                    } else {
                        // Send email with PHPMailer
                        $mail = new PHPMailer(true);

                        try {
                            // SMTP Configuration
                            $mail->isSMTP();
                            $mail->Host = 'smtp.gmail.com'; // Change for other providers
                            $mail->SMTPAuth = true;
                            $mail->Username = 'your-email@gmail.com'; // Your Gmail
                            $mail->Password = 'your-app-password'; // Generate an App Password
                            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                            $mail->Port = 587;

                            // Email settings
                            $mail->setFrom('your-email@gmail.com', 'Mental Wellness Support');
                            $mail->addAddress($email);
                            $mail->Subject = "Password Reset Request";
                            $mail->Body = "Click the link below to reset your password:\n\n http://yourwebsite.com/resetpassword.php?token=" . $token;

                            if ($mail->send()) {
                                $message = "A password reset link has been sent to your email.";
                            } else {
                                $message = "Error sending email.";
                            }
                        } catch (Exception $e) {
                            $message = "Mail Error: " . $mail->ErrorInfo;
                        }
                    }
                    $stmt2->close();
                }
            } else {
                $message = "No account found with that email.";
            }
            $stmt->close();
        }
    } else {
        $message = "Please enter a valid email address.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
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

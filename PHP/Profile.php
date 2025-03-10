<?php
ob_start();
include("headerlogic.php");
include("Header.php");
include("database.php");

// Check if user is logged in and get user ID
$user_id = isset($_SESSION['id']) ? $_SESSION['id'] : null;

// Fetch the first mood of the day
$general_mood = "Not Set"; // Default mood
if ($user_id) {
    $query = "SELECT mood FROM moods WHERE user_id = ? ORDER BY date DESC LIMIT 1";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        $general_mood = $row['mood'];
    }
    $stmt->close();
}
?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Profile - Mental Wellness</title>
        <link rel="stylesheet" href="../CSS/base.css">
        <link rel="stylesheet" href="../CSS/profile.css">
    </head>

    <body>
    <div class="profile-container">
        <div class="profile-card">
            <div class="profile-image">😊</div>
            <div class="profile-info">
                <h2><?php echo $isLoggedIn ? htmlspecialchars($_SESSION['name']) : "User"; ?></h2>
                <p>Mood of the Day:
                    <span style="color: <?php echo $general_mood === 'Very Tough' || $general_mood === 'Difficult' ? 'red' : 'green'; ?>">
                        <?php echo htmlspecialchars($general_mood); ?>
                        <?php
                        // Add emoji based on mood
                        switch ($general_mood) {
                            case 'Very Tough': echo '😞'; break;
                            case 'Difficult': echo '😣'; break;
                            case 'Average': echo '😐'; break;
                            case 'Great': echo '😊'; break;
                            case 'Amazing': echo '😊'; break;
                            default: echo '🤔';
                        }
                        ?>
                    </span>
                </p>
                <p>Email: <?php echo $isLoggedIn ? htmlspecialchars($_SESSION['email']) : "User"; ?></p>
                <p>Password: ******** <a href="Changepassword.php">Change Password</a></p>
                <form action="index.php?action=logout" method="post">
                    <button type="submit" name="logout" class="auth-button">Log out</button>
                </form>
            </div>
        </div>
    </div>
    </body>
    </html>

<?php
include("../HTML/Footer.html");
$conn->close();
ob_end_flush();
?>
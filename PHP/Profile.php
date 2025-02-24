<?php
include("headerlogic.php");
$isLoggedIn = isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn'] === true;
include("Header.php");
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
                <p>General Mood: <span style="color: green;">Happy 😊</span></p>
                <p>Email: <?php echo $isLoggedIn ? htmlspecialchars($_SESSION['email']) : "User"; ?></p>
                <p>Password: ******** <a href="#">Change Password</a></p>
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
?>
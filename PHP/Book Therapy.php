<?php
include 'headerlogic.php';
include 'Header.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book a Session - Mental Wellness</title>
    <link rel="stylesheet" href="../CSS/booking.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body>
    <div class="main-content">
        <div class="content-left">
            <img src="Mental Therapy.gif" alt="Animated Picture" class="Moving-image">
        </div>
        <div class="content-right">
            <h2>Book Your Therapy Session</h2>
            <p>Please fill in the form!</p>

             <?php if (!empty($message)) echo "<p>" . htmlspecialchars($message) . "</p>"; ?>

            <form action="index.php?action=booking" method="POST">
                <div class="input-box">
                    <i class="fas fa-calendar"></i>
                    <input type="date" id="date" name="date" required>
                </div>

                <div class="input-box">
                    <i class="fas fa-clock"></i>
                    <input type="time" id="time" name="time" required>
                </div>

                <button type="submit">Book Session</button>
            </form>
        </div>
    </div>
</body>

</html>
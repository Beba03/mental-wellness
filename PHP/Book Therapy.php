<?php
include 'headerlogic.php';
include 'Header.php';
include 'database.php';
$message = '';
if (isset($_GET['status']) && $_GET['status'] == 'success') {
    $message = "Booking successful!";
}
   
$result = $conn->query("SELECT * FROM bookings ORDER BY date ASC");
?>
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book a Session - Mental Wellness</title>
    <link rel="stylesheet" href="../CSS/booking.css">
</head>
<body>
    <div class="main-content">
        <!-- Left Side: Booking Form -->
        <div class="content-left">
            <h2>Book Your Therapy Session</h2>
            <p>Please fill in the form!</p>

            <?php if (!empty($message)): ?>
                <p class="confirmation-message"><?php echo htmlspecialchars($message); ?></p>
            <?php endif; ?>

            <form action="process_booking.php" method="POST">
                <div class="input-box">
                    <input type="email" id="email" name="email" placeholder="Your Email" required>
                </div>
                <div class="input-box">
                    <input type="date" id="date" name="date" required>
                </div>
                <div class="input-box">
                    <input type="time" id="time" name="time" required>
                </div>
                <button type="submit">Book Session</button>
            </form>
        </div>

        <!-- Right Side: Booked Sessions -->
        <div class="content-right">
            <h2>Your Booked Sessions</h2>
            <ul id="booking-list">
                <?php while ($row = $result->fetch_assoc()): ?>
                    <li><?php echo htmlspecialchars($row['email']); ?> - <?php echo htmlspecialchars($row['date']); ?> at <?php echo htmlspecialchars($row['time']); ?></li>
                <?php endwhile; ?>
            </ul>
        </div>
    </div>
</body>
</html>


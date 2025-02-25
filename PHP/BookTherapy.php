<?php
include 'headerlogic.php';
include 'Header.php';
include 'database.php';

$user_id = $_SESSION['id'];
global $conn;

// Fetch all booked slots for all users
$query = "SELECT date, time FROM bookings";
$result = $conn->query($query);

$bookedSlots = [];
while ($row = $result->fetch_assoc()) {
    $bookedSlots[] = $row['date'] . ' ' . $row['time'];
}

// Generate available dates (from today to 1 month in advance, excluding weekends)
$availableDates = [];
$today = strtotime("today");
$oneMonthLater = strtotime("+1 month");

for ($date = $today; $date <= $oneMonthLater; $date = strtotime("+1 day", $date)) {
    // Exclude weekends (Saturday = 6, Sunday = 0)
    if (date('N', $date) < 6) {
        $availableDates[] = date("Y-m-d", $date);
    }
}

// Generate available time slots (9:00 AM - 5:00 PM in 30 min increments)
$timeSlots = [];
$startTime = strtotime("09:00");
$endTime = strtotime("17:00");

for ($time = $startTime; $time < $endTime; $time += 1800) { // 1800 seconds = 30 minutes
    $timeSlots[] = date("H:i", $time);
}

// Handle booking form submission
$message = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['delete'])) {
        // Handle deletion
        $booking_id = $_POST['booking_id']; // Access the booking_id passed via the form

        // Prepare the delete query
        $deleteQuery = $conn->prepare("DELETE FROM bookings WHERE id = ? AND user_id = ?");
        $deleteQuery->bind_param("ii", $booking_id, $user_id);

        if ($deleteQuery->execute()) {
            $message = "Booking deleted successfully!";
        } else {
            $message = "Error deleting the booking.";
        }
    } else {
        // Handle booking creation
        $date = $_POST['date'];
        $time = $_POST['time'];

        // Check if the slot is already booked
        $checkQuery = $conn->prepare("SELECT COUNT(*) FROM bookings WHERE date = ? AND time = ?");
        $checkQuery->bind_param("ss", $date, $time);
        $checkQuery->execute();
        $checkQuery->bind_result($existingCount);
        $checkQuery->fetch();
        $checkQuery->close();

        if ($existingCount > 0) {
            $message = "This slot is already booked. Please choose another time.";
        } else {
            $stmt = $conn->prepare("INSERT INTO bookings (user_id, date, time) VALUES (?, ?, ?)");
            $stmt->bind_param("iss", $user_id, $date, $time);

            if ($stmt->execute()) {
                header("Location: BookTherapy.php");
                exit();
            } else {
                $message = "Error booking the slot.";
            }
        }
    }
}
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
    <div class="content-left">
        <h2>Book Your Therapy Session</h2>
        <p>Please choose an available slot from the list below:</p>

        <?php if (!empty($message)): ?>
            <p class="confirmation-message"><?php echo htmlspecialchars($message); ?></p>
        <?php endif; ?>

        <form action="BookTherapy.php" method="POST">
            <div class="input-box">
                <label for="date">Select Date:</label>
                <select name="date" required>
                    <?php foreach ($availableDates as $date): ?>
                        <option value="<?php echo $date; ?>"><?php echo date('l, F j, Y', strtotime($date)); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="input-box">
                <label for="time">Select Time:</label>
                <select name="time" required>
                    <?php foreach ($timeSlots as $time): ?>
                        <option value="<?php echo $time; ?>"><?php echo $time; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="book-button">Book Session</button>
        </form>
    </div>

    <div class="content-right">
        <h2>Your Booked Sessions</h2>
        <?php
        $query = "SELECT * FROM bookings WHERE user_id = $user_id ORDER BY date ASC, time ASC";
        $result = $conn->query($query);
        ?>
        <ul id="booking-list">
            <?php while ($row = $result->fetch_assoc()): ?>
                <li>
                    <div class="booking-details">
                        <span><?php echo htmlspecialchars($row['date']); ?> at <?php echo htmlspecialchars($row['time']); ?></span>
                        <form action="BookTherapy.php" method="POST" class="delete-form">
                            <!-- Hidden input for booking ID -->
                            <input type="hidden" name="booking_id" value="<?php echo $row['id']; ?>">
                            <button type="submit" name="delete" class="delete-button">Delete</button>
                        </form>
                    </div>
                </li>
            <?php endwhile; ?>
        </ul>
    </div>
</div>
</body>
</html>

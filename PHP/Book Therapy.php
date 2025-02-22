<?php
$db_server = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "mentalwellnessdb";
$message = "";


$conn = mysqli_connect($db_server, $db_user, $db_pass, $db_name);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $date = $_POST['date'];
    $time = $_POST['time'];

    
    $sql = "INSERT INTO bookings (name, email, date, time) VALUES ('$name', '$email', '$date', '$time')";
    if (mysqli_query($conn, $sql)) {
        $message = "Booking successful!";
    } else {
        $message = "Error: " . mysqli_error($conn);
    }
}


include 'Header.php'; 
include 'headerlogic.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book a Session</title>
    <link rel="stylesheet" href="../CSS/booking.css"> 
    <link rel="stylesheet"  href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
">
</head>
<body>
    <div class="Form-Box">
        <img src="Mental Therapy.gif" alt="Animated Picture" class="Moving-image">
        <h2>Book Your Therapy ession</h2>
        <p>Book your session right now, please fill in the form!!!</p>

        <?php if ($message): ?>
            <p class="confirmation-message"><?php echo $message; ?></p>
        <?php endif; ?>

        <form action="" method="POST">
            <div class="input-box">
                <i class="fas fa-user"></i>
                <input type="text" id="name" name="name" placeholder="Input Name" required>
            </div>

            <div class="input-box">
                <i class="fas fa-envelope"></i>
                <input type="email" id="email" name="email" placeholder="Input Email Address" required>
            </div>

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
</body>
</html>

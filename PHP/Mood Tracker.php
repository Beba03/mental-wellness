<?php
include("headerlogic.php");
include("Header.php");
include("database.php");

if (!isset($_SESSION['id']) || !isset($_SESSION['name'])) {
    header("Location: login.php");
    exit();
}

error_log("MoodTracker - Session ID: " . session_id());
error_log("MoodTracker - Session data: " . print_r($_SESSION, true));
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" type="image/x-icon" href="favicon.png" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="../CSS/moodtracker.css">
    <title>Mood Tracker</title>
</head>

<body>
    <div class="main-content">
        <div class="container">
            <div class="jumbotron bg-info text-white">
                <h1 class="display-4">Hello, <?php echo htmlspecialchars($_SESSION['name']); ?>!</h1>
                <hr class="my-4">
                <p class="lead">Welcome to your daily mood tracker. How do you feel today?</p>
            </div>

            <div class="card">
                <div class="card-body">
                    Today is: <h4 id="activeDate"><?php echo date('d F Y'); ?></h4>
                </div>
            </div>

            <div class="form-group">
                <label for="commentInput">Add Your Comment for Today:</label>
                <textarea class="form-control" id="commentInput" rows="3" placeholder="Share your thoughts..."></textarea>
            </div>

            <div class="form-group">
                <label for="emotionSelect">Select Emotion for Today:</label>
                <select class="form-control" id="emotionSelect">
                    <option value="1">Very Tough</option>
                    <option value="2">Difficult</option>
                    <option value="3">Average</option>
                    <option value="4">Great</option>
                    <option value="5">Amazing</option>
                </select>
            </div>

            <button id="logMood" class="btn btn-primary btn-lg mt-3">Log Mood</button>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const moodSelect = document.querySelector("#emotionSelect");
            const commentInput = document.querySelector("#commentInput");
            const logButton = document.querySelector("#logMood");

            if (!logButton) {
                console.error("Log Mood button not found!");
                return;
            }

            const moodDescriptions = {
                1: "Very Tough",
                2: "Difficult",
                3: "Average",
                4: "Great",
                5: "Amazing"
            };

            logButton.addEventListener("click", function() {
                console.log("Button clicked!");
                const moodValue = moodSelect.value;
                const comment = commentInput.value.trim();
                const moodDescription = moodDescriptions[moodValue];

                if (!moodDescription) {
                    alert("Invalid mood selected.");
                    return;
                }

                const today = new Date();
                const date = today.getFullYear() + '-' +
                    String(today.getMonth() + 1).padStart(2, '0') + '-' +
                    String(today.getDate()).padStart(2, '0');

                const moodEntry = {
                    mood: moodDescription,
                    comment: comment,
                    date: date
                };

                console.log("Sending:", moodEntry);

                fetch("log_mood.php", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json"
                        },
                        body: JSON.stringify(moodEntry),
                        credentials: 'same-origin' // Ensure session cookie is included
                    })
                    .then(response => {
                        console.log("Response status:", response.status);
                        if (!response.ok) throw new Error("HTTP error " + response.status);
                        return response.json();
                    })
                    .then(data => {
                        console.log("Response data:", data);
                        if (data.success) {
                            alert("Mood successfully recorded!");
                            commentInput.value = "";
                            moodSelect.value = "1";
                        } else {
                            alert("Error logging mood: " + (data.message || "Unknown error"));
                        }
                    })
                    .catch(error => {
                        console.error("Fetch error:", error);
                        alert("An error occurred: " + error.message);
                    });
            });
        });
    </script>
</body>
</html>

<?php 
    include("../HTML/Footer.html"); 
?>
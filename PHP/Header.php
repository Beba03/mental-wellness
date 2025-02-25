<link rel="stylesheet" href="../CSS/base.css">
<link rel="stylesheet" href="../CSS/header.css">

<div class="header">
    <div class="logo">
        <a href="Landing.php">Mental Wellness</a>
    </div>
    <div class="navbar">
        <a href="Mood Tracker.php" class="<?php echo $current_page == 'Mood Tracker.php' ? 'active' : ''; ?>">Mood Tracker</a>
        <a href="AI Chatbot.php" class="<?php echo $current_page == 'AI Chatbot.php' ? 'active' : ''; ?>">AI Chatbot</a>
        <a href="resources.php" class="<?php echo $current_page == 'resources.php' ? 'active' : ''; ?>">Resources</a>
        <a href="BookTherapy.php" class="<?php echo $current_page == 'BookTherapy.php' ? 'active' : ''; ?>">Book Therapy</a>
    </div>
    <div class="user-options">
        <a href="#" id="profile-link">Profile</a>
    </div>
</div>
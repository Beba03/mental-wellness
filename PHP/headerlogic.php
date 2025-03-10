<?php
    ob_start();
    session_start();
    $isLoggedIn = isset($_SESSION['id']);
    $current_page = basename($_SERVER['PHP_SELF']);
?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('profile-link').addEventListener('click', function(event) {
            event.preventDefault();
            var isLoggedIn = <?php echo json_encode($isLoggedIn); ?>;

            if (isLoggedIn) {
                window.location.href = './Profile.php'; // Redirect to profile page
            } else {
                window.location.href = './login.php'; // Redirect to login page
            }
        });
    });
</script>
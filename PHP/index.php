<?php
session_start();
include("database.php");
include("functions.php");

$message = '';

if (isset($_GET['action'])) {

    $action = $_GET['action'];

    /* Login Logic */
    if ($action == 'login') {
        $email = strtolower(trim($_POST["email"]));
        $password = $_POST["password"];
        $user = getUserByEmail($email, $conn);
        if ($user) {
            if (verifyPassword($password, $user["password"])) {
                loginUser($user);
            } else {
                $message = 'Incorrect Password!';
            }
        } else {
            $message = "Email not found.";
        }
        include 'login.php';
    }

    /* Sign Up Logic */
    if ($_GET['action'] == 'signup') {
        $name = trim($_POST['name']);
        $email = strtolower(trim($_POST['email']));
        $password = $_POST['password'];
        $confirmPassword = $_POST['confirm-password'];
        $gender = $_POST['gender'];

        $errors = validateSignupData($name, $email, $password, $confirmPassword, $conn);

        if (empty($errors)) {
            $userId = registerUser($name, $email, $password, $gender, $conn);
            if ($userId) {
                $user = getUserById($userId, $conn); // Fetch the user by ID
                $_SESSION = $user;
                header("Location: Profile.php");
                exit();
            } else {
                $message = "Error: " . mysqli_error($conn);
            }
        } else {
            $message = "Error: " . mysqli_error($conn);
        }
        include 'Signup.php';
    }

     /* Change Password Logic */
    if ($_GET['action'] == 'forgetpass') {
        $email = strtolower(trim($_POST['email']));
        $password = $_POST['password'];
        $confirmPassword = $_POST['confirm-password'];
    
        $errors = validatePasswordData($email, $password, $confirmPassword, $conn);
    
        if (empty($errors)) {
            if (updatePassword($email, $password, $conn)) {
                $message = "Password updated successfully!";
            } else {
                $message = "Error: " . mysqli_error($conn);
            }
        } else {
            $message = implode("<br>", $errors);
        }
        include 'Changepassword.php';
    }

    /*Log out Logic*/
    if ($_GET['action'] == 'logout') {
        session_destroy();
        header("Location: Landing.php");
        exit();
    }

    /* Booking Logic */
    if ($_GET['action'] == "booking") {
        $id = $_SESSION['id'];
        $date = $_POST['date'];
        $time = $_POST['time'];

        $sql = "INSERT INTO bookings (user_id, date, time) VALUES ('$id', '$date', '$time')";
        if (mysqli_query($conn, $sql)) {
            header("Location: BookTherapy.php?status=success");
            exit();
        } else {
            $message = "Error: " . mysqli_error($conn);
        }
    }
    
}

mysqli_close($conn);
?>
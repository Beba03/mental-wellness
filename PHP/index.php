<?php
session_start();
include("database.php");
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

    /*Log out Logic*/
    if ($_GET['action'] == 'logout') {
        session_destroy();
        header("Location: Landing.php");
        exit();
    }

    /* Booking Logic */
    if ($_SERVER["REQUEST_METHOD"] == "booking") {

        $id = $user['id']; 
        $date = $_POST['date'];
        $time = $_POST['time'];      

        $sql = "INSERT INTO bookings (user_id, date, time) VALUES ('$id', '$date', '$time')";
        if (mysqli_query($conn, $sql)) {
            $message = "Booking successful!";
        } else {
            $message = "Error: " . mysqli_error($conn);
        }
    }

}

mysqli_close($conn);
?>

<?php

function getUserById($id, $conn) {
    $sql = "SELECT * FROM users WHERE id = '$id'";
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_assoc($result);
}

function getUserByEmail($email, $conn)
{
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_assoc($result);
}

function verifyPassword($inputPassword, $storedPassword)
{
    return password_verify($inputPassword, $storedPassword);
}

function loginUser($user)
{
    $_SESSION = $user;
    header("Location: Profile.php");
    exit();
}

function validateSignupData($name, $email, $password, $confirmPassword, $conn)
{
    $errors = [];

    // Validate name
    if (empty($name)) {
        $errors[] = "Name is required.";
    }

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }

    // Validate password
    if (!preg_match('/^(?=.*[A-Z])(?=.*[!@#$%^&*])(?=.{8,10})/', $password)) {
        $errors[] = "Password must be at least 8 characters long, contain at least one uppercase letter, and one special character.";
    }

    // Check password match
    if ($password !== $confirmPassword) {
        $errors[] = "Passwords do not match.";
    }

    // Check if email already exists
    if (emailExists($email, $conn)) {
        $errors[] = "Email is already registered.";
    }

    return $errors;
}

function emailExists($email, $conn)
{
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);
    return mysqli_num_rows($result) > 0;
}

function registerUser($name, $email, $password, $gender, $conn) {
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $sql = "INSERT INTO users (name, email, password, gender) VALUES ('$name', '$email', '$hashedPassword', '$gender')";
    if (mysqli_query($conn, $sql)) {
        return mysqli_insert_id($conn);
    } else {
        return false;
    }
}

?>
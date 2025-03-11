<?php
include("database.php");

function getUserById($id, $conn)
{
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

function registerUser($name, $email, $password, $gender, $conn)
{
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $sql = "INSERT INTO users (name, email, password, sex) VALUES ('$name', '$email', '$hashedPassword', '$gender')";
    if (mysqli_query($conn, $sql)) {
        return mysqli_insert_id($conn);
    } else {
        return false;
    }
}

function validatePasswordData($email, $password, $confirmPassword, $conn) {
    $errors = [];

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

    // Check if email exists
    if (!emailExists($email, $conn)) {
        $errors[] = "Email not found.";
    }

    return $errors;
}

function updatePassword($email, $password, $conn) {
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $sql = "UPDATE users SET password = '$hashedPassword' WHERE email = '$email'";
    return mysqli_query($conn, $sql);
}

?>
<?php
session_start();

$db = new mysqli('localhost', 'root', '', 'users');

// Check connection
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

// Function to securely hash passwords
function hashPassword($password) {
    return password_hash($password, PASSWORD_DEFAULT);
}

// Function to verify hashed passwords
function verifyPassword($password, $hashedPassword) {
    return password_verify($password, $hashedPassword);
}

// Function to check if user is logged in
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

// Function to redirect user to login if not logged in
function requireLogin() {
    if (!isLoggedIn()) {
        header("Location: login.php");
        exit;
    }
}

// Function to create user account
function createUser($username, $password) {
    global $db;
    $hashedPassword = hashPassword($password);
    $stmt = $db->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $username, $hashedPassword);
    $stmt->execute();
    $stmt->close();
}

// Function to authenticate user
function authenticateUser($username, $password) {
    global $db;
    $stmt = $db->prepare("SELECT id, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($id, $hashedPassword);
    $stmt->fetch();
    $stmt->close();
    if (verifyPassword($password, $hashedPassword)) {
        $_SESSION['user_id'] = $id;
        return true;
    } else {
        return false;
    }
}

// Function to change user's password
function changePassword($userId, $newPassword) {
    global $db;
    $hashedPassword = hashPassword($newPassword);
    $stmt = $db->prepare("UPDATE users SET password = ? WHERE id = ?");
    $stmt->bind_param("si", $hashedPassword, $userId);
    $stmt->execute();
    $stmt->close();
}

// Function to personalize user's profile
function personalizeProfile($userId, $profileData) {
    // Functionality to personalize profile
}

// Function to add profile picture
function addProfilePicture($userId, $imagePath) {
    // Functionality to add profile picture
}

// Function to create order
function createOrder($userId, $message, $public) {
    // Functionality to create order
}

// Function to cancel order
function cancelOrder($orderId) {
    // Functionality to cancel order
}

// Function to delete user and their orders (only for administrators)
function deleteUser($userId) {
    // Functionality to delete user and their orders
}

// Function to delete order (only for administrators)
function deleteOrder($orderId) {
    // Functionality to delete order
}

// Function to change administrator's password
function changeAdminPassword($newPassword) {
    // Functionality to change administrator's password
}

// HTML form for registration
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
    createUser($_POST['username'], $_POST['password']);
}

// HTML form for login
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    if (authenticateUser($_POST['username'], $_POST['password'])) {
        header("Location: profile.php");
        exit;
    } else {
        echo "Invalid username or password";
    }
}

// HTML form for changing password
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['change_password'])) {
    changePassword($_SESSION['user_id'], $_POST['new_password']);
}

// HTML form for creating order
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create_order'])) {
    createOrder($_SESSION['user_id'], $_POST['message'], $_POST['public']);
}

// HTML form for canceling order
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cancel_order'])) {
    cancelOrder($_POST['order_id']);
}

// HTML form for deleting user and their orders (only for administrators)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_user'])) {
    deleteUser($_POST['user_id']);
}

// HTML form for deleting order (only for administrators)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_order'])) {
    deleteOrder($_POST['order_id']);
}

// HTML form for changing administrator's password
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['change_admin_password'])) {
    changeAdminPassword($_POST['new_admin_password']);
}
?>

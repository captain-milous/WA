<?php
session_start();

if(isset($_SESSION['user_id'])) {
    header("Location: mainpage.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    
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
    header("Location: mainpage.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Přihlášení</title>
</head>
<body>
    <h2>Přihlášení</h2>
    <form action="" method="POST">
        <label for="username">Uživatelské jméno:</label><br>
        <input type="text" id="username" name="username"><br>
        <label for="password">Heslo:</label><br>
        <input type="password" id="password" name="password"><br><br>
        <input type="submit" name="login" value="Přihlásit se">
    </form>
    <p><a href="registrace.php">Registrovat nový účet</a></p>
</body>
</html>

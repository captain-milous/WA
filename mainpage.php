<?php
session_start();

if(!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

// Zde můžete vložit kód pro zobrazování obsahu hlavní stránky
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hlavní stránka</title>
</head>
<body>
    <h2>Hlavní stránka</h2>
    <p>Vítejte na hlavní stránce.</p>
    <p><a href="logout.php">Odhlásit se</a></p>
</body>
</html>

<?php
session_start(); // <-- This is crucial!

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Index</title>
</head>
<body>
    <p>Welcome, <?= htmlspecialchars($_SESSION['user']) ?>! <a href="logout.php">Logout</a></p>
</body>
</html>
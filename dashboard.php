<?php
session_start();
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - ZenFlow</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body class="form-body">
    <div class="dashboard-container">
        <h2>Welcome to ZenFlow</h2>
        <h1>Hi, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>!</h1>
        <p>You have successfully logged in. Your journey to mindfulness starts now.</p>
        <p>
            <a href="logout.php" class="btn">Logout</a>
        </p>
    </div>
</body>
</html>
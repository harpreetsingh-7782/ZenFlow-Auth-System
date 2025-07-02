<?php
session_start();
require_once "config.php";
$username = $email = $password = $confirm_password = "";
$message = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty(trim($_POST["username"])) || empty(trim($_POST["email"])) || empty(trim($_POST["password"])) || empty(trim($_POST["confirm_password"]))) {
        $message = '<div class="message error">All fields are required.</div>';
    } elseif (!filter_var(trim($_POST["email"]), FILTER_VALIDATE_EMAIL)) {
        $message = '<div class="message error">Invalid email format.</div>';
    } elseif (strlen(trim($_POST["password"])) < 6) {
        $message = '<div class="message error">Password must have at least 6 characters.</div>';
    } elseif (trim($_POST["password"]) != trim($_POST["confirm_password"])) {
        $message = '<div class="message error">Passwords do not match.</div>';
    } else {
        $sql = "SELECT id FROM users WHERE username = ? OR email = ?";
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("ss", $param_username, $param_email);
            $param_username = trim($_POST["username"]);
            $param_email = trim($_POST["email"]);
            if ($stmt->execute()) {
                $stmt->store_result();
                if ($stmt->num_rows > 0) {
                    $message = '<div class="message error">This username or email is already taken.</div>';
                } else {
                    $sql_insert = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
                    if ($stmt_insert = $conn->prepare($sql_insert)) {
                        $stmt_insert->bind_param("sss", $param_username, $param_email, $param_password);
                        $param_password = password_hash(trim($_POST["password"]), PASSWORD_DEFAULT);
                        if ($stmt_insert->execute()) {
                            header("location: login.php?status=success");
                        } else {
                            $message = '<div class="message error">Something went wrong. Please try again later.</div>';
                        }
                        $stmt_insert->close();
                    }
                }
            } else {
                $message = '<div class="message error">Oops! Something went wrong. Please try again later.</div>';
            }
            $stmt->close();
        }
    }
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup - ZenFlow</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body class="form-body">
    <div class="form-container">
        <h2>Create Account</h2>
        <?php echo $message; ?>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" name="username" id="username" placeholder="Enter your username" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" placeholder="Enter your email" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" placeholder="Minimum 6 characters" required>
            </div>
            <div class="form-group">
                <label for="confirm_password">Confirm Password</label>
                <input type="password" name="confirm_password" id="confirm_password" placeholder="Confirm your password" required>
            </div>
            <button type="submit" class="btn">Sign Up</button>
            <p>Already have an account? <a href="login.php">Login here</a>.</p>
        </form>
    </div>
</body>
</html>
<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: index.php"); // If already logged in, go to landing page
    exit;
}
require_once "config.php";
$login = $password = "";
$message = "";

// Check for success message from signup
if(isset($_GET['status']) && $_GET['status'] == 'success'){
    $message = '<div class="message success">Registration successful! Please log in.</div>';
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty(trim($_POST["login"])) || empty(trim($_POST["password"]))) {
        $message = '<div class="message error">Please enter username/email and password.</div>';
    } else {
        $login = trim($_POST["login"]);
        $password = trim($_POST["password"]);
        
        // ** THE FIX IS HERE **
        // The SQL query has TWO placeholders (?, ?).
        $sql = "SELECT id, username, password FROM users WHERE username = ? OR email = ?";
        
        if ($stmt = $conn->prepare($sql)) {
            // We must bind TWO variables. We'll use the same $login variable for both.
            // "ss" means we are binding two strings.
            $stmt->bind_param("ss", $param_login, $param_login);
            $param_login = $login;
            
            if ($stmt->execute()) {
                $stmt->store_result();
                if ($stmt->num_rows == 1) {
                    $stmt->bind_result($id, $username, $hashed_password);
                    if ($stmt->fetch()) {
                        if (password_verify($password, $hashed_password)) {
                            session_start();
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;                            
                            
                            // ** REDIRECT GOAL CHANGED **
                            // Redirect user to the landing page (index.php) after login
                            header("location: index.php");

                        } else {
                            $message = '<div class="message error">Incorrect username/email or password.</div>';
                        }
                    }
                } else {
                    $message = '<div class="message error">User does not exist.</div>';
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
    <title>Login - ZenFlow</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body class="form-body">
    <div class="form-container">
        <h2>User Login</h2>
        <?php echo $message; ?>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label for="login">Username or Email</label>
                <input type="text" name="login" id="login" placeholder="Enter username or email" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" placeholder="Enter your password" required>
            </div>
            <button type="submit" class="btn">Login</button>
            <p>Don't have an account? <a href="signup.php">Sign up now</a>.</p>
        </form>
    </div>
</body>
</html>

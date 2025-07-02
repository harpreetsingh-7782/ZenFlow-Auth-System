<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ZenFlow - Your Partner in Mindfulness</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <nav>
            <div class="logo">ZenFlow</div>
            <ul class="nav-links">
                <li><a href="#features">Features</a></li>
                <li><a href="#pricing">Pricing</a></li>
                <li><a href="#contact">Contact</a></li>

                <?php if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true): ?>
                    <!-- Show this if user IS logged in -->
                    <li><span>Hi, <?php echo htmlspecialchars($_SESSION["username"]); ?>!</span></li>
                    <li><a href="logout.php" class="btn">Logout</a></li>
                <?php else: ?>
                    <!-- Show this if user is NOT logged in -->
                    <li><a href="login.php">Login</a></li>
                    <li><a href="signup.php" class="btn">Sign Up</a></li>
                <?php endif; ?>

            </ul>
        </nav>
    </header>

    <main>
        <section class="hero">
            <div class="hero-content">
                <h1>Find Your Inner Peace with ZenFlow</h1>
                <p>The ultimate app for meditation, mindfulness, and personal growth. Start your journey to a calmer mind today.</p>
                <a href="signup.php" class="btn btn-primary">Get Started</a>
            </div>
            <div class="hero-image">
                <img src="assets/hero-background.jpg" alt="Meditation illustration">
            </div>
        </section>

        <section id="features" style="padding: 50px; text-align: center;">
            <h2>Features</h2>
            <p>Details about your app's features...</p>
        </section>
        <section id="pricing" style="padding: 50px; text-align: center; background-color: #f4f4f9;">
            <h2>Pricing</h2>
            <p>Information about subscription plans...</p>
        </section>
        <section id="contact" style="padding: 50px; text-align: center;">
            <h2>Contact Us</h2>
            <p>Contact form or details...</p>
        </section>
    </main>

    <footer>
        <p>© 2024 ZenFlow. All rights reserved.</p>
    </footer>
</body>
</html>
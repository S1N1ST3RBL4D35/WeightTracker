<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;500;700&display=swap">
        <link rel="stylesheet" href="style.css">
        <title>Weight Tracker Application</title>
    </head>
    <body>
        <header>
            <h1>Your Weight Tracker</h1>
            <nav>
                <a href="index.php">Home</a>
                <a href="contact.php">Contact Us</a>
                <?php
                if(isset($_SESSION['user'])) {
                    echo '<a href="log_weight.html">Log Weight</a>';
                    echo '<a href="logout.php">Logout</a>';
                } else {
                    echo '<a href="register.php">Login/Register</a>';
                }
                ?>
            </nav>
        </header>
        <main>
            <section id="overview">
                <h2>Welcome to your Weight Tracker App!</h2>
                <p>Track your weight easily and stay on top of your fitness goals with our user-friendly weight tracking application.</p>
            </section>
            <section id="features">
                <h2>Key Features</h2>
                <ul>
                    <li>Log your weight with just a few clicks.</li>
                    <li>Visualize your progress with an interactive chart</li>
                    <li>Receive personalized feedback based on your achievements</li>
                </ul>
            </section>
            <section id="cta">
                <p>Ready to take control of your fitness journey?</p>
                <?php
                if(isset($_SESSION['user'])) {
                    echo '<a href="log_weight.php">Get Started Here</a>';
                } else {
                    echo '<a href="login.php">Get Started Here</a>';
                }
                ?>
            </section>
        </main>
    </body>
</html>

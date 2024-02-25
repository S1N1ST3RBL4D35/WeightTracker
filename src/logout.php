<?php
session_start();

//Unset all session variables
$_SESSION = array();


//Destroy the session
session_destroy();

//Provide message for user after logout
$logoutMessage = 'Successfully logged out. Redirecting back to the home page shortly.';
header("refresh:3;url=index.php");
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=devicew-width, initial-scale=1.0">
        <link rel="stylesheet" href="logout.css">
        <title>Logout</title>
    </head>
    <body>
        <header>
            <h1>Your Weight Tracker</h1>
        </header>
        <main>
            <section id="logout-message">
                <p><?php echo $logoutMessage; ?></p>
            </section>
        </main>
    </body>
</html>
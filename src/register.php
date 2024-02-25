<?php
include ('conn.php');

session_start();

include 'conn.php';

$registerError = '';  

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];

    //Verification Checks
    if(empty($username)) {
        $registerError = 'Username is required';
    } elseif (strlen($username) < 3) {
        //too short of a username
        $registerError = 'Username must be at least 3 characters long';
    } elseif (!preg_match('/^[a-zA-Z0-9_]+$/', $username)) {
        //username contains only alphanumeric chars and underscores
        $registerError = 'Username can only contain letters, numbers and underscores';
    }elseif (usernameAlreadyTaken($username)) {
        //Check if useranme is taken
        $registerError = 'Username is taken, please try again';
    } elseif (empty($email)) {
        $registerError = 'Email is required';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        //Is email valid?
        $registerError = 'Invalid email format';
    } elseif(emailAlreadyTaken($email)) {
        //Is email tanek?
        $registerError = 'Email already registered. Please use a different email';
    } elseif (empty($password)) {
        $registerError = 'Password is required';
    } elseif (strlen($password) < 6) {
        $registerError = 'Password must be at least 6 characters long';
    } else {
        //all checks are successful, continue with registration process
        $otp = mt_rand(100000, 999999);

        //Save all user details in a session for later use
        $_SESSION['user_details'] = [
            'username' => $username,
            'email' => $email,
            'password' => $password,
            'otp' => $otp,
        ];

        $to = $email;
        $subject = 'Your One-Time Passcode';
        $message = "Your one time passcode is: $otp";

        if(mail($to, $subject, $message)) {
            header('Location: verify_otp.php');
            exit;
        }
    }
}

//Function to check if username is taken
function usernameAlreadyTaken($username) {
    global $conn;

    $stmt = $conn->prepare('SELECT username FROM users WHERE username = ?');
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $stmt->store_result();
    $count = $stmt->num_rows();
    $stmt->close();

    return $count > 0;
}

function emailAlreadyTaken($email) {
    global $conn;

    $stmt = $conn->prepare('SELECT email FROM users WHERE email = ?');
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $stmt->store_result();
    $count = $stmt->num_rows();
    $stmt->close();

    return $count > 0;
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="regstyle.css">
        <title>Registration</title>
    </head>
    <body>
        <header>
            <h1>Your Weight Tracker</h1>
            <nav>
                <a href="index.php">Home</a>
                <a href="contact.php">Contact Us</a>
                <?php
                if(isset($_SESSION['user'])) {
                    echo '<a href="log_weight.php">Log Weight</a>';
                    echo '<a href="logout.php">Logout</a>';
                } else {
                    echo '<a href="register.php">Login/Register</a>';
                }
                ?>
            </nav>
        </header>
        <main>
            <section id="register-form">
                <h2>Registration</h2>
                <?php
                if(isset($registerError)) {
                    echo '<div class="error-message">' . $registerError . '</div>';
                }
                ?>
                <form action="register.php" method="post">
                    <label for="username">Username:</label>
                    <input type="text" id="username" name="username" required>

                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>

                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" required>

                    <button type="submit">Register</button>

                    <p>Have you registered already?<a href="login.php">Login Here</a></p>
                </form>
            </section>
        </main>
    </body>
</html>
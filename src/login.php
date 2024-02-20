<?php
session_start();

include ('conn.php');

$loginError = '';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $password = $_POST['password'];

    //Verification Check
    if(empty($username) || empty($password)) {
        $loginError = 'Username and password are required';
    } else {
        $stmt = $conn->prepare('SELECT id, password FROM users WHERE username = ?');
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $stmt->store_result();

        if($stmt->num_rows() > 0) {
            $stmt->bind_result($userId, $hashedPassword);
            $stmt->fetch();

            if(password_verify($password, $hashedPassword)) {
                //Login Successful
                $_SESSION['user'] = $userId;
                header('Location: index.php');
                exit;
            } else {
                $loginError = 'Incorrect password, please try again.';
            }
        } else {
            $loginError = 'Username not found, please register.';
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="login.css">
        <title>Login</title>
    </head>
    <body>
        <header>
            <h1>Your Weight Tracker</h1>
            <nav>
                <a href="index.php">Home</a>
                <a href="contact.php">Contact Us</a>
            </nav>
        </header>
        <main>
            <section id="login-form">
                <h2>Login</h2>
                <?php
                if (!empty($loginError)) {
                    echo '<div class="error-message">' . $loginError . '</div>';
                }
                ?>
                <form action="login.php" method="post">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" required>

                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" required>

                    <button type="submit">Login</button>
                    <p>Don't have an account?<a href="register.php">Register here</a></p>
                </form>
            </section>
        </main>
    </body>
</html>
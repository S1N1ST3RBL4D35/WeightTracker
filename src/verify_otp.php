<?php
session_start();

include 'conn.php';

$otpError = '';

if($_SERVER['REQUEST_METHOD' ]== 'POST') {
    $enteredOTP = $_POST['otp'];
    $storedOTP = $_SESSION['user_details']['otp'];

    if($enteredOTP == $storedOTP) {
        //OTP is correct, proceed with DB insertion
        $username = $_SESSION['user_details']['username'];
        $email = $_SESSION['user_details']['email'];
        $password = $_SESSION['user_details']['password'];
        $hashPass = password_hash($password, PASSWORD_BCRYPT);  //for security reasons you may want to use a more secure hashing algorithm

        //INSERT query
        $stmt = $conn->prepare('INSERT INTO users (username, email, password, otp, verified) VALUES (?,?,?,?,?)');
        $stmt->bind_param('sssss', $username, $email, $hashPass, $storedOTP, $verifiedStatus);

        $verifiedStatus = 'Y';

        if($stmt->execute()) {
            //Registration successful, redirect to home page
            unset($_SESSION['user_details']); //clear user details
            $_SESSION['user'] = $username;
            header('Location: index.php');
            exit;
        } else {
            $otpError = 'Error inserting data into the database.';
        }
        $stmt->close();
    } else {
        $otpError = 'Incorrect code, please try again.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="verify_otp.css">
        <title>Verify OTP</title>
    </head>
    <body>
        <header>
            <h1>Your Weight Tracker</h1>
        </header>
        <main>
            <section id="verify-otp-form">
                <h2>Verify One Time Passcode</h2>
                <?php
                if (!empty($otpError)) {
                    echo '<div class="error-message">' . $otpError . '</div>';
                }
                ?>
                <form action="verify_otp.php" method="post">
                    <label for="otp">Enter One Time Passcode:</label>
                    <input type="text" id="otp" name="otp" required maxlength="6" pattern="\d{6}">
                    <button type="submit">Verify OTP</button>
                </form>
            </section>
        </main>
    </body>
</html>

<?php
//Initialize variables to hold data
$name = $email = $message = $status = "";

//Check if form is submitted properly
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //Collect data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    //Set up email params
    $to = 'your-email-here@example.com';
    $subject = 'New Contact Form Submission';
    $headers = "From: $name <$email>\r\n";
    $headers .= "Reply-To: $email\r\n";

    //Send the email
    if(mail($to, $subject, $message, $headers)) {
        $status = "success";
    } else {
        $status = "error";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;500;700&display=swap">
        <link rel="stylesheet" href="contact.css">
        <title>Contact Us!</title>
    </head>
    <body>
        <header>
            <h1>Your Weight Tracker</h1>
            <nav>
                <a href="index.html">Home</a>
                <a href="contact.php">Contact Us</a>
                <a href="login.html">Login/Register</a>
            </nav>
        </header>
        <main>
            <section id="contact-form">
                <h2>Contact us</h2>
                <?php
                if ($status === 'success') {
                    echo '<div class="success-message">Message Sent Successfully. Please allow some time for a response.</div>';
                } elseif($status === 'error') {
                    echo '<div class="error-message">Message couldn\'t be delivered.</div>';
                }
                ?>
                <p>If you have any feedback or requests, please fill out this form</p>
                <form action="contact.php" method="post">
                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name" required>

                    <label for="email">Email:</label>
                    <input type="email" name="email" id="email" required>

                    <label for="message">Message:</label>
                    <textarea id="message" name="message" rows="4" required></textarea>

                    <button type="submit">Submit</button>
                </form>
            </section>
        </main>
    </body>
</html>

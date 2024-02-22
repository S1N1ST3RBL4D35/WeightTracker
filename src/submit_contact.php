<?php
if($_SERVER['REQUEST_METHOD']=='POST'){
    //Collect form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    //Set up your email parameters
    $to = //your_email@example.com;
    $subject = "New Contact Form Submission";
    $headers = "From: $name <$email>\r\n";
    $headers .= "Reply-To: $email\r\n";

    //Send email
    mail($to, $subject, $message, $headers);

    //Redirect back to contecnt page with success message
    header("Location: contact.php?status=success");
    exit;
} else {
    //Redirect back with an error message
    header("Location: contact.php?status=error");
    exit;
}
?>

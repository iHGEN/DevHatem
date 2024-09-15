<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php'; // Ensure this path is correct

use Dotenv\Dotenv;
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Initialize Dotenv with the directory of the .env file
$dotenv = Dotenv::createImmutable(__DIR__, '../envmanager.env');
$dotenv->load();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $message = htmlspecialchars($_POST['message']);
    
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->CharSet = 'UTF-8';
        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host       = 'smtp.hostinger.com';              // Replace with your SMTP server
        $mail->SMTPAuth   = true;                             // Enable SMTP authentication
        $mail->Username   = 'owner@devhatem.com';             // SMTP username
        $mail->Password   = $_ENV['OWNERPASS'];             // SMTP password
        $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port       = 465;                              // TCP port to connect to

        // Recipients
        $mail->setFrom('owner@devhatem.com', 'devhatem.com');
        $mail->addAddress('owner@devhatem.com', $name); // Add a recipient
        
        
        // Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = 'New Contact Form Submission';
        $mail->Body    = "<h2>You have a new message from your website contact form</h2>
                          <p><strong>Name:</strong> {$name}</p>
                          <p><strong>Email:</strong> {$email}</p>
                          <p><strong>Message:</strong><br>{$message}</p>";
        $mail->AltBody = "You have a new message from your website contact form\n\n".
                         "Name: {$name}\n".
                         "Email: {$email}\n".
                         "Message:\n{$message}";

        $mail->send();

         // Now, send an auto-reply to the user
         $mail->clearAddresses(); // Clear the previous recipient
         $mail->addAddress($email, $name); // Add the user's email address as the recipient
         $mail->Subject = 'Thank You for Contacting me';
 
         $mail->Body = "
             <h2>Hello $name,</h2>
             <p>Thank you for reaching out to me. I have received your message and will get back to you as soon as possible.</p>
             <p><strong>Your Message:</strong></p>
             <blockquote>$message</blockquote>
             <br>
             <p>Best regards,<br>Hatem</p>
         ";
 
         $mail->send(); // Send the reply email to the user
        echo 'Thank you for your contact';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
} else {
    echo "Invalid request method";
}
?>

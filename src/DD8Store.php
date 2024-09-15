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
    $subject = htmlspecialchars($_POST['subject']);
    $name = htmlspecialchars($_POST['name']);
    $message = htmlspecialchars($_POST['message']);
    
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->CharSet = 'UTF-8';
        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host       = 'smtp.hostinger.com';              // Replace with your SMTP server
        $mail->SMTPAuth   = true;                             // Enable SMTP authentication
        $mail->Username   = 'SupportDD8Store@devhatem.com';             // SMTP username
        $mail->Password   = $_ENV['DD8STORE'];             // SMTP password
        $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port       = 465;                              // TCP port to connect to

        // Recipients
        $mail->setFrom('SupportDD8Store@devhatem.com', 'devhatem.com');
        $mail->addAddress('daimn.mekasa@gmail.com', $name); // Add a recipient
        
        
        // Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = $subject;
        $mail->Body    = "{$name}<br><br>
                          <p><strong>Message:</strong><br>{$message}</p>";
                          
        $mail->AltBody = "<h2>New User with this key {$name} has successfully Register</h2>
                          <p><strong>Message:</strong><br>{$message}</p>";

        $mail->send();
        echo 'have fun :)';
    } catch (Exception $e) {
        echo  "{$_ENV['DD8STORE']} <br /> " ; 
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
} else {
    echo "Invalid request method";
}
?>

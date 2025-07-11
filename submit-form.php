<?php
// Include PHPMailer classes
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';
require 'PHPMailer-master/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize inputs
    $fullName = htmlspecialchars(trim($_POST['full_name'] ?? ''));
    $phone = htmlspecialchars(trim($_POST['phone'] ?? ''));
    $email = htmlspecialchars(trim($_POST['email'] ?? ''));
    $cityState = htmlspecialchars(trim($_POST['city_state'] ?? ''));
    $kittenName = htmlspecialchars(trim($_POST['kitten_name'] ?? ''), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    $kittenBreed = htmlspecialchars(trim($_POST['kitten_breed'] ?? ''), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    $message = nl2br(htmlspecialchars(trim($_POST['message'] ?? '')));

    $mail = new PHPMailer(true);
    $mail->CharSet = 'UTF-8';

    try {
        // SMTP configuration for Titan
        $mail->isSMTP();
        $mail->Host       = 'smtp.titan.email';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'info@xn--mijamktzchenzuhause-lwb.de';
        $mail->Password   = 'Talktome@123'; // Replace with your real Titan password
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        // Sender and recipient settings
        $mail->setFrom('info@xn--mijamktzchenzuhause-lwb.de', 'Website Submission');
        $mail->addAddress('mijamkittenshome@gmail.com'); // ? Changed to Gmail inbox
        $mail->addReplyTo($email, $fullName);

        $mail->isHTML(true);
        $mail->Subject = mb_encode_mimeheader("?? Neue K�tzchen-Anfrage von $fullName", 'UTF-8', 'B');

        // Styled HTML body
        $mail->Body = "
        <html>
        <head>
          <style>
            body {
              font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
              background-color: #f4f7f8;
              padding: 30px;
              color: #333;
            }
            .email-container {
              background-color: #ffffff;
              padding: 25px 35px;
              border-radius: 12px;
              box-shadow: 0 2px 8px rgba(0,0,0,0.1);
              max-width: 600px;
              margin: auto;
            }
            h2 {
              color: #2c3e50;
              border-bottom: 2px solid #3498db;
              padding-bottom: 8px;
              margin-bottom: 20px;
              font-weight: 700;
            }
            .info {
              margin-bottom: 16px;
              font-size: 16px;
              line-height: 1.5;
            }
            .label {
              font-weight: 600;
              color: #2980b9;
              display: inline-block;
              width: 140px;
            }
            .message-content {
              background-color: #ecf0f1;
              padding: 12px 18px;
              border-radius: 8px;
              white-space: pre-wrap;
              font-style: italic;
              color: #555;
              border-left: 4px solid #3498db;
            }
          </style>
        </head>
        <body>
          <div class='email-container'>
            <h2>Neue K�tzchen-Anfrage</h2>
            <div class='info'><span class='label'>Name:</span> $fullName</div>
            <div class='info'><span class='label'>Telefon:</span> $phone</div>
            <div class='info'><span class='label'>E-Mail:</span> $email</div>
            <div class='info'><span class='label'>Stadt / Bundesland:</span> $cityState</div>
            <div class='info'><span class='label'>K�tzchenname:</span> $kittenName</div>
            <div class='info'><span class='label'>K�tzchenrasse:</span> $kittenBreed</div>
            <div class='info'><span class='label'>Nachricht:</span>
              <div class='message-content'>$message</div>
            </div>
          </div>
        </body>
        </html>
        ";

        // Send email
        $mail->send();

        // Redirect to thank you page
        header("Location: thank-you.html");
        exit();
    } catch (Exception $e) {
        echo "? Mailer Error: " . $mail->ErrorInfo;
    }
} else {
    header("Location: index.html");
    exit();
}
?>

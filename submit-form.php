<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize form inputs
    $fullName = htmlspecialchars(trim($_POST['full_name'] ?? ''));
    $phone = htmlspecialchars(trim($_POST['phone'] ?? ''));
    $email = htmlspecialchars(trim($_POST['email'] ?? ''));
    $cityState = htmlspecialchars(trim($_POST['city_state'] ?? ''));
    $kittenName = htmlspecialchars(trim($_POST['kitten_name'] ?? ''));
    $kittenBreed = htmlspecialchars(trim($_POST['kitten_breed'] ?? ''));
    $message = nl2br(htmlspecialchars(trim($_POST['message'] ?? ''))); // Allow line breaks

    // Destination email
    $to = "brandonasah11@gmail.com";
    $subject = "🐱 Neue Kätzchen-Anfrage von $fullName";

    // HTML email body
    $body = "
    <html>
    <head>
      <style>
        body { font-family: Arial, sans-serif; background-color: #f9f9f9; padding: 20px; }
        .email-container { background-color: #ffffff; padding: 20px; border-radius: 8px; }
        h2 { color: #333; }
        .info { margin-bottom: 12px; }
        .label { font-weight: bold; color: #555; }
      </style>
    </head>
    <body>
      <div class='email-container'>
        <h2>Neue Kätzchen-Anfrage</h2>
        <div class='info'><span class='label'>Name:</span> $fullName</div>
        <div class='info'><span class='label'>Telefon:</span> $phone</div>
        <div class='info'><span class='label'>E-Mail:</span> $email</div>
        <div class='info'><span class='label'>Stadt / Bundesland:</span> $cityState</div>
        <div class='info'><span class='label'>Kätzchenname:</span> $kittenName</div>
        <div class='info'><span class='label'>Kätzchenrasse:</span> $kittenBreed</div>
        <div class='info'><span class='label'>Nachricht:</span><br>$message</div>
      </div>
    </body>
    </html>
    ";

    // Email headers
    $headers  = "MIME-Version: 1.0\r\n";
    $headers .= "Content-type: text/html; charset=UTF-8\r\n";
    $headers .= "From: no-reply@pawofcomfort.com\r\n";
    $headers .= "Reply-To: $email\r\n";

    // Send email and redirect
    if (mail($to, $subject, $body, $headers)) {
        header("Location: thank-you.html"); // Optional: create a "thank-you.html" page
        exit();
    } else {
        echo "❌ E-Mail-Versand fehlgeschlagen. Bitte versuchen Sie es erneut.";
    }
} else {
    header("Location: index.html");
    exit();
}
?>

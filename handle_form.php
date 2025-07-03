<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Sanitize input
    $full_name    = htmlspecialchars(trim($_POST['full_name'] ?? ''));
    $phone        = htmlspecialchars(trim($_POST['phone'] ?? ''));
    $email        = htmlspecialchars(trim($_POST['email'] ?? ''));
    $city_state   = htmlspecialchars(trim($_POST['city_state'] ?? ''));
    $puppy_name   = htmlspecialchars(trim($_POST['puppy_name'] ?? ''));
    $puppy_breed  = htmlspecialchars(trim($_POST['puppy_breed'] ?? ''));
    $message      = nl2br(htmlspecialchars(trim($_POST['message'] ?? '')));

    // Validate required fields
    if (empty($full_name) || empty($phone) || empty($email) || empty($message)) {
        echo "Bitte füllen Sie alle erforderlichen Felder aus.";
        exit;
    }

    // Email content (HTML)
    $email_body = "
    <html>
    <head>
      <style>
        body { font-family: Arial, sans-serif; background-color: #f7f7f7; padding: 20px; }
        .container { background: #fff; padding: 20px; border-radius: 10px; max-width: 600px; margin: auto; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
        table { width: 100%; border-collapse: collapse; }
        td { padding: 10px; vertical-align: top; }
        .label { font-weight: bold; width: 30%; color: #444; }
        .value { color: #000; }
        h2 { color: #333; }
      </style>
    </head>
    <body>
      <div class='container'>
        <h2>Neue Kontaktanfrage</h2>
        <table>
          <tr><td class='label'>Name:</td><td class='value'>{$full_name}</td></tr>
          <tr><td class='label'>Telefonnummer:</td><td class='value'>{$phone}</td></tr>
          <tr><td class='label'>Email:</td><td class='value'>{$email}</td></tr>
          <tr><td class='label'>Stadt und Staat:</td><td class='value'>{$city_state}</td></tr>
          <tr><td class='label'>Welpenname:</td><td class='value'>{$puppy_name}</td></tr>
          <tr><td class='label'>Welpenrasse:</td><td class='value'>{$puppy_breed}</td></tr>
          <tr><td class='label'>Nachricht:</td><td class='value'>{$message}</td></tr>
        </table>
      </div>
    </body>
    </html>";

    // Email headers
    $to = "mijamkittenshome@gmail.com";
    $subject = "Neue Kontaktanfrage von " . $full_name;

    $headers = "MIME-Version: 1.0\r\n";
    $headers .= "Content-type: text/html; charset=UTF-8\r\n";
    $headers .= "From: \"Mijam Kätzchen Zuhause\" <noreply@mijamkätzchenzuhause.de>\r\n";
    $headers .= "Reply-To: " . $email . "\r\n";

    // Send email
    if (mail($to, $subject, $email_body, $headers)) {
        // Optionally log to file
        $log = "Name: $full_name\nTelefon: $phone\nEmail: $email\nStadt & Staat: $city_state\nWelpenname: $puppy_name\nWelpenrasse: $puppy_breed\nNachricht:\n$message\n----------------------\n";
        file_put_contents(__DIR__ . '/form_submissions.txt', $log, FILE_APPEND);

        echo "Vielen Dank! Ihre Nachricht wurde erfolgreich gesendet.";
    } else {
        echo "Fehler beim Senden der Nachricht. Bitte versuchen Sie es später erneut.";
    }

} else {
    echo "Ungültige Anforderung.";
}

// Send email
if (mail($to, $subject, $email_body, $headers)) {
    // Log to file
    $log = "Name: $full_name\nTelefon: $phone\nEmail: $email\nStadt & Staat: $city_state\nWelpenname: $puppy_name\nWelpenrasse: $puppy_breed\nNachricht:\n$message\n----------------------\n";
    file_put_contents(__DIR__ . '/form_submissions.txt', $log, FILE_APPEND);

    // Redirect to success page in home directory
    header("Location: /succes.html");
    exit;  // important to stop further execution
} else {
    echo "Fehler beim Senden der Nachricht. Bitte versuchen Sie es später erneut.";
}

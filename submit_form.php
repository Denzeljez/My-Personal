<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $message = htmlspecialchars($_POST['message']);

    // Email configuration
    $to_email = "tufgaming0327@gmail.com"; // Your email address
    $subject = "New Contact Form Submission from $name";
    $email_body = "Name: $name\nEmail: $email\n\nMessage:\n$message";
    $headers = "From: $email";

    // Send email
    $email_status = mail($to_email, $subject, $email_body, $headers) 
        ? "Email sent successfully!" 
        : "Failed to send email.";

    // SMS configuration
    $account_sid = "your_twilio_account_sid"; // Replace with your Twilio Account SID
    $auth_token = "your_twilio_auth_token"; // Replace with your Twilio Auth Token
    $twilio_number = "+your_twilio_number"; // Replace with your Twilio phone number
    $to_phone = "+639765077962"; // Your phone number in international format

    $sms_message = "New Contact Form Submission:\nFrom: $name\nMessage: $message";

    // Send SMS via Twilio
    try {
        $twilio_url = "https://api.twilio.com/2010-04-01/Accounts/$account_sid/Messages.json";
        $data = [
            "From" => $twilio_number,
            "To" => $to_phone,
            "Body" => $sms_message,
        ];

        $options = [
            "http" => [
                "header" => "Authorization: Basic " . base64_encode("$account_sid:$auth_token"),
                "method" => "POST",
                "content" => http_build_query($data),
            ],
        ];

        $context = stream_context_create($options);
        $result = file_get_contents($twilio_url, false, $context);

        $sms_status = "SMS sent successfully!";
    } catch (Exception $e) {
        $sms_status = "Failed to send SMS: " . $e->getMessage();
    }

    // Redirect back to the contact page with status messages
    header("Location: contact.html?email_status=" . urlencode($email_status) . "&sms_status=" . urlencode($sms_status));
    exit();
} else {
    // Redirect back to the form if accessed directly
    header("Location: contact.html");
    exit();
}
?>

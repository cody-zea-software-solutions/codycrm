<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require "email/PHPMailer.php";
require "email/SMTP.php";
require "email/Exception.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $emailTitle = ($_POST['title']);
    $emailDescription = strip_tags($_POST['des'], '<p><a><b><i><strong><em><ul><ol><li><br><img><h1><h2><h3><h4><h5><h6>'); 
    $email = htmlspecialchars($_POST['email'], ENT_QUOTES, 'UTF-8');

    $headerImagePath = '';
    $footerImagePath = '';

    $uploadDir = 'uploads/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    if (isset($_FILES['himage']) && $_FILES['himage']['error'] === UPLOAD_ERR_OK) {
        $headerImagePath = $uploadDir . basename($_FILES['himage']['name']);
        move_uploaded_file($_FILES['himage']['tmp_name'], $headerImagePath);
    }

    if (isset($_FILES['fimage']) && $_FILES['fimage']['error'] === UPLOAD_ERR_OK) {
        $footerImagePath = $uploadDir . basename($_FILES['fimage']['name']);
        move_uploaded_file($_FILES['fimage']['tmp_name'], $footerImagePath);
    }

    $response = [
        'status' => 'success',
        'message' => 'Data received successfully.',
        'title' => $emailTitle,
        'description' => $emailDescription,
        'headerImage' => $headerImagePath,
        'footerImage' => $footerImagePath,
    ];

    $s = new EmailSender();
    echo $s->send($email, $emailDescription, $emailTitle, $headerImagePath, $footerImagePath);
}

class EmailSender
{
    public function send($email, $emailDescription, $emailTitle, $headerImagePath, $footerImagePath): string
    {
        return $this->sendWelcomeEmail($email, $emailDescription, $emailTitle, $headerImagePath, $footerImagePath);
    }

    protected function sendWelcomeEmail($email, $emailDescription, $emailTitle, $headerImagePath, $footerImagePath): string
    {
        $mail = new PHPMailer;
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'codylanka00@gmail.com';
        $mail->Password = 'jnil boop pwrb sejy';
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;

        $mail->setFrom('codylanka00@gmail.com', 'codyzea');
        $mail->addAddress($email);
        $mail->isHTML(true);
        $mail->Subject = 'Welcome to Codyzea!';

        $bodyContent = '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }
        .email-container {
            max-width: 600px;
            margin: 20px auto;
            background: #ffffff;
            border: 1px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .email-header {
            background: #007bff;
            color: #ffffff;
            padding: 20px;
            text-align: center;
        }
        .email-body {
            padding: 20px;
        }
        .email-footer {
            background: #f1f1f1;
            text-align: center;
            padding: 10px;
            font-size: 12px;
            color: #666;
        }
        .email-image {
            width: 100%;
            max-height: 200px;
            object-fit: cover;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            <h1>' . $emailTitle . '</h1>
        </div>';

        if (!empty($headerImagePath)) {
            $bodyContent .= '<img src="cid:headerImage" alt="Header Image" class="email-image">';
            $mail->addEmbeddedImage($headerImagePath, 'headerImage');
        }

        $bodyContent .= '<div class="email-body">' . $emailDescription . '</div>';

        if (!empty($footerImagePath)) {
            $bodyContent .= '<img src="cid:footerImage" alt="Footer Image" class="email-image">';
            $mail->addEmbeddedImage($footerImagePath, 'footerImage');
        }

        $bodyContent .= '<div class="email-footer">
            <p>Thank you for choosing Codyzea Pvt Ltd!</p>
        </div>
    </div>
</body>
</html>';


        $mail->Body = $bodyContent;

        if (!$mail->send()) {
            return "Error: " . $mail->ErrorInfo;
        } else {
            return "Email sent successfully.";
        }
    }
}

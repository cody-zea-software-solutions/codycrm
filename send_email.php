<?php

require "db.php";

// Import PHPMailer classes
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require "email/PHPMailer.php";
require "email/SMTP.php";
require "email/Exception.php";

$email = $_POST["email"];

$s = new EmailSender();
echo $s->send($email);

class EmailSender
{
     public function send($email): string{
        $e =  new EmailSender();
       return ($e->sendWelcomeEmail($email));
     }
    protected function sendWelcomeEmail($email): string
    {
        $mail = new PHPMailer;
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'codylanka00@gmail.com';
        $mail->Password = 'jnil boop pwrb sejy';
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;

        $mail->setFrom('codylanka00@gmail.com', 'Codyzea');
        $mail->addAddress($email);
        $mail->isHTML(true);
        $mail->Subject = 'Welcome to Codyzea!';

        $bodyContent = '
        <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Codyzea Pvt Ltd</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
        }
        .email-container {
            max-width: 600px;
            margin: 20px auto;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .header {
            background-color: #007bff;
            color: #fff;
            text-align: center;
            padding: 20px;
        }
        .header h1 {
            margin: 0;
        }
        .content {
            padding: 20px;
        }
        .content h2 {
            color: #007bff;
        }
        .content p {
            margin-bottom: 10px;
        }
        .list {
            padding-left: 20px;
        }
        .list li {
            margin-bottom: 8px;
        }
        .footer {
            background: #f4f4f4;
            text-align: center;
            padding: 10px;
            font-size: 12px;
            color: #555;
        }
        .footer a {
            color: #007bff;
            text-decoration: none;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            margin: 10px 0;
            color: #fff;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
        }
        .btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header Section -->
        <div class="header">
            <h1>Codyzea Pvt Ltd</h1>
            <p>Custom Software | Apps | POS Systems | E-commerce Solutions</p>
            <a href="https://codyzea.com" class="btn">Visit Our Website</a>
        </div>

        <!-- Content Section -->
        <div class="content">
            <h2>Welcome to Codyzea Pvt Ltd!</h2>
            <p>Dear..,</p>
            <p>Thank you for choosing Codyzea Pvt Ltd as your trusted partner for software solutions! We’re excited to help your business grow and succeed with our wide range of innovative products and services.</p>
            <h3>What We Offer:</h3>
            <ul class="list">
                <li><strong>Custom Software Development:</strong> Tailored solutions for your unique business needs.</li>
                <li><strong>Mobile App Development:</strong> Bring your ideas to life with stunning, user-friendly apps.</li>
                <li><strong>POS Systems:</strong> Simplify your sales and inventory management.</li>
                <li><strong>E-commerce Solutions:</strong> Launch or grow your online business with ease.</li>
                <li><strong>Web Application Development:</strong> Modern and scalable web apps built for your business.</li>
                <li><strong>Digital Marketing:</strong> Boost your online presence and attract more customers.</li>
                <li><strong>WordPress Development:</strong> Fully optimized websites with custom themes and plugins.</li>
                <li><strong>Custom Coding:</strong> Advanced technical solutions designed to your specifications.</li>
                <li><strong>Business Automation:</strong> Streamline your workflows and enhance productivity.</li>
            </ul>
        </div>

        <!-- Contact Section -->
        <div class="content">
            <h3>Contact Us Anytime</h3>
            <p><strong>Sri Lanka Office:</strong><br>
                📍 No 69, Vijaya Road, Tangalle<br>
                📞 +94 774 251 664<br>
                ✉️ <a href="mailto:info@codyzea.com">info@codyzea.com</a></p>
            <p><strong>New Zealand Office:</strong><br>
                📍 6A, Tidey Road, Mount Wellington, Auckland<br>
                📞 +64 22 491 7008<br>
                🌐 <a href="http://codyzea.co.nz">Visit New Zealand Website</a></p>
        </div>

        <!-- Footer Section -->
        <div class="footer">
            <p>🌍 <a href="https://codyzea.com">www.codyzea.com</a> | ✉️ <a href="mailto:info@codyzea.com">info@codyzea.com</a></p>
            <p>© 2024 Codyzea Software Solutions by CZ Team. All rights reserved.</p>
        </div>
    </div>
</body>
</html>

        ';

        $mail->Body = $bodyContent;
        if (!$mail->send()) {
            return "Error" ;
        } else {
            return "check your gmailbox";
        }
    }
}
?>

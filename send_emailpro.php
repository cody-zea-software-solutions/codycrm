<?php

require "db.php";

// Import PHPMailer classes
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require "email/PHPMailer.php";
require "email/SMTP.php";
require "email/Exception.php";

// Enable error reporting for debugging (Remove in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($_POST["call_code"]) || !isset($_POST["template"])) {
    die("Error: Missing required fields.");
}

$call_code = $_POST["call_code"];
$emailTemplate = $_POST["template"];

// Fetch user email from database (Modify this query to match your database structure)
$sql = "SELECT email FROM calls WHERE call_code = '".$call_code."'";
$stmt = Databases::search($sql);

if (!$stmt) {
    die("Database error: " . $conn->error);
}

$result = $stmt->fetch_assoc();

if ($stmt->num_rows === 0) {
    die("Error: No user found with this call code.");
}

$email = $result['email'];

$s = new EmailSender();
echo $s->send($email, $emailTemplate);

class EmailSender
{
    public function send($email, $emailTemplate): string
    {
        return $this->sendCustomEmail($email, $emailTemplate);
    }

    protected function sendCustomEmail($email, $emailTemplate): string
    {
        $mail = new PHPMailer;
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'codylanka00@gmail.com'; // Your Gmail
        $mail->Password = 'jnil boop pwrb sejy';   // Your Gmail App Password
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;

        $mail->setFrom('codylanka00@gmail.com', 'Codyzea');
        $mail->addAddress($email);
        $mail->isHTML(true);
        $mail->Subject = 'Custom Email from Codyzea';
        $mail->Body = $emailTemplate;

        if (!$mail->send()) {
            return "Error: " . $mail->ErrorInfo;
        } else {
            return "Email sent successfully.";
        }
    }
}

?>

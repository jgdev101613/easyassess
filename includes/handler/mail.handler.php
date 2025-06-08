<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../Mail/src/Exception.php';
require '../Mail/src/PHPMailer.php';
require '../Mail/src/SMTP.php';
require_once '../database/dbh.inc.php';

class AccountMailer
{
    private PHPMailer $mail;

    public function __construct()
    {
        $this->mail = new PHPMailer(true);
        $this->configureSMTP();
    }

    private function configureSMTP(): void
    {
        $this->mail->isSMTP();
        $this->mail->Host = 'smtp.gmail.com';
        $this->mail->SMTPAuth = true;
        $this->mail->Username = 'jgdev101613@gmail.com';
        $this->mail->Password = 'bjbl usgj ajyp krqz';
        $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $this->mail->Port = 587;
        $this->mail->setFrom('jgdev101613@gmail.com', 'Easy Assess');
        $this->mail->isHTML(true);
    }

    public function sendActivationEmail(string $accountType, string $recipientEmail): void
    {
        $this->sendEmail(
            $recipientEmail,
            "Account Activation ($accountType)",
            __DIR__ . '/../../assets/saclilogo.png',
            'Your account has been activated!',
            '<p>We are pleased to inform you that your account has been successfully activated. You can now access all our services and features</p>'
        );
    }

    public function sendDeactivationEmail(string $accountType, string $recipientEmail): void
    {
        $this->sendEmail(
            $recipientEmail,
            "Account Deactivation ($accountType)",
            __DIR__ . '/data/item_images/logowithbg.jpg',
            'Your Account Has Been Deactivated',
            '<p>We regret to inform you that your account has been deactivated due to a violation of our policies and guidelines.</p>'
        );
    }

    public function sendRegistrationEmail(string $accountType, string $recipientEmail): void
    {
        $this->sendEmail(
            $recipientEmail,
            "Account Registration ($accountType)",
            __DIR__ . '/../../assets/saclilogo.png',
            'Welcome to SACLI - Easy Assess',
            '<p>Your registration is currently being reviewed by our administration team. You will receive an email once your profile has been approved.</p>'
        );
    }

    public function sendForgotPasswordEmail(string $link, string $recipientEmail): void
    {
        $this->sendEmail(
            $recipientEmail,
            'Change Password',
            '../../data/item_images/logowithbg.jpg',
            'Password Reset Request',
            "<p>To reset your password, please click the button below:</p><a href='$link' style='padding: 10px 20px; background: #000; color: #fff; text-decoration: none;'>Reset Password</a>"
        );
    }

    private function sendEmail(string $recipient, string $subject, string $imagePath, string $headerText, string $contentHtml): void
    {
        try {
            $this->mail->clearAddresses();
            $this->mail->addAddress($recipient);
            $this->mail->Subject = $subject;
            $this->mail->AddEmbeddedImage($imagePath, 'logo_img');

            $this->mail->Body = "
                <html>
                <head><style>
                    body { font-family: Arial; color: #333; padding: 20px; background: linear-gradient(135deg, #ffffff, #000000); }
                    .email-container { max-width: 600px; margin: auto; background: #fff; padding: 20px; border-radius: 10px; }
                    .header {text-align: center;}
                    .header img { width: 150px; }
                    .content, .footer { text-align: center; font-size: 16px; line-height: 1.5; }
                </style></head>
                <body>
                    <div class='email-container'>
                        <div class='header'><img src='cid:logo_img' alt='System Logo'><h2>$headerText</h2></div>
                        <div class='content'>$contentHtml</div>
                        <div class='content'><small>Easy Assess is an online clearance system built for Saint Anne College (SACLI) students. It helps students complete evaluations, monitor their clearance status, and get approvals from departments — all in one easy-to-use platform.</small></div>
                        <div class='footer'><p>Need help? Contact us at <strong>+63 991 7822 877</strong></p></div>
                    </div>
                </body>
                </html>";

            $this->mail->send();
        } catch (Exception $e) {
            echo "Mailer Error: {$this->mail->ErrorInfo}";
        }
    }
}

// Example usage:
// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//     $mailer = new AccountMailer();

//     if (isset($_POST['userDetailsUserEmail'])) {
//         $email = $_POST['userDetailsUserEmail'];
//         $type = $_POST['userDetailsUserPosition'];
//         $status = $_POST['userDetailsUserStatus'];

//         if ($status === 'Active') {
//             echo '<div class="alert alert-warning">Account already activated!</div>';
//             exit;
//         }

//         $stmt = $conn->prepare('UPDATE user SET status = :status WHERE email = :email');
//         $stmt->execute(['status' => 'Active', 'email' => $email]);

//         $mailer->sendActivationEmail($type, $email);
//         echo '<div class="alert alert-success">Account Activated Successfully!</div>';
//         exit;
//     }

//     // Deactivation or other POST actions can follow similar structure.
// }

$email = "felicisimojv@gmail.com";
$type = "student";
$status = 'deactivate';

$mailer = new AccountMailer();

if ($status === 'Active') {
    echo '<div class="alert alert-warning">Account already activated!</div>';
    exit;
}

$mailer->sendRegistrationEmail($type, $email);
exit;

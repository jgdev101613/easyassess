<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../Mail/src/Exception.php';
require '../Mail/src/PHPMailer.php';
require '../Mail/src/SMTP.php';
require_once '../database/dbh.inc.php';

header('Content-Type: application/json');

class AccountMailer
{
    private PHPMailer $mail;
    private PDO $db;

    public function __construct(PDO $conn)
    {
        $this->db = $conn;
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

    public function handleActivation(string $email, string $accountType, string $currentStatus): array
    {
        if ($currentStatus === 'Active') {
            return ['status' => 'warning', 'message' => 'Account already activated!'];
        }

        $stmt = $this->db->prepare("UPDATE user SET status = 'Active' WHERE email = :email");
        $stmt->execute(['email' => $email]);

        $this->sendActivationEmail($accountType, $email);

        return ['status' => 'success', 'message' => 'Account activated successfully!'];
    }

    public function handleDeactivation(string $userID, string $email, string $accountType, string $currentStatus): array
    {
        if ($currentStatus === 'Disabled') {
            return ['status' => 'warning', 'message' => 'Account already deactivated!'];
        }

        $stmt = $this->db->prepare("UPDATE user SET status = 'Disabled' WHERE userID = :userID");
        $stmt->execute(['userID' => $userID]);

        $this->sendDeactivationEmail($accountType, $email);

        return ['status' => 'success', 'message' => 'Account deactivated successfully!'];
    }

    public function sendActivationEmail(string $accountType, string $recipientEmail): void
    {
        $this->sendEmail(
            $recipientEmail,
            "Account Activation ($accountType)",
            __DIR__ . '/../../assets/saclilogo.png',
            'Your account has been activated!',
            '<p>You can now access all services and features.</p>'
        );
    }

    public function sendDeactivationEmail(string $accountType, string $recipientEmail): void
    {
        $this->sendEmail(
            $recipientEmail,
            "Account Deactivation ($accountType)",
            __DIR__ . '/data/item_images/logowithbg.jpg',
            'Your Account Has Been Deactivated',
            '<p>Please contact support if this was an error.</p>'
        );
    }

    public function sendRegistrationEmail(string $accountType, string $recipientEmail): void
    {
        $this->sendEmail(
            $recipientEmail,
            "Account Registration ($accountType)",
            __DIR__ . '/../../assets/saclilogo.png',
            'Welcome to SACLI - Easy Assess',
            '<p>Your registration is under review by school administrator. You will receive an email once your account has been approved.</p>'
        );
    }

    public function sendForgotPasswordEmail(string $link, string $recipientEmail): void
    {
        $this->sendEmail(
            $recipientEmail,
            'Change Password',
            __DIR__ . '/data/item_images/logowithbg.jpg',
            'Password Reset Request',
            "<p>Click the link to reset your password:</p><a href='$link' style='padding:10px 20px;background:#000;color:#fff;text-decoration:none;'>Reset Password</a>"
        );
    }

    private function sendEmail(string $recipient, string $subject, string $imagePath, string $headerText, string $contentHtml): void
    {
        try {
            $this->mail->clearAllRecipients();
            $this->mail->addAddress($recipient);
            $this->mail->Subject = $subject;
            $this->mail->AddEmbeddedImage($imagePath, 'logo_img');

            $this->mail->Body = "
                <html>
                <head><style>
                    body { font-family: Arial; background: #f4f4f4; padding: 20px; }
                    .email-container { max-width: 600px; margin: auto; background: #fff; padding: 20px; border-radius: 10px; }
                    .header img { width: 150px; }
                    .header h2 { margin: 10px 0; }
                    .content, .footer { text-align: center; font-size: 16px; line-height: 1.5; }
                </style></head>
                <body>
                    <div class='email-container'>
                        <div class='header' style='text-align:center;'>
                            <img src='cid:logo_img' alt='System Logo'>
                            <h2>$headerText</h2>
                        </div>
                        <div class='content'>$contentHtml</div>
                        <div class='content'><small>Easy Assess is an online clearance system for SACLI students.</small></div>
                        <div class='footer'><p>Need help? Contact us at <strong>+63 991 7822 877</strong></p></div>
                    </div>
                </body>
                </html>";
            $this->mail->send();
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => $this->mail->ErrorInfo]);
            exit;
        }
    }
}
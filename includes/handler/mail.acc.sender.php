<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../Mail/src/Exception.php';
require '../Mail/src/PHPMailer.php';
require '../Mail/src/SMTP.php';
require_once '../database/dbh.inc.php';

class AccountMailer {
    private PHPMailer $mail;
    private PDO $db;

    public function __construct(PDO $conn) {
        $this->db = $conn;
        $this->mail = new PHPMailer(true);
        $this->configureMailer();
    }

    private function configureMailer(): void {
        $this->mail->isSMTP();
        $this->mail->Host = 'smtp.gmail.com';
        $this->mail->SMTPAuth = true;
        $this->mail->Username = 'jgdev101613@gmail.com';
        $this->mail->Password = 'bjbl usgj ajyp krqz';
        $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $this->mail->Port = 587;
        $this->mail->setFrom('jgdev101613@gmail.com', 'Easy Assess');
    }

    public function handleActivation(string $email, string $accountType, string $currentStatus): void {
        if ($currentStatus === 'Active') {
            $this->renderAlert('warning', 'Account already activated!');
            return;
        }

        $stmt = $this->db->prepare("UPDATE user SET status = 'Active' WHERE email = :email");
        $stmt->execute(['email' => $email]);

        $this->sendAccountEmail('activated', $accountType, $email);
        $this->renderAlert('success', 'Account Activated Successfully!');
    }

    public function handleDeactivation(string $userID, string $email, string $accountType, string $currentStatus): void {
        if ($currentStatus === 'Disabled') {
            $this->renderAlert('warning', 'Account already deactivated!');
            return;
        }

        $stmt = $this->db->prepare("UPDATE user SET status = 'Disabled' WHERE userID = :userID");
        $stmt->execute(['userID' => $userID]);

        $this->sendAccountEmail('deactivated', $accountType, $email);
        $this->renderAlert('success', 'Account Deactivated Successfully!');
    }

    public function sendAccountEmail(string $type, string $accountType, string $recipientEmail): void {
        try {
            $this->mail->clearAllRecipients();
            $this->mail->addAddress($recipientEmail);
            $this->mail->isHTML(true);
            $this->mail->AddEmbeddedImage(__DIR__ . '/../../assets/saclilogo.png', 'logo_img');

            switch ($type) {
                case 'activated':
                    $this->mail->Subject = "Account Activation ({$accountType})";
                    $this->mail->Body = $this->getEmailTemplate('activated');
                    break;
                case 'deactivated':
                    $this->mail->Subject = "Account Deactivation ({$accountType})";
                    $this->mail->Body = $this->getEmailTemplate('deactivated');
                    break;
                case 'register':
                    $this->mail->Subject = "Account Registration ({$accountType})";
                    $this->mail->Body = $this->getEmailTemplate('register');
                    break;
            }

            $this->mail->send();
        } catch (Exception $e) {
            echo "Mailer Error: {$this->mail->ErrorInfo}";
        }
    }

    public function sendForgotPassword(string $link, string $recipientEmail): void {
        try {
            $this->mail->clearAllRecipients();
            $this->mail->addAddress($recipientEmail);
            $this->mail->isHTML(true);
            $this->mail->Subject = "Change Password";
            $this->mail->AddEmbeddedImage(__DIR__ . '/data/item_images/logowithbg.jpg', 'logo_img');
            $this->mail->Body = $this->getEmailTemplate('forgot', $link);
            $this->mail->send();
        } catch (Exception $e) {
            echo "Mailer Error: {$this->mail->ErrorInfo}";
        }
    }

    private function getEmailTemplate(string $type, string $link = ''): string {
        $templates = [
            'activated' => "<h2>Your account has been activated!</h2><p>You can now access our services.</p>",
            'deactivated' => "<h2>Your account has been deactivated.</h2><p>Please contact support if this was an error.</p>",
            'register' => "<h2>Thank you for registering!</h2><p>Your account is under review.</p>",
            'forgot' => "<h2>Password Reset Request</h2><p>Click the link to reset your password: <a href='{$link}'>Reset Password</a></p>",
        ];

        return "
        <html>
        <head><style>body{font-family:Arial;background:#fff;padding:20px;}</style></head>
        <body>
        <div style='max-width:600px;margin:auto;border:1px solid #ccc;padding:20px;'>
            <div style='text-align:center;'><img src='cid:logo_img' width='120' /></div>
            {$templates[$type]}
            <div style='margin-top:20px;text-align:center;font-size:12px;color:#777;'>Contact us at +63 906 236 4630</div>
        </div>
        </body>
        </html>
        ";
    }

    private function renderAlert(string $type, string $message): void {
        echo "<div class='alert alert-{$type}'><button type='button' class='close' data-dismiss='alert'>&times;</button>{$message}</div>";
    }
}

$db = $conn;

$mailer = new AccountMailer($db);

$mailer->handleActivation(
    $_POST['userDetailsUserEmail'],
    $_POST['userDetailsUserPosition'],
    $_POST['userDetailsUserStatus']
);


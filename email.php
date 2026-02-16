<?php
require_once 'db.php';
require 'vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
$templateid = 1;
$isopen = 0;
$useremail = 'demo.user@example.com'; // Demo recipient email
date_default_timezone_set('Asia/Kolkata');
$currentDateTime = date("Y-m-d H:i:s");
$stmt = $conn->prepare("INSERT INTO mail_logs (email, template_id, is_opened, sent_at) VALUES (?, ?, ?, ?)"); 
$stmt->bind_param("siis", $useremail, $templateid, $isopen, $currentDateTime);
if ($stmt->execute()) {
    $last_id = $conn->insert_id;
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();                                     
        $mail->Host       = 'smtp.yourmailserver.com';   // SMTP server        
        $mail->SMTPAuth   = true;                           
        $mail->Username   = 'no-reply@yourdomain.com';   // SMTP email (demo)       
        $mail->Password   = 'EMAIL_PASSWORD_HERE';       // SMTP password (demo)             
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;    
        $mail->Port       = 465; 
         /* Sender & Receiver */                            
        $mail->setFrom('no-reply@yourdomain.com', 'Your App Name');
        $mail->addAddress($useremail, 'Demo User');
        $mail->isHTML(true);
        $mail->Subject = 'Test Email from Sync Link';
        $mail->Body    = '<h1>This is a test email</h1><p>Sent using <b>PHPMailer</b> with Composer.</p><img src="https://yourdomain.com/email-tracker.php?token='.$last_id.'" width="1" height="1" style="display:none;">';
        $mail->AltBody = 'This is a test email sent using PHPMailer.';
        $mail->send();
        echo "Message has been sent successfully!";
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
} else {
    echo "Failed to save email log: " . $stmt->error;
}


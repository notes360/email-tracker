<?php
require_once 'db.php';
if (isset($_GET['token'])) {
    $token = $_GET['token'];
    date_default_timezone_set('Asia/Kolkata');
    $currentDateTime = date("Y-m-d H:i:s");
    $stmt = $conn->prepare("UPDATE mail_logs SET is_opened = 1, opened_at = ? WHERE id = ? AND is_opened = 0");
    $stmt->bind_param("si", $currentDateTime, $token);
    $stmt->execute();
    header('Content-Type: image/png');
    $image = imagecreatetruecolor(1, 1);
    imagesavealpha($image, true);
    $trans_colour = imagecolorallocatealpha($image, 0, 0, 0, 127);
    imagefill($image, 0, 0, $trans_colour);
    imagepng($image);
    imagedestroy($image);
}
?>
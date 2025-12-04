<?php
include 'Inc.Connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['qrInput'])) {
    $scannedQR = trim($_POST['qrInput']);

    // Fetch the QR code record
    $sql = "SELECT * FROM qrcode WHERE QRCodeID = '$scannedQR'";
    $result = mysqli_query($conn, $sql);

    if ($row = mysqli_fetch_assoc($result)) {
        $userid = $row['GeneratedByUserID'];
        $lockerID = $row['LockerID'];
        $status = $row['Status'];
        $timeExpired = $row['TimeExpired'];

        // Check if QR code is still valid
        if ($status === 'Active' && strtotime($timeExpired) > time()) {
            echo "valid";

            mysqli_query($conn, "UPDATE qrcode SET Status = 'Used' WHERE QRCodeID = '$scannedQR'");
            
            mysqli_query($conn, "INSERT INTO accesslog (UserID, LockerID, QRCodeID, ActionType, ErrorDetails, TimeAttempt)
                VALUES ('$userid', '1', '$scannedQR', 'Scan QR', 'N/A', NOW())");

                

        } else {
            echo "invalid";

            mysqli_query($conn, "INSERT INTO accesslog (UserID, LockerID, QRCodeID, ActionType, ErrorDetails, TimeAttempt)
                VALUES ('$userid', '1', '$scannedQR', 'Scan QR', 'INVALID or EXPIRED QR', NOW())");
        }
    } else {
        echo "invalid";

        mysqli_query($conn, "INSERT INTO accesslog (UserID, LockerID, QRCodeID, ActionType, ErrorDetails, TimeAttempt)
            VALUES (NULL, '1', '$scannedQR', 'Scan QR', 'UNKNOWN QR', NOW())");
    }
}
?>

<?php
session_start();
include 'Inc.Connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['qrData'])) {
    $userid=$_SESSION['userID'];
    $storedQRData = trim($_POST['qrData']);


    $expirationTime = date('Y-m-d H:i:s', strtotime('+5 minutes'));
    $sql = "INSERT INTO qrcode (QRCodeID, GeneratedByUserID, TimeGenerated, TimeExpired, Status) VALUES ('$storedQRData', '$userid', NOW(), '$expirationTime', 'Active')";
    mysqli_query($conn, $sql);

    if (mysqli_query($conn, $sql)) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => mysqli_error($conn)]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
}
?>

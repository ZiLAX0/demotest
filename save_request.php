<?php
require 'db.php';
if (!isset($_SESSION['user_id'])) exit('Доступ запрещён');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $address = $_POST['address'];
    $contact = $_POST['contact'];
    $service = $_POST['service'];
    $date_time = $_POST['date_time'];
    $payment = $_POST['payment'];

    $stmt = $mysqli->prepare("INSERT INTO requests (user_id, address, contact, service, date_time, payment) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssss", $user_id, $address, $contact, $service, $date_time, $payment);
    $stmt->execute();
}
header("Location: profile.php");
exit;
?>

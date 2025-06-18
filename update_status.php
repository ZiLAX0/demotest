<?php
require 'db.php';
if (!isset($_SERVER['PHP_AUTH_USER']) || !isset($_SERVER['PHP_AUTH_PW']) ||
    $_SERVER['PHP_AUTH_USER'] !== 'adminka' || $_SERVER['PHP_AUTH_PW'] !== 'password') {
    header('WWW-Authenticate: Basic realm="Admin Area"');
    header('HTTP/1.0 401 Unauthorized');
    exit('Авторизация требуется');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = (int)$_POST['id'];
    $status = $_POST['status'];
    $reason = trim($_POST['reject_reason']);

    $stmt = $mysqli->prepare("UPDATE requests SET status=?, reject_reason=? WHERE id=?");
    $stmt->bind_param("ssi", $status, $reason, $id);
    $stmt->execute();
}
header("Location: admin.php");
exit;
?>

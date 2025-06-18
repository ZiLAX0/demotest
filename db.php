<?php
$mysqli = new mysqli("localhost", "root", "", "myclean");
if ($mysqli->connect_error) exit("Ошибка подключения: " . $mysqli->connect_error);
session_start();
?>

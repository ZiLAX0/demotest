<?php
require 'db.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $f = trim($_POST['fullname']);
    $p = trim($_POST['phone']);
    $e = trim($_POST['email']);
    $l = trim($_POST['login']);
    $pass = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $stmt = $mysqli->prepare("INSERT INTO users (fullname, phone, email, login, password) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $f, $p, $e, $l, $pass);
    if ($stmt->execute()) header("Location: login.php");
    else $error = "Ошибка регистрации: возможно, логин занят";
}
?>
<!doctype html>
<html lang="ru">
<head>
  <meta charset="utf-8"><title>Регистрация</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
<div class="container w-50">
  <h2>Регистрация</h2>
  <?php if (!empty($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
  <form method="post">
    <input class="form-control mb-2" name="fullname" placeholder="ФИО" required>
    <input class="form-control mb-2" name="phone" placeholder="Телефон" required>
    <input type="email" class="form-control mb-2" name="email" placeholder="Email" required>
    <input class="form-control mb-2" name="login" placeholder="Логин" required>
    <input type="password" class="form-control mb-3" name="password" placeholder="Пароль" required>
    <button class="btn btn-primary" type="submit">Зарегистрироваться</button>
  </form>
  <p class="mt-3">Уже есть аккаунт? <a href="login.php">Войти</a></p>
</div>
</body>
</html>

<?php
require 'db.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $l = trim($_POST['login']);
    $p = $_POST['password'];
    $res = $mysqli->query("SELECT * FROM users WHERE login='$l' LIMIT 1");
    if ($res && $user = $res->fetch_assoc()) {
        if (password_verify($p, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['fullname'];
            header("Location: profile.php");
            exit;
        }
    }
    $error = "Неверный логин или пароль";
}
?>
<!doctype html>
<html lang="ru">
<head>
  <meta charset="utf-8"><title>Вход</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
<div class="container w-50">
  <h2>Вход</h2>
  <?php if (!empty($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
  <form method="post">
    <input class="form-control mb-2" name="login" placeholder="Логин" required>
    <input type="password" class="form-control mb-3" name="password" placeholder="Пароль" required>
    <button class="btn btn-primary" type="submit">Войти</button>
  </form>
  <p class="mt-3">Нет аккаунта? <a href="register.php">Зарегистрироваться</a></p>
</div>
</body>
</html>

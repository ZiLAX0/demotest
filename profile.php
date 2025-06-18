<?php
require 'db.php';
if (!isset($_SESSION['user_id'])) header("Location: login.php");
$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['user_name'];

// Получаем заявки пользователя
$stmt = $mysqli->prepare("SELECT * FROM requests WHERE user_id=? ORDER BY id DESC");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$res = $stmt->get_result();

$services = ['Общий клининг','Генеральная уборка','Послестроительная уборка','Химчистка ковров и мебели'];
$payments = ['Наличные', 'Банковская карта'];
?>
<!doctype html>
<html lang="ru">
<head>
  <meta charset="utf-8"><title>Личный кабинет</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
<div class="container">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Добро пожаловать, <?=htmlspecialchars($user_name)?></h2>
    <a href="logout.php" class="btn btn-danger">Выйти</a>
  </div>

  <h4>История заявок</h4>
  <table class="table table-striped">
    <thead><tr>
      <th>Услуга</th><th>Дата и время</th><th>Статус</th><th>Причина отклонения</th>
    </tr></thead>
    <tbody>
    <?php while($row = $res->fetch_assoc()): ?>
      <tr>
        <td><?=htmlspecialchars($row['service'])?></td>
        <td><?=htmlspecialchars($row['date_time'])?></td>
        <td><?=htmlspecialchars($row['status'])?></td>
        <td><?=htmlspecialchars($row['reject_reason'])?></td>
      </tr>
    <?php endwhile; ?>
    </tbody>
  </table>

  <h4>Новая заявка</h4>
  <form method="post" action="save_request.php" class="w-50">
    <input class="form-control mb-2" name="address" placeholder="Адрес" required>
    <input class="form-control mb-2" name="contact" placeholder="Контактные данные" required>
    <label>Вид услуги</label>
    <select name="service" class="form-select mb-2" required>
      <option value="">Выберите</option>
      <?php foreach($services as $s): ?>
        <option><?=htmlspecialchars($s)?></option>
      <?php endforeach; ?>
    </select>
    <label>Дата и время</label>
    <input type="datetime-local" name="date_time" class="form-control mb-2" required>
    <label>Тип оплаты</label>
    <?php foreach($payments as $pay): ?>
      <div class="form-check">
        <input class="form-check-input" type="radio" name="payment" value="<?=$pay?>" id="<?=$pay?>" required>
        <label class="form-check-label" for="<?=$pay?>"><?=$pay?></label>
      </div>
    <?php endforeach; ?>
    <button class="btn btn-success mt-3" type="submit">Отправить заявку</button>
  </form>
</div>
</body>
</html>

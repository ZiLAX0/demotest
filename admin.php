<?php
require 'db.php';

// Простая авторизация админа
if (!isset($_SERVER['PHP_AUTH_USER']) || !isset($_SERVER['PHP_AUTH_PW']) ||
    $_SERVER['PHP_AUTH_USER'] !== 'adminka' || $_SERVER['PHP_AUTH_PW'] !== 'password') {
    header('WWW-Authenticate: Basic realm="Admin Area"');
    header('HTTP/1.0 401 Unauthorized');
    exit('Авторизация требуется');
}

// Получаем все заявки с данными пользователя
$res = $mysqli->query("SELECT r.*, u.fullname, u.phone, u.email FROM requests r JOIN users u ON r.user_id = u.id ORDER BY r.id DESC");
?>
<!doctype html>
<html lang="ru">
<head>
  <meta charset="utf-8"><title>Админ-панель</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
<div class="container">
  <h2>Панель администратора</h2>
  <table class="table table-bordered">
    <thead><tr>
      <th>ФИО</th><th>Телефон</th><th>Email</th><th>Услуга</th><th>Дата и время</th><th>Статус</th><th>Причина отклонения</th><th>Действия</th>
    </tr></thead>
    <tbody>
    <?php while($r = $res->fetch_assoc()): ?>
      <tr>
        <td><?=htmlspecialchars($r['fullname'])?></td>
        <td><?=htmlspecialchars($r['phone'])?></td>
        <td><?=htmlspecialchars($r['email'])?></td>
        <td><?=htmlspecialchars($r['service'])?></td>
        <td><?=htmlspecialchars($r['date_time'])?></td>
        <td><?=htmlspecialchars($r['status'])?></td>
        <td><?=htmlspecialchars($r['reject_reason'])?></td>
        <td>
          <form method="post" action="update_status.php" class="d-flex flex-column gap-1">
            <input type="hidden" name="id" value="<?=$r['id']?>">
            <select name="status" class="form-select form-select-sm" required>
              <option value="Новая заявка" <?=$r['status']=='Новая заявка'?'selected':''?>>Новая заявка</option>
              <option value="Услуга оказана" <?=$r['status']=='Услуга оказана'?'selected':''?>>Услуга оказана</option>
              <option value="Услуга отменена" <?=$r['status']=='Услуга отменена'?'selected':''?>>Услуга отменена</option>
            </select>
            <input type="text" name="reject_reason" placeholder="Причина отклонения" class="form-control form-control-sm" value="<?=htmlspecialchars($r['reject_reason'])?>">
            <button class="btn btn-sm btn-primary mt-1" type="submit">Обновить</button>
          </form>
        </td>
      </tr>
    <?php endwhile; ?>
    </tbody>
  </table>
</div>
</body>
</html>

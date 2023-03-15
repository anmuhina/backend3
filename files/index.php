<?php
header('Content-Type: text/html; charset=UTF-8');

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  if (!empty($_GET['save'])) {
    print('Спасибо, результаты сохранены.');
  }
  include('form.php');
  exit();
}

$errors = FALSE;
if (empty($_POST['name'])) {
  print('Введите имя.<br/>');
  $errors = TRUE;
}

if (empty($_POST['birth_date'])) {
  print('Введите дату рождения.<br/>');
  $errors = TRUE;
}

if (empty($_POST['email'])) {
  print('Введите почту.<br/>');
  $errors = TRUE;
}

if (empty($_POST['sex'])) {
  print('Выберите пол.<br/>');
  $errors = TRUE;
}

if (empty($_POST['amount_of_limbs'])) {
  print('Выберите количество конечностей.<br/>');
  $errors = TRUE;
}

if (empty($_POST['abilities'])) {
  print('Выберите сверхспособности.<br/>');
  $errors = TRUE;
}

if (empty($_POST['biography'])) {
  print('Заполните биографию.<br/>');
  $errors = TRUE;
}

if (empty($_POST['informed']) || !($_POST['informed'] == 'on' || $_POST['informed'] == 1)) {
  print('Поставьте галочку "С контрактом ознакомлен(а)".<br/>');
  $errors = TRUE;
}

if ($errors) {
  exit();
}

// Сохранение в базу данных.
$user = 'u52811';
$pass = '8150350';
$db = new PDO('mysql:host=localhost;dbname=u52811', $user, $pass,
  [PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]); 

try {
  $stmt = $db->prepare("INSERT INTO application SET name = ?, email = ?, birth_date = ?, sex = ?, amount_of_limbs = ?, biography = ?, informed = ?");
  $stmt -> execute([$_POST['name'], $_POST['email'], $_POST['birth_date'], $_POST['sex'], $_POST['amount_of_limbs'], $_POST['biography'], 1]);
}
catch(PDOException $e) {
  print('Error : ' . $e->getMessage());
  exit();
}

$app_id = $db->lastInsertId();

try{
  $stmt = $db->prepare("REPLACE INTO abilities (id,name_of_ability) VALUES (10, 'Бессмертие'), (20, 'Прохождение сквозь стены'), (30, 'Левитация')");
  $stmt-> execute();
}
catch (PDOException $e) {
        print('Error : ' . $e->getMessage());
        exit();
}

foreach ($_POST['abilities'] as $ability) {
try {
  $stmt = $db->prepare("INSERT INTO link SET app_id = ?, ab_id = ?");
  $stmt -> execute([$app_id, $ability]);
}
catch(PDOException $e) {
  print('Error : ' . $e->getMessage());
  exit();
}
}

header('Location: ?save=1');

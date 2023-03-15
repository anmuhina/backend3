<?php
// Отправляем браузеру правильную кодировку,
// файл index.php должен быть в кодировке UTF-8 без BOM.
header('Content-Type: text/html; charset=UTF-8');

// В суперглобальном массиве $_SERVER PHP сохраняет некторые заголовки запроса HTTP
// и другие сведения о клиненте и сервере, например метод текущего запроса $_SERVER['REQUEST_METHOD'].
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  // В суперглобальном массиве $_GET PHP хранит все параметры, переданные в текущем запросе через URL.
  if (!empty($_GET['save'])) {
    // Если есть параметр save, то выводим сообщение пользователю.
    print('Спасибо, результаты сохранены.');
  }
  // Включаем содержимое файла form.php.
  include('form.php');
  // Завершаем работу скрипта.
  exit();
}
// Иначе, если запрос был методом POST, т.е. нужно проверить данные и сохранить их в XML-файл.

// Проверяем ошибки.
$errors = FALSE;
if (empty($_POST['name'])) {
  print('Введите имя.<br/>');
  $errors = TRUE;
}

//if (empty($_POST['birth_date']) || !is_numeric($_POST['birth_date']) || !preg_match('/^\d+$/', $_POST['birth_date'])) {
  //print('Введите дату рождения.<br/>');
  //$errors = TRUE;
//}
if (empty($_POST['birth_date'])) {
  print('Введите дату рождения.<br/>');
  $errors = TRUE;
}

// *************
// Тут необходимо проверить правильность заполнения всех остальных полей.
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
// *************

if ($errors) {
  // При наличии ошибок завершаем работу скрипта.
  exit();
}

// Сохранение в базу данных.

$user = 'u52811';
$pass = '8150350';
$db = new PDO('mysql:host=localhost;dbname=u52811', $user, $pass,
  [PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]); 

// Подготовленный запрос. Не именованные метки.

//$stateCheckbox = $_POST['check'];

try {
  $stmt = $db->prepare("INSERT INTO application SET name = ?, email = ?, birth_date = ?, sex = ?, amount_of_limbs = ?, biography = ?, informed = ?");
  $stmt -> execute([$_POST['name'], $_POST['email'], $_POST['birth_date'], $_POST['sex'], $_POST['amount_of_limbs'], $_POST['biography'], 1]);
  
  
  if (!$stmt) {
        print('Error : ' . $stmt->errorInfo());
    }
}
catch(PDOException $e) {
  print('Error : ' . $e->getMessage());
  exit();
}

$app_id = $db->lastInsertId();

try {
  $stmt = $db->prepare("INSERT INTO abilities (id,name_of_ability) VALUES (10, 'Бессмертие'), (20, 'Прохождение сквозь стены'), (30, 'Левитация')");
  $stmt-> execute();
}
catch(PDOException $e) {
  print('Error : ' . $e->getMessage());
  exit();
}

/*foreach ($_POST['abilities'] as $ability) {
  for ($i=1; $i<4; $i++) {
    try {
        $stmt = $db->prepare("INSERT INTO abilities SET id = ?,name_of_ability = ?");
        $stmt-> execute([$i, $ability]);
        if (!$stmt) {
            print('Error : ' . $stmt->errorInfo());
        }
    } catch (PDOException $e) {
        print('Error : ' . $e->getMessage());
        exit();
    }
  }
}*/

//$ab_id = $db->lastInsertId();

try {
  $stmt = $db->prepare("INSERT INTO link SET app_id = ?, ab_id = ?");
  $stmt -> execute([$app_id, $_POST['abilities[]']]);
  if (!$stmt) {
        print('Error : ' . $stmt->errorInfo());
    }
}
catch(PDOException $e) {
  print('Error : ' . $e->getMessage());
  exit();
}

/*foreach ($_POST['abilities'] as $ability) {
    try {
        $stmt = $db->prepare("INSERT INTO abilities SET app_id = ?, name_of_ability = ?");
        $stmt->execute([$app_id, $ability]);
        if (!$stmt) {
            print('Error : ' . $stmt->errorInfo());
        }
    } catch (PDOException $e) {
        print('Error : ' . $e->getMessage());
        exit();
    }
}*/



//  stmt - это "дескриптор состояния".
 
//  Именованные метки.
//$stmt = $db->prepare("INSERT INTO test (label,color) VALUES (:label,:color)");
//$stmt -> execute(['label'=>'perfect', 'color'=>'green']);
 
//Еще вариант
/*$stmt = $db->prepare("INSERT INTO users (firstname, lastname, email) VALUES (:firstname, :lastname, :email)");
$stmt->bindParam(':firstname', $firstname);
$stmt->bindParam(':lastname', $lastname);
$stmt->bindParam(':email', $email);
$firstname = "John";
$lastname = "Smith";
$email = "john@test.com";
$stmt->execute();
*/

// Делаем перенаправление.
// Если запись не сохраняется, но ошибок не видно, то можно закомментировать эту строку чтобы увидеть ошибку.
// Если ошибок при этом не видно, то необходимо настроить параметр display_errors для PHP.

header('Location: ?save=1');
//echo "<script>window.location.href = '?save=1';</script>";

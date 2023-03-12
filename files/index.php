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
  include('../index.html');
  // Завершаем работу скрипта.
  exit();
}
// Иначе, если запрос был методом POST, т.е. нужно проверить данные и сохранить их в XML-файл.

// Проверяем ошибки.
$errors = FALSE;
if (empty($_POST['fio'])) {
  print('Введите имя.<br/>');
  $errors = TRUE;
}

//if (empty($_POST['year']) || !is_numeric($_POST['year']) || !preg_match('/^\d+$/', $_POST['year'])) {
  //print('Введите дату рождения.<br/>');
  //$errors = TRUE;
//}


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

if (empty($_POST['limb'])) {
  print('Выберите количество конечностей.<br/>');
  $errors = TRUE;
}

if (empty($_POST['superpowers'])) {
  print('Выберите сверхспособности.<br/>');
  $errors = TRUE;
}

if (empty($_POST['biography'])) {
  print('Заполните биографию.<br/>');
  $errors = TRUE;
}

if (empty($_POST['check'])) {
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
$db = new PDO('mysql:host=localhost;dbname=u52811', $user, $pass, [PDO::ATTR_PERSISTENT => true]);

// Подготовленный запрос. Не именованные метки.

$stateCheckbox = $_POST['check'];

try {
  $stmt = $db->prepare("INSERT INTO application SET name = ?");
  $stmt -> execute(['fio']);
  
  $stmt = $db->prepare("INSERT INTO application SET email = ?");
  $stmt -> execute(['email']);
  $stmt = $db->prepare("INSERT INTO application SET birth_date = ?");
  $stmt -> execute(['year']);
  $stmt = $db->prepare("INSERT INTO application SET sex = ?");
  $stmt -> execute(['sex']);
  $stmt = $db->prepare("INSERT INTO application SET amount_of_limbs = ?");
  $stmt -> execute(['limb']);
  $stmt = $db->prepare("INSERT INTO application SET biography = ?");
  $stmt -> execute(['biography']);
  //$stmt = $db->prepare("INSERT INTO application SET informed = ?");
  //$stmt -> execute(['check']);
  $sql = "INSERT INTO application SET informed = $stateCheckbox";
  
  $stmt = $db->prepare("INSERT INTO abilities SET name_of_ability = ?");
  $stmt -> execute(['name_of_ability'=>'Бессмертие']);
  $stmt = $db->prepare("INSERT INTO abilities SET name_of_ability = ?");
  $stmt -> execute(['name_of_ability'=>'Прохождение сквозь стены']);
  $stmt = $db->prepare("INSERT INTO abilities SET name_of_ability = ?");
  $stmt -> execute(['name_of_ability'=>'Левитация']);
}
catch(PDOException $e){
  print('Error : ' . $e->getMessage());
  exit();
}

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

//header('Location: ?save=1');
header('Location: http://u52811.kubsu-dev.ru/backend3/');
?>

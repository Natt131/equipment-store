
<?php
include('header.php');
?>
<?php
if (isset($_POST['login'])) { $login = $_POST['login']; if ($login == '') { unset($login);} } //заносим введенный пользователем логин в переменную $login, если он пустой, то уничтожаем переменную
if (isset($_POST['password'])) { $password=$_POST['password']; if ($password =='') { unset($password);} }
//заносим введенный пользователем пароль в переменную $password, если он пустой, то уничтожаем переменную
if (empty($login) or empty($password)) //если пользователь не ввел логин или пароль, то выдаем ошибку и останавливаем скрипт
{
    exit ("Вы ввели не всю информацию, вернитесь назад и заполните все поля!");
}
//если логин и пароль введены, то обрабатываем их, чтобы теги и скрипты не работали, мало ли что люди могут ввести
$login = stripslashes($login);
$login = htmlspecialchars($login);
$password = stripslashes($password);
$password = htmlspecialchars($password);
//удаляем лишние пробелы
$login = trim($login);
$password = trim($password);
// подключаемся к базе
include ("bd.php");// файл bd.php должен быть в той же папке, что и все остальные, если это не так, то просто измените путь
// проверка на существование пользователя с таким же логином
$host = 'localhost';
$username  = 'magazin2';
$password = 'magazin2';

$db= mysqli_connect($host, $username, $password, "magazin");

$result = mysqli_query($db,"SELECT id FROM user WHERE login='$login'");
$myrow = mysqli_fetch_array($result);
if (!empty($myrow['id'])) {
    exit ("Извините, введённый вами логин уже зарегистрирован. Введите другой логин.");
}
// если такого нет, то сохраняем данные
$result2 = mysqli_query ($db, "INSERT INTO user (login,password) VALUES('$login','$password')");
$id=mysqli_query($db, "select max(id) from user;");
$result3 = mysqli_query ($db, "INSERT INTO carr (login) VALUES('$login')");
//INSERT INTO users (login,password) VALUES('$login','$password')
// Проверяем, есть ли ошибки

if ($result3=='TRUE')
{
    echo "Вы успешно зарегистрированы! Теперь вы можете зайти на сайт. <a href='..\index.php'>Главная страница</a>";
}
else {
    echo "Ошибка регистрации!";
}
?>
<?php
include('footer.php');
?>

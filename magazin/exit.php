<?php
session_start();


$_SESSION['password'] = null;
$_SESSION['login'] = null;
$_SESSION['id'] = null;
unset($_SESSION['password']);
unset($_SESSION['login']);
unset($_SESSION['id']);
header('Location: index.php');
/*
unset($_SESSION['password']);
unset($_SESSION['login']);
unset($_SESSION['id']);//    уничтожаем переменные в сессиях
exit("<html><head><meta    http-equiv='Refresh' content='0;    URL='..\index.php'></head></html>");
// отправляем пользователя на главную страницу. */
?>
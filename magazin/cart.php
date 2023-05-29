<?php

//  вся процедура работает на сессиях. Именно в ней хранятся данные  пользователя, пока он находится на сайте. Очень важно запустить их в  самом начале странички!!!
session_start();
$host = 'localhost';
$username  = 'magazin2';
$password = 'magazin2';
$id=$_SESSION['id'];
$con = mysqli_connect($host, $username, $password, "magazin");
//echo ($_SESSION['id']."<br>");
$var = $_GET['prod'];
//echo($var."fiorefh");
$result2 = mysqli_query ($con, "INSERT INTO list (id_cart, id_prod) VALUES('$id','$var')");
header('Location: index.php');
?>
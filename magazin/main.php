<?php
//  вся процедура работает на сессиях. Именно в ней хранятся данные  пользователя, пока он находится на сайте. Очень важно запустить их в  самом начале странички!!!
session_start();
?>

<?php
include('header.php');
?>

    <html>
    <head>
        <title>Вход</title>
    </head>
    <body>
    <center>
    <h2>Вход</h2>
    <form action="testreg.php" method="post">

        <!--****  testreg.php - это адрес обработчика. То есть, после нажатия на кнопку  "Войти", данные из полей отправятся на страничку testreg.php методом  "post" ***** -->
        <p>
            <label>Ваш логин:<br></label>
            <input name="login" type="text" size="15" maxlength="15">
        </p>


        <!--**** В текстовое поле (name="login" type="text") пользователь вводит свой логин ***** -->

        <p>

            <label>Ваш пароль:<br></label>
            <input name="password" type="password" size="15" maxlength="15">
        </p>

        <!--**** В поле для паролей (name="password" type="password") пользователь вводит свой пароль ***** -->

        <p>
            <input type="submit" name="submit" value="Войти">

            <!--**** Кнопочка (type="submit") отправляет данные на страничку testreg.php ***** -->
            <br>
            <!--**** ссылка на регистрацию, ведь как-то же должны гости туда попадать ***** -->
        <div class="product_btn">
            <a href="reg.php"> Зарегистрироваться</a> </div>
        </p></form>
    <br>
    </center>
    <?php
    // Проверяем, пусты ли переменные логина и id пользователя
    if (empty($_SESSION['login']) or empty($_SESSION['id']))
    {
        echo "Вы вошли на сайт, как гость. Зарегестрируйтесь, чтобы использовать полный функционал";
        // Если пусты, то мы не выводим ссылку
       // echo "Вы вошли на сайт, как гость<br><a href='#'>Эта ссылка  доступна только зарегистрированным пользователям</a>";
    }
    else
    {

        // Если не пусты, то мы выводим ссылку
        echo "Вы вошли на сайт, как ".$_SESSION['login']."<br>
   (<a    href='exit.php'> выход </a>)";

    }
    ?>
    </body>
    </html>

<?php
include('footer.php');
?>
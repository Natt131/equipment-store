<?
/**
 * @license   licensed under the MIT.
 * @Copyright © 2015 Aminev Marat R. , https://dwweb.ru/
 * @Copyright © 2015 Аминев Марат Р. , https://dwweb.ru/
 */

// Автор скрипта Аминев Марат
// Понравился скрипт?
//  Скажи спасибо :   https://dwweb.ru/help_to_dwweb.ru.html -->
/**
 * @license   licensed under the MIT.
 * @Copyright © 2015 Aminev Marat R. , https://dwweb.ru/
 * @Copyright © 2015 Аминев Марат Р. , https://dwweb.ru/
 */
$title        = 'Dw tree site';
?>
<!-- Автор скрипта Аминев Марат
Понравился скрипт?
Скажи спасибо :   https://dwweb.ru/help_to_dwweb.ru.html -->
<!DOCTYPE html>
<html lang="ru">
<head>
    <META NAME="ROBOTS" CONTENT="NOINDEX,NOFOLLOW">
    <meta charset="utf-8">
    <title><?=$title?></title>
    <style>
        body {
            width: 700px;
            margin: 0 auto;
        }
        main {
            width: 600px;
            margin: 0 auto;
            border: 1px solid;
            padding: 50px;
        }
        details details {
            margin: 0 0 0 20px;
        }
        div span {
            margin: 0 0 0 20px;     color: #b56e00;
        }
        details {
            color: #0058a4; cursor: pointer;
        }
        details[open], details[open] div span  {
            COLOR:  #ac6800;
        }
        summary {
            outline: none;
        }
        div span.plus {
            position: absolute;
            margin: -3px 0 0 -20px;
            color: #04549b;
            cursor: pointer;
        }
        div span.minus {
            position: absolute;
            margin: 3px 0 0 -18px;
            color: red !important;
            cursor: pointer;
            font-size: 11px;
        }
        h1 {
            font-family: system-ui;
            font-weight: 100;
            text-align: center;
            border-bottom: 1px solid #d4d4d4;
            padding-bottom: 9px;
            text-transform: uppercase;
        }
        a.logo img {
            width: 234px !important;
            display: block;
            margin: 20px;
        }
        a#button_podderji_proekt {
            color: red;
            text-decoration: none;
            border-bottom: 1px solid;
            padding-bottom: 1px;
        }
        a {
            color: #7f7f7f;
            text-decoration: none;
            border-bottom: 1px solid;
            font-size: 17px;
            font-family: sans-serif;
            padding-bottom: 1px;
            line-height: 27px;
        }
        a:hover,a#button_podderji_proekt:hover {
            border-bottom: 1px solid #ff000000;
        }
    </style>
</head>
<body>
<a href="https://dwweb.ru" class="logo"> <img src="//dwweb.ru/___file_cms/img/logo.png" alt="alt" title=" ГЛАВНАЯ"> </a>
<h1>Дерево всех папок и файлов.</h1>
Поддомен <span><?=$_SERVER["HTTP_HOST"]?></span>
<p>
    <a href=здесь_ссылка   target=_blank>Описание.</a><br>
    <a href=здесь_ссылка   target=_blank>Скачать.</a><br>
    <a href="#skazat_spasibo" id="button_podderji_proekt">Не забываем сказать спасибо!!!</a>
</p>
<p>
    <center><h3>Работа с FTP-сервером</h3><br>
<form action="" method="post" name="registerform">
    <p><label> <font color="green"> Введите имя хоста:
                <input name="host" size="30" type="text" value="<?= $_POST['host'] ?>"></p></label> </font>
    <p><label> <font color="green"> Логин:
                <input name="login" size="30" type="text" value="<?= $_POST['login'] ?>"></p></label> </font>
    <p><label> <font color="green"> Пароль:
                <input name="pass" size="30" type="text" value="<?= $_POST['pass'] ?>"></p></label> </font>

    <p><input name="register" type="submit" value="Найти файлы!"></p>
</form>
</p>
<main>
    <?php
    ini_set('max_execution_time', '300');
    if (isset($_POST["host"])&&($_POST["pass"])&&($_POST["login"])) {
        $arrayFiles = array();
        $arrayCatalogs=array();
        $size=0;
        $sizej=0;
        $sized=0;
        $sizep=0;
        $sizem=0;
        $sizepd=0;
        $sizepp=0;

        $dir = array();
        $file = array();
        $info = array();


//данные для ftp
        $host = $_POST['host'];
        $login = $_POST['login'];
        $pass = $_POST['pass'];

        //Connect
        $conn = ftp_connect($host);
        $login = ftp_login($conn, $login, $pass);

//рекурсивный проход по директориям и возврат
        function rawlist_dump($ftp_connect, $dir) {
            //  global $ftp_connect;
            $ftp_rawlist = ftp_rawlist($ftp_connect, $dir);
            foreach ($ftp_rawlist as $v) {
                $info = array();
                $vinfo = preg_split("/[\s]+/", $v, 9);
                if ($vinfo[0] !== "total") {
                    $info['chmod'] = $vinfo[0];
                    $info['num'] = $vinfo[1];
                    $info['owner'] = $vinfo[2];
                    $info['group'] = $vinfo[3];
                    $info['size'] = $vinfo[4];
                    $info['month'] = $vinfo[5];
                    $info['day'] = $vinfo[6];
                    $info['time'] = $vinfo[7];
                    $info['name'] = $vinfo[8];
                    $rawlist[$info['name']] = $info;
                }
            }
            $dir1 = array();
            $file = array();
            foreach ($rawlist as $k => $v) {
                if ($v['chmod']{0} == "d") {
                    $dir1[$k] = $v;
                } elseif ($v['chmod']{0} == "-") {
                    $file[$k] = $v;
                }
            }
            /* foreach ($dir1 as $dirname => $dirinfo) {
                    rawlist_dump($ftp_connect, "$dirname");}*/
            /*            rawlist_dump($ftp_connect, "$dirname");*/
            $d=array();
            $f=array();
            foreach ($dir1 as $dirname => $dirinfo) {
                $d[]=$dirname;
                //if (!is_dir($d)) print ("yugyur");
            }
            foreach ($file as $filename => $fileinfo) {
                $f[]=$filename;
            }
            $arrays= @array_merge($d, $f);

            // $arrays= @array_merge($dir1, $file);

            //криво косо работало
            /*   foreach ($arrays as $dirname => $dirinfo) {
                //   rawlist_dump($ftp_connect, "$dirname");

                   echo '<div>';
                   $is_dir = is_dir($dirname );
                   echo  $is_dir ? '<span class="plus" title="сделать папку или файл">✛</span><details><summary>' : '<span class="minus" title="удалить файл">✖</span><span>', '',  htmlspecialchars($dirname ), $is_dir ? '</summary> ' : '</span>';

               }*/


            /*          foreach ($dir as $dirname => $dirinfo) {
                          echo "[ $dirname ] " . $dirinfo['chmod'] . " | " . $dirinfo['owner'] . " | " . $dirinfo['group'] . " | " . $dirinfo['month'] . " " . $dirinfo['day'] . " " . $dirinfo['time'] . "<br>";
                      }
                      foreach ($file as $filename => $fileinfo) {
                          echo "$filename " . $fileinfo['chmod'] . " | " . $fileinfo['owner'] . " | " . $fileinfo['group'] . " | " . $fileinfo['size'] . " Byte | " . $fileinfo['month'] . " " . $fileinfo['day'] . " " . $fileinfo['time'] . "<br>";
                      }*/
            return $arrays;
        }
//вывод
        function diropen($ftp, $dir)
        {
            $arrays =   rawlist_dump($ftp, $dir) ;
            if ($arrays)
            {
                echo '<div>';
                foreach ($arrays as $liner)
                {
                    echo '<div>';

                    // if (is_dir($liner)) print ("yugyur");
                    //  $path = $dir . '/' . $liner;
                    if(ftp_size ($ftp, $liner)=='-1')
                    { $is_dir =true;
                       // $temp=$liner;
                    } else $is_dir =false;
                    // $is_dir = is_dir($path);
                    echo  $is_dir ? '<span class="plus" title="сделать папку или файл">✛</span><details><summary>' : '<span class="minus" title="удалить файл">✖</span><span>', '',  htmlspecialchars($liner), $is_dir ? '</summary> ' : '</span>';
                    if (($is_dir)&&($liner!='.')&&($liner!='..'))  diropen( $ftp, $liner);  echo '</div>';
                }
                echo '</div>';
            }
        }

//test php.site
        diropen($conn, ".");
    }
    ?>
</main>
</body>
</html>

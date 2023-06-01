<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; Charset=UTF-8">
    <title>Вариант 2</title>
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
            margin: 0 0 0 20px;     color: #6f70b9;
        }
        details {
            color: #0058a4; cursor: pointer;
        }
        details[open], details[open] div span  {
            COLOR: #6f70b9;
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
    </style>
</head>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; Charset=UTF-8">
    <title>Вариант 2</title>
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
            margin: 0 0 0 20px;
            color: #6f70b9;
        }

        details {
            color: #0058a4;
            cursor: pointer;
        }

        details[open], details[open] div span {
            COLOR: #6f70b9;
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
    </style>
</head>
<body>
<br>
<center><h3>Работа с FTP-сервером</h3><br>
    <form action="" method="post" name="registerform">
        <p><label> <font color="green"> Введите имя хоста:
                    <input name="host" size="30" type="text" value="<?= $_POST['host'] ?>"></p></label> </font>
        <p><label> <font color="green"> Логин:
                    <input name="login" size="30" type="text" value="<?= $_POST['login'] ?>"></p></label> </font>
        <p><label> <font color="green"> Пароль:
                    <input name="pass" size="30" type="text" value="<?= $_POST['pass'] ?>"></p></label> </font>

        <p><input name="register" type="submit" value="Посторить дерево всех папок и файлов."></p>
    </form>


    <?php
    ini_set('max_execution_time', '300');
    if (isset($_POST["host"]) && ($_POST["pass"]) && ($_POST["login"])) {
        $arrayFiles = array();
        $arrayCatalogs = array();
        $size = 0;
        $sizej = 0;
        $sized = 0;
        $sizep = 0;
        $sizem = 0;
        $sizepd = 0;
        $sizepp = 0;

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
        function rawlist_dump($ftp_connect, $dir)
        {
            //  global $ftp_connect;
            global $size;
            global $sizej;
            global $sized;
            global $sizep;
            global $sizem;
            global $sizepd;
            global $sizepp;
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
            $d = array();
            $f = array();
            foreach ($dir1 as $dirname => $dirinfo) {
                $d[] = $dirname;

                //if (!is_dir($d)) print ("yugyur");
            }
            foreach ($file as $filename => $fileinfo) {
                $f[] = $filename;
                $size = +$fileinfo['size'];
                //  $size=$size+ settype($fileinfo['size'], 'integer')+10;
                if (strpos($filename, "jpg")) $sizej = +$fileinfo['size'];
                else if (strpos($filename, "doc")) $sized = +$fileinfo['size'];
                else if (strpos($filename, "php")) $sizep = +$fileinfo['size'];
                else if (strpos($filename, "msi")) $sizem = +$fileinfo['size'];
                else if (strpos($filename, "pdf")) $sizepd = +$fileinfo['size'];
                else if (strpos($filename, "ppt")) $sizepp = +$fileinfo['size'];
            }
            $arrays = @array_merge($d, $f);
            return $arrays;
        }

//вывод
        function diropen($ftp, $dir)
        {
            $arrays = rawlist_dump($ftp, $dir);
            if ($arrays) {
                echo '<div>';
                foreach ($arrays as $liner)
                    if ($liner != '..' and $liner != '.') {
                        echo '<div>';

                        // if (is_dir($liner)) print ("yugyur");
                        if (ftp_size($ftp, $dir . '/' . $liner) == '-1') {
                            $is_dir = true;
                        } else {
                            $is_dir = false;
                        }
                        /*if(ftp_nlist ($ftp, $liner)==false) {
                            $is_dir = false;
                        } else {
                            $is_dir = true;
                        }
                        */
                        echo $is_dir ? '<span class="plus" title="сделать папку или файл"> </span><details><summary>' : '<span class="minus" title="файл">✖</span><span>', '', htmlspecialchars($liner), $is_dir ? '</summary> ' : '</span>';
                        if ($is_dir) diropen($ftp, $dir . '/' . $liner);
                        echo '</div>';
                    }
                echo '</div>';
            }
        }

        diropen($conn, "");
        print("<br> Размерность всех файлов(кб): " . round(($size / 1024), 1));
        print("<br> Размерность  файлов jpg: " . round(($sizej / 1024), 1) . " doc: " . round(($sized / 1024), 1) . " php: " . round(($sizep / 1024), 1) . " msi: " . round(($sizem / 1024), 1) . " pdf: " . round(($sizepd / 1024), 1) . " pptx " . round(($sizepp / 1024), 1));
    }
    ?>
</center>
</body>
</html>
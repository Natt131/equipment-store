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
<br>
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


    <?php
    ini_set('max_execution_time', '300');
    if (isset($_POST["host"])&&($_POST["pass"])&&($_POST["login"])) {

        $arrayTypes = array();
        $arrayFiles = array();
       // global $arrayCatalogs; //работает, кром еосновной проги
        $arrayCatalogs=array();
 $size=0;
        $sizej=0;
        $sized=0;
        $sizep=0;
        $sizem=0;
        $sizepd=0;
        $sizepp=0;

        $sizze=array();
        $arrayHrefRead = array();
$k=0;

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
        function list_dir($ftp_stream, $directory)
        {
            global $arrayCatalogs;
            $ftp_rawlist = ftp_rawlist($ftp_stream, $directory);//.
            foreach ($ftp_rawlist as $v) {
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
            foreach ($rawlist as $k => $v) {
                if ($v['chmod']{0} == "d") {
                    $dir[$k] = $v;
                    $arrayCatalogs[$k]=$v;
                } elseif ($v['chmod']{0} == "-") {
                    $file[$k] = $v;
                }
            }
            foreach ($arrayCatalogs as $dirname => $dirinfo) {
               // print($sp);
              //  echo "ДИРЕКТОРИЯ:"."[ $dirname ] ";
                //echo $sp."[ $dirname ] " . $dirinfo['chmod'] . " | " . $dirinfo['owner'] . " | " . $dirinfo['group'] . " | " . $dirinfo['month'] . " " . $dirinfo['day'] . " " . $dirinfo['time'] . "<br>";
                get_files($ftp_stream,$dirname);
                list_dir($ftp_stream, $dirname);
                print("<br>");
            }


                return $arrayCatalogs;
        }
function get_files ($ftp_stream, $directory)
{
    global $arrayFiles;
    $ftp_rawlist = ftp_rawlist($ftp_stream, $directory);//.
    foreach ($ftp_rawlist as $v) {
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
    foreach ($rawlist as $k => $v) {
        if  ($v['chmod']{0} == "-") {
            $file[$k] = $v;
            $arrayFiles[$k]=$v;
        }
    }

    global $size;
    global $sizej;
    global $sized;
    global $sizep;
    global $sizem;
    global $sizepd;
    global $sizepp;

    foreach ($arrayFiles as $filename => $fileinfo) {
      //  echo "$filename " .  $fileinfo['size'] . " Byte | " . $fileinfo['month'] . " " . $fileinfo['day'] . " " . $fileinfo['time'] . "<br>";
$size=$size+ settype($fileinfo['size'], 'integer')+10;
if(strpos($filename,"jpg")) $sizej=+$fileinfo['size'] ;
    else if (strpos($filename,"doc")) $sized=+$fileinfo['size'] ;
    else if (strpos($filename,"php")) $sizep=+$fileinfo['size'] ;
    else if (strpos($filename,"msi")) $sizem=+$fileinfo['size'] ;
    else if (strpos($filename,"pdf")) $sizepd=+$fileinfo['size'] ;
    else if(strpos($filename,"ppt")) $sizepp=+$fileinfo['size'] ;
   // settype($fileinfo['size'], 'integer');
  // $fileinfo['size']= $fileinfo['size']+2000;
  //  print($sized."uihy ". $fileinfo['size']);
       // echo "$filename " . $fileinfo['chmod'] . " | " . $fileinfo['owner'] . " | " . $fileinfo['group'] . " | " . $fileinfo['size'] . " Byte | " . $fileinfo['month'] . " " . $fileinfo['day'] . " " . $fileinfo['time'] . "<br>";
    }
    return $arrayFiles;
}
//новый код
        function diropen( $arrayCat, $arrayF, $ftp)
        {
            //$dirs=list_dir($conn, ".");
           // $arrays =   @array_merge ( list_dir($conn, "."), get_files($conn,$dir)) ;
             $arrays =   @array_merge ( $arrayCat, $arrayF) ;

            if ($arrays)
            {
                echo '<div>';
                foreach ($arrays as $liner)
                {
                    echo '<div>';

                   // $path = $dir . '/' . $liner;
                    $is_dir = is_dir( $liner);
                    echo  $is_dir ? '<span class="plus" title="сделать папку или файл">✛</span><details><summary>' : '<span class="minus" title="удалить файл">✖</span><span>', '',  htmlspecialchars($liner), $is_dir ? '</summary> ' : '</span>';
                    //if ($is_dir)  diropen( $dir);  echo '</div>';
                }
                echo '</div>';
            }
        }
        //diropen( ".", $conn);
        //конец нового

//test php.site
        $vg= list_dir($conn, ".");
        diropen( $arrayCatalogs, $arrayFiles, $conn);
        print("<br> Размерность всех файлов(кб): ".$size);
        print("<br> Размерность  файлов jpg: ".$sizej."doc: ".$sized."php: ".$sizep."msi:".$sizem."pdf:".$sizepd."pptx".$sizepp);
    }
    ?>
</center>
</body>
</html>
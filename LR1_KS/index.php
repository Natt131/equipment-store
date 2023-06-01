<html<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; Charset=UTF-8">
    <title>Вариант 2</title>
</head>
<body>
<br>
<center><h3>Составить и вывести список всех рисунков, используемых страницами www-сервера. Вывод разделить на две части:
        рисунки,
        расположенные на сервере, и рисунки, расположенные на других
        серверах</h3><br>
    <form action="" method="post" name="registerform">
        <p><label> <font color="green"> Введите Адрес www-сервера:
                    <input name="site" size="30" type="text" value="<?= $_POST['site'] ?>"></p></label> </font>

        <p><input name="register" type="submit" value="Найти картинки и ссылки!"></p>
    </form>


    <?php
    if (isset($_POST["site"])) {

        $arrayImage = array();
        $arrayHref = array();
        $arrayHrefRead = array();

        $site = $_POST['site'];
        $arrayHref[] = $site;

        function search_pic($file1)
        {
            preg_match_all("|<img[\s]+.*?src=[\"']?([^\"'\s]*)[\"']?[^>]*>|i", $file1, $regs);
            return $regs[1];
        }

        function search_href($file1)
        {
            preg_match_all("/<[Aa][\s]{1}[^>]*[Hh][Rr][Ee][Ff][^=]*=[ '\"\s]*([^ \"'>\s#]+)[^>]*>/", $file1, $regs);
            return $regs[1];
        }

        while (count($arrayHref) > 0) {
            $currentHref = array_shift($arrayHref);
            $arrayHrefRead[] = $currentHref;
            $file = file_get_contents($currentHref); //получаем html код введенного сайта страницы
            if ($file !== FALSE) {
                $url = $currentHref;

                print ("<br>" . "<b>ССЫЛКИ НА КАРТИНКИ С " . $url . "</b><br>");
                $url = str_replace('http://', '', $url);
                $url = str_replace('https://', '', $url);
                //$url = str_replace('/', '', $url); //получаем сайт для сортировки ссылок

                $arrayImage = search_pic($file);
                for ($i = 0; $i < count($arrayImage); $i++) {
                    print('<br><a href="' . $site . str_replace('..','',$arrayImage[$i]) . '" target="_blank" > ' . $arrayImage[$i] . '</a>');
                    $color = "blue";
                    $color1 = "red";
                    if (substr($arrayImage[$i], 0, 7) == 'http://' || substr($arrayImage[$i], 0, 8) == 'https://') {
                        if (strpos($arrayImage[$i], $site) !== false) {
                            print ("<font color=$color> внутренняя </font> <br>");
                        } else print ("<font color=$color1> внешняя </font> <br>");
                    } else print ("<font color=$color> внутренняя </font> <br>");
                }

                $links = search_href($file);
                for ($i = 0; $i < count($links); $i++) {
                    if (((substr($links[$i], 0, 4) == 'http') && (strpos($links[$i], $site) == true))) {
                        if (!(in_array($links[$i], $arrayHrefRead) || in_array($links[$i], $arrayHref))) {
                            $arrayHref[] = $links[$i];
                        }
                    } else if (substr($links[$i], 0, 4) != 'http') {
                        if (!(in_array($site . $links[$i], $arrayHrefRead) || in_array($site . $links[$i], $arrayHref))) {
                            $arrayHref[] = $site . $links[$i];
                        }
                    }
                }
            };
        };
    };
    ?>
</center>
</body>
</html>
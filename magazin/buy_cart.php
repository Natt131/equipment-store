<?php
$id=$_GET['id'];

/*$host = 'localhost';
$username  = 'magazin2';
$password = 'magazin2';

$con = mysqli_connect($host, $username, $password, "magazin");

$query = mysqli_query($con, "SELECT * FROM magazin.products where id = $id");
$products = mysqli_fetch_array($query);*/
$var = $_GET['prod'];
?>

<?php
include('header.php');
?>



    <div class="container">
        <div class="row">

            <div class="col-lg-12 contant_wrap">

                <div class="navigation">
                    <ul>
                        <li><a href="../"><i class="glyphicon glyphicon-home"></i></a></li>

                        <li><a href="<?= 'catalog.php' ?>">Каталог</a></li>

                        <li><a href="<?= 'listproducts.php?id='.$categories['id'] ?>"><?php echo $categories['name']; ?></a></li>

                        <li><span> <?php echo $products['name']; ?></span></li>

                    </ul>

                </div>

            </div>

        </div>


        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">


                <div class="short_description">


                    <form action="" method="post" name="registerform">
                        <p><label>Введите ФИО заказчика:
                                <input name="name" size="30" type="text" value="<?= $_POST['name']?>"></label></p>
                        <p><label>Введите номер телефона:
                                <input name="number" size="30" type="text" value="<?= $_POST['number']?>"></label></p>

                        <p><label>Адрес склада:
                                <input name="x_from" size="30" type="text" value="Самара Московское шоссе 34 б" readonly> </p>
                        <p><label>Адрес доставки:
                                <input name="x_to" size="30" type="text" value="<?= $_POST['x_to']?>"> </p>


                        <p><input name="registr" type="submit" value="Рассчитать стоимость доставки!"></p>
                    </form>
                    <?php



                    if ((isset($_POST['x_from']))and (isset($_POST['x_to']))and (isset($_POST['name']))and (isset($_POST['number'])) )
                    {
                        $from = $_POST['x_from'];
                        $to =  $_POST['x_to'];

                        //связь с гугл картами и вычисление

                        $from = urlencode($from);
                        $to = urlencode($to);
                        $data = file_get_contents("https://maps.googleapis.com/maps/api/distancematrix/json?origins=$from&destinations=$to&language=ru-RU&sensor=false&key=AIzaSyBI02B0s9rWsna1yEASNeqrIZ2c8tI81JA");
//var_dump($data);
                        $data = json_decode($data);

//print ("Вывод информации с гугл карт, стоимость доставки: 25 р/км");
                        echo "Откуда: ".$data->destination_addresses[0] . "<br/>" .
                            "Куда: ". $data->origin_addresses[0] . "<br/>" .
                            "Время: ". $data->rows[0]->elements[0]->distance->text . "<br/>" .
                            "Путь: ".$data->rows[0]->elements[0]->duration->text;

                        //  "Стоимость: ".$data->rows[0]->elements[0]->duration->number*25;
                        $price=(int)$data->rows[0]->elements[0]->duration->text;
                        print("<br> Стоимость доставки: ".$price*100 .'р'."+".$var."р. сумма покупки");
                    }/**/
                    ?>

                </div>


            </div>

        </div>


    </div>
    </div>
<?php
include('footer.php');
?>
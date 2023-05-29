<?php
//  вся процедура работает на сессиях. Именно в ней хранятся данные  пользователя, пока он находится на сайте. Очень важно запустить их в  самом начале странички!!!
session_start();
?>
<?php

//ini_set('error_reporting', E_ALL);
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);

$host = 'localhost';
$username  = 'magazin2';
$password = 'magazin2';

$con = mysqli_connect($host, $username, $password, "magazin");

if (!empty($_SESSION['login']) or !empty($_SESSION['id']) ) {

    $id = $_SESSION['id'];
    $num = 0;
    $query = mysqli_query($con, "select DISTINCT id, category, name, price, price_old, img from products, list where $id=id_cart and id=id_prod ");
    while ($row = mysqli_fetch_array($query))
    {
        $products_array[] = $row;
        $products_array3[] = $row;
    }

    $query2 = mysqli_query($con, "select DISTINCT id, category, name, price, price_old, img from products, list where $id=id_cart and id=id_prod");
    while ($row2 = mysqli_fetch_array($query2))
    {
        $products_array2[] = $row2;
    }

    //запрос на сумму покупки
    $sql = mysqli_query($con, "SELECT sum(price) as \"sum\" from products, list where $id=id_cart and id=id_prod");
    $num2 = mysqli_fetch_assoc($sql);
    $summ= $num2['sum'];
    //rint($summ);
}
?>
<?php
include('header.php');
?>
    <div class="container">
        <div class="row">
            <div class="tab-content">
                <div class="tab-pane fade in active" id="tab1">
                    <?php foreach ($products_array as $product): ?>
                    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                        <div class="product">
                            <a href="<?='product.php?id='.$product['id'] ?>"
                               class="product_img">
                                <!--    <span>-10%</span> -->
                                <img src="images/<?php echo $product['img']; ?>">
                            </a>
                            <a href="<?= 'product.php?id='.$product['id'] ?>"
                               class="product_title"><?php echo $product['name']; ?></a>
                            <div class="product_price">
                                <span class="price"><?php echo $product['price']; ?> руб</span>
                                <span class="price_old"><?php if ($product['price_old'] != '') {
                                        echo $product['price_old'] . ' руб';
                                    } ?></span>
                            </div>
                            <div class="product_btn">
                                <a href="del_cart.php?prod=<?php echo ($product['id'])?>"
                                   data-id="<?= $product['id']; ?>" class="mylist">Удалить</a></div>

                        </div>

                    </div>
                </div>
                <?php endforeach; ?>

            </div>
        </div>
    </div>
</div>
</div>
</div>
</div>
<font size="8px"> Общая сумма покупки составляет: <?php echo ($summ) ?></font>

  <p class="product_btn">
    <a href="buy_cart.php?prod=<?php echo ($summ)?>"
       class="cart"> Перейти к оформлению заказа >></a></p>

</p>
<?php
include('footer.php');
?>


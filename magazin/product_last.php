<?php
$id = $_GET['id'];

$host = 'localhost';
$username = 'magazin2';
$password = 'magazin2';

$con = mysqli_connect($host, $username, $password, "magazin");

$query = mysqli_query($con, "SELECT * FROM magazin.products where id = $id");
$products = mysqli_fetch_array($query);


$query = mysqli_query($con, "SELECT * FROM magazin.characteristics where id_prod = $id ");
while ($row = mysqli_fetch_array($query)) {
    $characteristics[] = $row;
}

$query = mysqli_query($con, "SELECT * FROM magazin.categories where id=" . $products['category']);
$categories = mysqli_fetch_array($query);
?>

<?php
include('header.php');
?>


    <div class="container">
        <div class="row">

            <div class="col-lg-12 contant_wrap">

                <div class="navigation">

                    <!--хлебные крошки-->

                    <ul>

                        <li><a href="../"><i class="glyphicon glyphicon-home"></i></a></li>

                        <li><a href="<?= 'catalog.php' ?>">Каталог</a></li>

                        <li>
                            <a href="<?= 'listproducts.php?id=' . $categories['id'] ?>"><?php echo $categories['name']; ?></a>
                        </li>

                        <li><span> <?php echo $products['name']; ?></span></li>

                    </ul>

                </div>

            </div>

        </div>


        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

            <div class="short_description">


                <img src="images/<?php echo $products['img']; ?>">

                <div>

                    <h2><?php echo $products['name']; ?></h2>

                    <p><?php echo $products['description']; ?></p>

                </div>

                <div class="product">

                    <div class="product_price">

                        <span class="price"><?php echo $products['price']; ?> руб</span>

                        <span class="price_old"><?php if ($products['price_old'] != '') echo $products['price_old'] . ' руб'; ?></span>

                    </div>

                    <div class="product_btn">

                        <a href="<?= 'cart/add?id=' . $products['id'] ?>" class="cart"
                           data-id="<?= $products['id']; ?>"><i

                                    class="glyphicon glyphicon-shopping-cart"></i></a>

                        <a href="<?= 'cart/add?id=' . $products['id'] ?>" class="mylist"
                           data-id="<?= $products['id']; ?>">Купить</a>

                    </div>

                </div>


            </div>


            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 header_list_prod">

                <div class="row">

                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">

                        <h1>Характеристики:</h1>

                    </div>

                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                        <?php foreach ($characteristics as $characteristic): ?>


                            <?php print('<b>' . $characteristic['name'] . ':</b> ' . $characteristic['text'] . '</br>');

                            ?>

                        <?php endforeach; ?>

                    </div>

                </div>


            </div>

        </div>
    </div>
<?php
include('footer.php');
?>
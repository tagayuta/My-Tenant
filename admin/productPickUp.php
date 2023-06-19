<?php
    $product_id = $_GET["id"];

    $dsn = "mysql:host=localhost;dbname=Tenant;charset=utf8";
    $user = "root";
    $pass = "";

    try {
        $db = new PDO($dsn,$user,$pass);
        $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

        $SQL = "SELECT * FROM product WHERE product_id = ?";
        $stmt = $db->prepare($SQL);
        $stmt->bindParam(1, $product_id);
        $stmt->execute();
        $list = $stmt->fetchAll();

        $SQL = "SELECT * FROM images WHERE product_id = ?";
        $stmt = $db->prepare($SQL);
        $stmt->bindParam(1, $product_id);
        $stmt->execute();
        $imgList = $stmt->fetchAll();
    } catch(PDOException $e) {
        echo "エラー内容：".$e->getMessage();
    } finally {
        $db = null;
    }
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/bxslider/4.2.12/jquery.bxslider.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/bxslider/4.2.12/jquery.bxslider.min.js"></script>
    <script>
        $(document).ready(function(){
            $('.slider').bxSlider({ slideWidth: 200});
        });
    </script>
    <title>物件詳細</title>
</head>
<body>
    <?php foreach($list as $product): ?>
        <div class="product-link">
            <a href="productPickUp.php?id=<?= $product["product_id"] ?>">
                <h2><?php echo $product["name"] ?></h2>
                <div class='slider'>
                    <?php foreach($imgList as $img) { ?>
                        <img src="/My-Tenant/admin/image/<?= $img["imgPass"]?>" alt="物件画像">
                    <?php } ?>
                </div>
                <p>賃料：<?php echo $product["price"] ?>円</p>
                <p>敷金：<?php echo $product["s_money"] ?>円</p>
                <p>礼金：<?php echo $product["r_money"] ?>円</p>
            </a>

            <form action="editProduct.php" method="post">
                <input type="hidden" name="product_id" value="<?= $product["product_id"] ?>">
                <input type="submit" value="編集">
            </form>

            <form action="deleteProduct.php" method="post">
                <input type="hidden" name="product_id" value="<?= $product["product_id"] ?>">
                <input type="submit" value="削除">
            </form>
        </div>
        <hr>
    <?php endforeach; ?>
</body>
</html>
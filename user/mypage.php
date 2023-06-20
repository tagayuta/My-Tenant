<?php
    session_start();

    $dns = 'mysql:host=localhost; dbname=Tenant; charset=utf8';
    $user = 'root';
    $pass = '';
    
    $userSource = $_SESSION["user"];

    try{
        $db = new PDO($dns, $user, $pass);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $SQL = "SELECT * FROM product INNER JOIN mark ON product.product_id = mark.product_id WHERE mark.user_id = ?";

        $stmt = $db->prepare($SQL);
        $stmt->bindParam(1, $userSource[0][0]);
        $stmt->execute();
        $list = $stmt->fetchAll();

    } catch(PDOException $e) {
        echo "アクセスできませんでした";
        echo $e->getMessage();
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
        $('.slider').bxSlider({ slideWidth: 1000});
    });
    </script>
    <title>マイページ</title>
</head>
<body>
    <header class="header">
        <h1>My Tenant</h1>
    </header>
    <h1>あなたのお気に入り</h1>
    <?php foreach($list as $product): ?>
        <div class="cart-container">
            <div class="slider">
                <?php
                try{
                    $db = new PDO($dns, $user, $pass);
                    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
                    $SQL = "SELECT * FROM images INNER JOIN product ON product.product_id = images.product_id WHERE images.product_id = ?";
            
                    $stmt = $db->prepare($SQL);
                    $stmt->bindParam(1, $product["product_id"]);
                    $stmt->execute();
                    $imgList = $stmt->fetchAll();
            
                } catch(PDOException $e) {
                    echo "アクセスできませんでした";
                    echo $e->getMessage();
                } finally {
                    $db = null;
                }

                foreach($imgList as $img) {
                ?>
                <img src="/My-Tenant/admin/image/<?= $img["imgPass"] ?>">
                <?php } ?>
            </div>
                
            <div class="product-list">
                <p>物件名：<?php echo $product["name"] ?></p>
                <p>築年数：<?php echo $product["year"] ?></p>
                <p>賃料：<?php echo $product["price"] ?></p>
                <p>敷金：<?php echo $product["s_money"] ?></p>
                <p>礼金：<?php echo $product["r_money"] ?></p>
            </div>
        </div>
    <?php endforeach; ?>
</body>
</html>
<?php
    session_start();

    $dns = 'mysql:host=localhost; dbname=at_town; charset=utf8';
    $user = 'root';
    $pass = '';
    
    $user_id = $_SESSION["id"];

    try{
        $db = new PDO($dns, $user, $pass);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $SQL = "SELECT * FROM product INNER JOIN buy_log ON product.id = buy_log.product_id WHERE buy_log.user_id = ?";

        $stmt = $db->prepare($SQL);
        $stmt->bindParam(1, $user_id);
        $stmt->execute();
        $list = $stmt->fetchAll();

    } catch(PDOException $e) {
        echo "アクセスできませんでした";
        echo $e->getMessage();
    }
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/attown/user/style.css">
    <title>マイページ</title>
</head>
<body>
    <header class="header">
        <h1>ATTOWN</h1>
    </header>
    <h1>あなたの購入履歴</h1>
    <?php foreach($list as $product): ?>
        <div class="cart-container">
            <div class="product-img">
                <img src="/attown/admin/<?= $product["img0"] ?>" width='1000' height='500'>
            </div>
                
            <div class="product-list">
                <p>商品名：<?php echo $product["name"] ?></p>
                <p>価格：<?php echo $product["price"] ?></p>
                <p>サイズ：<?php echo $product["size"] ?></p>
                <p>購入数：<?php echo $product["count"] ?></p>
                <p>購入日：<?php echo $product["date"] ?></p>
            </div>
        </div>
    <?php endforeach; ?>
</body>
</html>
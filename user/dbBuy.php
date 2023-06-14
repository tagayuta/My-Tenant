<?php
    session_start();
    $user_id = $_POST["user_id"];
    //カートの中身をsessionから取得
    $cart = $_SESSION["cart"];

    $dns = 'mysql:host=localhost; dbname=at_town; charset=utf8';
    $user = 'root';
    $pass = '';

    try {
        $db = new PDO($dns, $user, $pass);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $SQL = "SELECT name, address FROM user WHERE id = ?";
        $stmt = $db->prepare($SQL);

        $stmt->bindParam(1, $user_id);
        $stmt->execute();
        $user = $stmt->fetch();

        $total = 0;
        foreach($cart as $product) {
            $total += $product["price"] * $product["count"];
        }
        

        foreach($cart as $product) {
            $SQL = "SELECT * FROM product WHERE id = ?";
            $stmt = $db->prepare($SQL);
            $stmt->bindParam(1, $product["product_id"]);
            $stmt->execute();
            $count = $stmt->fetchAll();

            //現在庫と購入数を計算
            $result = $count[0]["stock"] - $product["count"];

            $SQL = "UPDATE product SET stock = ? WHERE id = ?";
            $stmt = $db->prepare($SQL);
            $stmt->bindParam(1, $result);
            $stmt->bindParam(2, $product["product_id"]);
            $stmt->execute();
        }
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
    <title>注文確定</title>
</head>
<body>
    <header class="header">
        <h1>ATTOWN</h1>
    </header>

    <div class="sorce">
        <h2>こちらで注文を承りました！</h2>
        <p>注文者情報</p>
        <p>名前：<?php echo $user["name"] ?></p>
        <p>発送先↓↓</p>
        <p>住所:<?php echo $user["address"] ?></p>
    </div>

    <?php foreach($cart as $product): ?>
        <div class="cart-container">
            <div class="product-img">
                <img src="/attown/admin/<?= $product["img"] ?>">
            </div>

            <div class="product-list">
                <p class="title"><?php echo $product["name"] ?></p>
                <p class="price"><?php echo $product["price"] ?></p>
                <p class="size"><?php echo $product["size"]."サイズ" ?></p>
                <p>個数：<?php echo $product["count"] ?></p>
            </div>
        </div>
    <?php endforeach; ?>
    <p class="totalPrice">合計金額:<?php echo $total ?></p>

    <form action="dbBuyHistory.php" method="post" class="pay">
        <input type="submit" value="購入を確定する" class="payBtn">
    </form>
</body>
</html>
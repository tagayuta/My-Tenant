<?php
    session_start();
    $user_id = $_SESSION["id"];
    $total = 0;
    $dns = 'mysql:host=localhost; dbname=at_town; charset=utf8';
    $user = 'root';
    $pass = '';

    try{
        $db = new PDO($dns, $user, $pass);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $SQL = "SELECT id, name, price, count, img, size, user_id, product_id FROM cart WHERE user_id = ?";

        $stmt = $db->prepare($SQL);
        $stmt->bindParam(1, $user_id);
        $stmt->execute();
        $list = $stmt->fetchAll();
        $_SESSION["cart"] = $list;
    } catch(PDOException $e) {
        echo "アクセスできませんでした";
        echo $e->getMessage();
    }

    foreach($list as $product) {
        //カート内商品の合計金額を算出
        $total += $product["price"] * $product["count"];
    }
?>


<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/attown/user/style.css">
    <title>カート</title>
</head>
<body>
    <?php if(empty($list)) { ?>
        <header>
            <h1 class="header">ATTOWN</h1>
        </header>
        <p class="noCart">カートに商品がありません</p>
        <p class="noCart shopping"><a href="dbProductAll.php">買い物をする</a></p>
    <?php } else { ?>
        <header>
            <h1 class="header">ATTOWN</h1>
        </header>

        <div class="nav">
            <a href="dbInsertCart.php"><img src="/attown/admin/image/cart.jpeg" alt="カート" id="user"></a>
            <a href="mypage.php"><img src="/attown/admin/image/user.svg" alt="アカウント画像" id="user"></a>
            <a href ='../login/logout.php'>ログアウト</a>
        </div>

        <h1 class="cartTitle">商品カート</h1>

        <?php foreach($list as $product):?>
            <div class="cart-container">
                <div class="product-img">
                    <img src="/attown/admin/<?= $product["img"]?>" alt="商品画像">
                </div>

                <div class="product-list">
                    <p class="title"><?php echo $product["name"] ?></p>
                    <p class="price"><?php echo $product["price"] ?>円</p>
                    <p class="size"><?php echo $product["size"]."サイズ" ?></p>
                    <form action="dbCartUpdate.php" method="post">
                        <input type="number" name="count" value="<?= $product["count"]?>" pattern="^[0-9]+$" min="1">
                        <input type="hidden" name="user_id" value="<?= $product["user_id"]?>">
                        <input type="hidden" name="id" value="<?= $product["id"]?>">
                        <input type="submit" value="個数変更" class="btn">
                    </form>
                    <form action="dbCartDelete.php" method="post" class="delForm">
                        <input type="hidden" name="user_id" value="<?= $product["user_id"]?>">
                        <input type="hidden" name="id" value="<?= $product["id"]?>">
                        <input type="image" src="/attown/admin/image/dust.svg" value="削除" class="del">
                    </form>
                </div>
            </div>
        <?php endforeach; ?>

        <p class="totalPrice">合計金額:<?php echo $total ?></p>
        <form action="dbBuy.php" method="post" class="pay">
            <input type="hidden" name="user_id" value="<?= $user_id?>">
            <input type="submit" value="購入する" class="payBtn">
        </form>

    <footer class="footer">
        <h4>copyright: ATTOWN</h4>
    </footer>
    <?php } ?>
</body>
</html>
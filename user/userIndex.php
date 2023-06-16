<?php
    //検索結果や商品情報をsessionから取得
    session_start();
    $list = $_SESSION["list"];
    $user_id = $_SESSION["id"];
    $name = $_SESSION["name"];
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/attown/user/style.css">
    <title>ユーザーページ</title>
</head>
<body>
    <header>
        <h1 class="header">ATTOWN</h1>
    </header>

    <main>
        <div class="nav">
            <a href="dbInsertCart.php"><img src="/attown/admin/image/cart.jpeg" alt="カート" id="user"></a>
            <a href="mypage.php"><img src="/attown/admin/image/user.svg" alt="アカウント画像" id="user"></a>
            <a href ='../login/logout.php'>ログアウト</a>
        </div>

        <form action="dbSearch.php" method="post" class="seach">
            <input type="text" name="text" required="required" class="seachBox" placeholder="キーワード検索">
            <input type="submit" value="検索" class="seachBtn">
        </form>

        <div class="sortBox">
            <a href="dbProductAll.php">全商品表示</a>
            <a href="priceSort.php?mode=a">価格が高い順</a>
            <a href="priceSort.php">価格が安い順</a>
        </div>
        
        <form action="dbPriceRange.php" method="post" class="priceSort">
            <input type="number" name="low" placeholder="最小価格" pattern="^[0-9]+$" min="300">
            <input type="number" name="high" placeholder="最高価格" pattern="^[0-9]+$" min="301">
            <input type="submit" value="価格で絞り込み">
        </form>
    

        <div class="product-container">
            <?php foreach($list as $product): ?>
                <?php if($product["stock"] > 0) { ?>
                        <div class="product-link">
                            <a href="productPickUp.php/?id=<?= $product["id"] ?>" class="link">
                                <img src="../admin/<?= $product["img0"]?>" alt="商品画像">
                                <p class="title"><?php echo $product["name"] ?></p>
                                <p class="price"><?php echo $product["price"] ?>円</p>
                            </a>
                            <form action="dbInsertCart.php" method="post" class="form">
                                <div>
                                    <label for="">個数</label>
                                    <input type="number" name="count" value="1" pattern="^[0-9]+$" min="1" class="count">
                                </div>
                                <input type="hidden" name="product_id" value="<?= $product["id"] ?>">                
                                <input type="hidden" name="name" value="<?= $product["name"] ?>">
                                <input type="hidden" name="price" value="<?= $product["price"] ?>">
                                <input type="hidden" name="user_id" value="<?= $user_id ?>">
                                <input type="hidden" name="img" value="<?= $product["img0"] ?>">
                                <input type="hidden" name="size" value="<?= $product["size"] ?>">
                                <div>
                                    <input type="image" src="/attown/admin/image/cart.jpeg" value="カートに追加" width="30" height="30">
                                </div>
                            </form>
                        </div>
                <?php } ?>
            <?php endforeach; ?>
        </div>
    </main>

    
    <footer class="footer">
        <h4>copyright: ATTOWN</h4>
    </footer>
</body>
</html>
<?php
    session_start();
    $list = $_SESSION["list"];
    $imgList = $_SESSION["imgList"];
    $userSource = $_SESSION["user"];
    $user_id = $userSource[0][0];

    $dsn = 'mysql:host=localhost; dbname=Tenant; charset=utf8';
    $user = 'root';
    $pass = '';

    try{
        $db = new PDO($dsn, $user, $pass);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $SQL = "SELECT * FROM mark WHERE user_id = ?";
        $stmt = $db->prepare($SQL);
        $stmt->bindParam(1, $user_id);
        $stmt->execute();
        $markList = $stmt->fetchAll();
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
    <link rel="stylesheet" href="/attown/user/style.css">
    <title>ユーザーページ</title>
</head>
<body>
    <header>
        <h1 class="header">My Tenant</h1>
    </header>

    <main>
        <div class="nav">
            <a href="mypage.php"><img src="/My Tenant/admin/image/user.svg" alt="アカウント画像"></a>
            <a href ='../login/logout.php'>ログアウト</a>
        </div>

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
                <div class="product-link">
                    <a href="productPickUp.php/?id=<?= $product["product_id"] ?>">
                        <?php 
                            try {
                                $db = new PDO($dsn,$user,$pass);
                                $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
                                $SQL = "SELECT * FROM images WHERE product_id = ?";
                                $stmt = $db->prepare($SQL);
                                $stmt->bindParam(1, $product["product_id"]);
                                $stmt->execute();
                                $imageList = $stmt->fetchAll();
                            } catch(PDOException $e) {
                                echo "エラー内容：".$e->getMessage();
                            } finally {
                                $db = null;
                            }
                            foreach($imageList as $img) {
                        ?>
                            <img src="/My Tenant/admin/image/<?= $img["imgPass"]?>" alt="商品画像">
                        <?php } ?>
                        <p>物件名：<?php echo $product["name"] ?></p>
                        <p>賃料：<?php echo $product["price"] ?>円</p>
                        <p>敷金：<?php echo $product["price"] ?>円</p>
                        <p>礼金：<?php echo $product["price"] ?>円</p>
                    </a>

                    <form action="markManeger.php" method="post" class="form">
                        <input type="hidden" name="product_id" value="<?= $product["product_id"] ?>">                
                        <input type="hidden" name="user_id" value="<?= $userSource[0][0] ?>">
                        <?php if(!empty($markList)) { ?>
                            <?php foreach($markList as $mark) {
                                if($mark["product_id"] == $product["product_id"]) {
                            ?>
                                <input type="image" src="/My Tenant/admin/image/rightStar.svg" value="お気に入りに追加" width="30" height="30">
                                <input type="hidden" name="mode" value="r">
                            <?php } else { ?>
                                <input type="image" src="/My Tenant/admin/image/darkStar.svg" value="お気に入りに追加" width="30" height="30">
                                <input type="hidden" name="mode" value="a">
                            <?php }
                            } ?>
                        <?php } else {?>
                            <input type="image" src="/My Tenant/admin/image/darkStar.svg" value="カートに追加" width="30" height="30">
                            <input type="hidden" name="mode" value="a">
                        <?php } ?>
                    </form>
                </div>
            <?php endforeach; ?>
        </div>
    </main>

    <footer class="footer">
        <h4>copyright: My Tenant</h4>
    </footer>
</body>
</html>
<?php
    $dsn = "mysql:host=localhost;dbname=Tenant;charset=utf8";
    $user = "root";
    $pass = "";
    
    try{
        $db = new PDO($dsn,$user,$pass);
        $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

        if(!isset($_POST["search"])) {
            //検索ボタンが押されなかった時
            $SQL = "SELECT * FROM product ORDER BY product_id DESC";
            $stmt = $db->prepare($SQL);
            $stmt->execute();
            $list = $stmt->fetchAll();

        } else if($_POST["search"] == "keyword") {
            $list = keyword($db);
        } else if($_POST["search"] == "price") {
            $list = price($db);
        } else if($_POST["search"] == "category") {
            $list = category($db);
        }
    } catch(PDOException $e) {
        echo "エラー内容：".$e->getMessage();
    } finally {
        $db = null;
    }

    //キーワード検索
    function keyword($db){
        $text = $_POST["text"];
        $SQL = "SELECT * FROM product WHERE keyWord LIKE ? OR name LIKE ?";
        $stmt = $db->prepare($SQL);
        $text = '%' . $text . '%';
        $stmt->bindParam(1, $text);
        $stmt->bindParam(2, $text);
        $stmt->execute();
        $list = $stmt->fetchAll();
        return $list;
    }

    //価格検索
    function price($db){
        $low = $_POST["low"];
        $high= $_POST["high"];
        $SQL = "SELECT * FROM product WHERE price BETWEEN ? AND ?";
        $stmt = $db->prepare($SQL);
        $stmt->bindParam(1, $low);
        $stmt->bindParam(2, $high);
        $stmt->execute();

        $list = $stmt->fetchAll();
        return $list;
    }

    //カテゴリー検索
    function category($dbh){
        
    }
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>管理者ページ</title>
</head>
<body>
    <h2>管理者ページ</h2>
    <!-- キーワード -->
    <form action="adminIndex.php" method="post">
        <input type="text" name="text" required="required" placeholder="キーワード検索">
        <input type="hidden" name="search" value="keyword">
        <input type="submit" value="検索">
    </form>

    <!-- 価格検索 -->
    <form action="adminIndex.php" method="post">
        <input type="number" name="low" placeholder="最小価格" pattern="^[0-9]+$" min="300">
        <input type="number" name="high" placeholder="最高価格" pattern="^[0-9]+$" min="301">
        <input type="hidden" name="search" value="price">
        <input type="submit" value="価格で絞り込み">
    </form>

    <a href="insertProduct.html"><button>物件追加</button></a>
    <a href="userBL.php"><button>ユーザー設定</button></a>

    <?php if(!(empty($list) || $list == null)) {?>
        <?php foreach($list as $product): ?>
            <div class="product-link">
                <a href="productPickUp.php?id=<?= $product["product_id"] ?>">
                    <h2><?php echo $product["name"] ?></h2>
                    <div>
                        <?php 
                            try {
                                $db = new PDO($dsn,$user,$pass);
                                $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
                                $SQL = "SELECT * FROM images WHERE product_id = ?";
                                $stmt = $db->prepare($SQL);
                                $stmt->bindParam(1, $product["product_id"]);
                                $stmt->execute();
                                $imgList = $stmt->fetchAll();
                            } catch(PDOException $e) {
                                echo "エラー内容：".$e->getMessage();
                            } finally {
                                $db = null;
                            }
                            foreach($imgList as $img) {
                        ?>
                            <img src="/My-Tenant/admin/image/<?= $img["imgPass"]?>" alt="物件画像">
                        <?php } ?>
                    </div>
                    <p>賃料：<?php echo $product["price"] ?>円</p>
                    <p>敷金：<?php echo $product["s_money"] ?>円</p>
                    <p>礼金：<?php echo $product["r_money"] ?>円</p>
                    
                </a>

                <p>築年数：<?php echo $product["year"]?>年</p>

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
    <?php } else{ ?>
        <p>検索条件に一致する商品はありませんでした</p>
    <?php } ?>
</body>
</html>
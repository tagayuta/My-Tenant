

<?php 
    session_start(); 

    $dns = 'mysql:host=localhost; dbname=Tenant; charset=utf8';
    $user = 'root';
    $pass = '';

    try{
        $db = new PDO($dns, $user, $pass);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


        if(!isset($_POST["search"])){//検索ボタンが押されなかった時
            $SQL = "SELECT * FROM product p INNER JOIN images i ON p.product_id = i.product_id";
            $stmt = $db->prepare($SQL);
            $stmt->execute();
            $list = $stmt->fetchAll();

            $_SESSION["list"] = $list;
            var_dump($list);

        }else if($_POST["search"] == "keyword"){
            $list = keyword($db);
        }
        else if($_POST["search"] == "price"){
            $list = price($db);
        }
        else if($_POST["search"] == "category"){
            $list = category($db);
        }
    } catch(PDOException $e) {
        echo "アクセスできませんでした";
        echo $e->getMessage();
    }

    //キーワード検索
    function keyword($db){
        $text = $_POST["text"];
        $SQL = "SELECT SELECT * FROM product p INNER JOIN images i ON p.product_id = i.product_id WHERE keyWord LIKE ? OR name LIKE ?";
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
        $SQL = "SELECT * FROM product p INNER JOIN images i ON p.product_id = i.product_id WHERE price BETWEEN ? AND ?";
        $stmt = $db->prepare($SQL);
        $stmt->bindParam(1, $low);
        $stmt->bindParam(2, $high);
        $stmt->execute();

        $list = $stmt->fetchAll();
        return $list;
    }

    //カテゴリー検索
    function category($dbh){
        $gender = $_POST["gender"];
        $category = $_POST["category"]; 

        $SQL = "SELECT * FROM product p INNER JOIN images i ON p.product_id = i.product_id WHERE gender = ? AND category = ?";
        $stmt = $dbh->prepare($SQL);

        $stmt->bindParam(1, $gender);
        $stmt->bindParam(2, $category);
        $stmt->execute();

        $list = $stmt->fetchAll();
        return $list;
    }
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>My tenant</title>
    <link rel="stylesheet" href="index.css">
</head>
<body>
    <header>
        <h1>My Tenant</h1>
    </header>

    <div id="loginout">
        <a href = login/login.html>ログイン</a>
    </div>

    <!-- キーワード -->
    <form action="index.php" method="post">
        <input type="text" name="text" required="required" placeholder="キーワード検索">
        <input type="hidden" name="search" value="keyword">
        <input type="submit" value="検索">
    </form>

    <!-- 価格検索 -->
    <form action="index.php" method="post">
        <input type="number" name="low" placeholder="最小価格" pattern="^[0-9]+$" min="300">
        <input type="number" name="high" placeholder="最高価格" pattern="^[0-9]+$" min="301">
        <input type="hidden" name="search" value="price">
        <input type="submit" value="価格で絞り込み">
    </form>

    <!-- カテゴリー -->
    <form action="index.php" method="post" class="priceSort">
        
        <input type="hidden" name="search" value="category">
        <input type="submit" value="検索">
    </form>

    <div class="product-container">
        <?php if(!(empty($list) || $list == null)) {?>
            <?php foreach($list as $product): ?>
                <div class="product-link">
                    <a href="user/productPickUp.php?id=<?= $product["product_id"] ?>">
                        <h3><?php echo $product["name"] ?></h3>
                        <img src="/My Tenant/<?= $product["imgPass"]?>" alt="物件画像">
                        <p>賃料：<?php echo $product["price"] ?>円</p>
                        <p>敷金：<?php echo $product["s_money"] ?>円</p>
                        <p>礼金：<?php echo $product["r_money"] ?>円</p>
                    </a>
                </div>
                <hr>
            <?php endforeach; ?>
        <?php } else{ ?>
            <p>検索条件に合致する商品はありませんでした</p>
        <?php } ?>
    </div>

    <footer>
        <h4>copyright: My Tenant</h4>
    </footer>
</body>
</html>

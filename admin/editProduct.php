<?php 
    session_start();
    $product_id = $_POST["product_id"];

    $dsn = "mysql:host=localhost;dbname=Tenant;charset=utf8";
    $user = "root";
    $pass = "";
    try{
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
        $_SESSION["imgList"] = $imgList;
    } catch(PDOException $e) {
        echo "エラー内容：".$e->getMessage();
        die();
    } finally {
        $db = null;
    }
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/My-Tenant/admin/root.css">
    <title>物件編集</title>
</head>
<body>

    <header>
        <h1 class="header">My Tenant</h1>
    </header>

    <form action="exeEditProduct.php" method="post" enctype="multipart/form-data" class="editform">
        <?php foreach($list as $product): ?>
            <div class="imgs">
                <?php foreach($imgList as $img): ?>
                    <img src="/My-Tenant/admin/image/<?= $img["imgPass"] ?>" alt="物件画像" class="e-img">
                <?php endforeach; ?>
            </div>
            
            <div class="upload">
                <p>１枚目：<input type="file" name="image[]"></p>
                <p>２枚目：<input type="file" name="image[]"></p>
                <p>３枚目：<input type="file" name="image[]"></p>
                <p>４枚目：<input type="file" name="image[]"></p>
            </div>
            
            <div class="editInputs">
                <p>物件名</p>
                <input type="text" name="name" value="<?= $product["name"] ?>">
                <p>賃料</p>
                <input type="number" name="price" value="<?= $product["price"] ?>">
                <p>敷金</p>
                <input type="number" name="s_money" value="<?= $product["s_money"] ?>" pattern="^[0-9]+$" min="0">
                <p>礼金</p>
                <input type="number" name="r_money" value="<?= $product["r_money"] ?>" pattern="^[0-9]+$" min="0">
                <input type="hidden" name="product_id" value="<?= $product_id ?>"><br>
                <input type="submit" value="編集確定" class="submit">
            </div>
            
        <?php endforeach; ?>
    </form>
    
</body>
</html>
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
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>物件編集</title>
</head>
<body>
    <form action="exeEditProduct.php" method="post" enctype="multipart/form-data">
        <?php foreach($list as $product): ?>
            <?php foreach($imgList as $img): ?>
                <img src="/My Tenant/admin/image/<?= $img["imgPass"] ?>" alt="物件画像">
            <?php endforeach; ?>
            <p>１枚目：<input type="file" name="image[]" required></p>
            <p>２枚目：<input type="file" name="image[]"></p>
            <p>３枚目：<input type="file" name="image[]"></p>
            <p>４枚目：<input type="file" name="image[]"></p>
            <small>※何もアップロードされなければ投稿されている画像は削除されます。</small>
            <p>物件名</p>
            <input type="text" name="name" value="<?= $product["name"] ?>">
            <p>賃料</p>
            <input type="number" name="price" value="<?= $product["price"] ?>">
            <p>敷金</p>
            <input type="number" name="s_money" value="<?= $product["s_money"] ?>" pattern="^[0-9]+$" min="0">
            <p>礼金</p>
            <input type="number" name="r_money" value="<?= $product["r_money"] ?>" pattern="^[0-9]+$" min="0">
            <input type="hidden" name="product_id" value="<?= $product_id ?>"><br>
            <input type="submit" value="編集確定">
        <?php endforeach; ?>
    </form>

</body>
</html>

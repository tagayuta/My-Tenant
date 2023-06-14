<?php
    session_start();
    $user_id = $_SESSION["id"];

    $procut_id = $_GET["id"];

    $dns = 'mysql:host=localhost; dbname=Tenant; charset=utf8';
    $user = 'root';
    $pass = '';

    try{
        $db = new PDO($dns, $user, $pass);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $SQL = "SELECT * FROM product p INNER JOIN images i ON p.product_id = i.product_id WHERE product_id = ?";

        $stmt = $db->prepare($SQL);
        $stmt->bindParam(1, $product_id);
        $stmt->execute();
        $list = $stmt->fetchAll();
        foreach($list as $row) {
            $product_id = $row["product_id"];
            $name = $row["name"];
            $price = $row["price"];
            $size = $row["size"];
            $image = $row["imgPass"];
        }
    } catch(PDOException $e) {
        echo "アクセスできませんでした";
        echo $e->getMessage();
    } finally {
        $db = null;
    }

//画像のスライダー機能を追加しました、by橋本
    
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>物件詳細</title>
    <link rel="stylesheet" href="/attown/user/style.css">
    <!-- CSSファイルの読み込み開始 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/bxslider/4.2.12/jquery.bxslider.css">
    <!-- // CSSファイルの読み込み終了 -->


    <!-- JavaScriptファイルの読み込み開始 -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/bxslider/4.2.12/jquery.bxslider.min.js"></script>
    <!-- // JavaScriptファイルの読み込み終了 -->


    <!-- JavaScriptの記述開始 -->
    <script>
    $(document).ready(function(){
        $('.slider').bxSlider({ slideWidth: 1000});
    });
    </script>
</head>
<body>
<header>
    <h1 class="header">My Tenant</h1>
    </header>

    <h1><?php echo $name ?></h1>
    <div class='slider'> 
        <?php 
            //修正の可能性あり
            for($i = 0; $i < 4; $i++) { 
                if($row[imgPass] == NULL){ 
                break;
            }
        ?>
            <div>
                <img src='/My Tenant/admin/<?= $row["imgPass"] ?>'>
            </div>
        <?php } ?>
    </div>

    <div>
        <p><?= $name ?></p>
        <p><?= $price ?>円</p>
    </div>

    <form action = '/attown/user/dbInsertCart.php' method='post'>
        <input type = 'hidden' name = 'name' value='<?= $name ?>'>
        <input type = 'hidden' name = 'price' value='<?= $price ?>'>
        <input type = 'hidden' name = 'size' value='<?= $size ?>'>
        <input type = 'hidden' name = 'count' value='1'>
        <?php if(!empty($_SESSION["id"])) { ?>
            <input type = 'hidden' name = 'user_id' value='<?= $user_id ?>'> 
        <?php } ?>
        <input type = 'hidden' name = 'img' value='<?= $image ?>'>
        <input type = 'hidden' name = 'product_id' value='<?= $id2 ?>'>
        <input type = 'submit' value='カートに入れる'>
    </form>
</body>
</html>
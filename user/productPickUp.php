<?php
    session_start();
    $user = $_SESSION["user"];

    $product_id = $_GET["id"];

    $dns = 'mysql:host=localhost; dbname=Tenant; charset=utf8';
    $user = 'root';
    $pass = '';

    try{
        $db = new PDO($dns, $user, $pass);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $SQL = "SELECT * FROM product INNER JOIN images ON product.product_id = images.product_id WHERE product.product_id = ?";

        $stmt = $db->prepare($SQL);
        $stmt->bindParam(1, $product_id);
        $stmt->execute();
        $list = $stmt->fetchAll();
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
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>物件詳細</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/bxslider/4.2.12/jquery.bxslider.css">
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/bxslider/4.2.12/jquery.bxslider.min.js"></script>
    
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

    <h1><?php echo $list[0][1] ?></h1>
    
    <div class='slider'> 
        <?php foreach($list as $product): ?>
        <img src='/My-Tenant/admin/image/<?= $product["imgPass"] ?>'>
        <?php endforeach; ?>
    </div>

    <div>
        <p><?php echo $list[0][2] ?></p>
        <p><?php echo $list[0][4] ?></p>
        <p><?php echo $list[0][5] ?></p>
        <p><?php echo $list[0][6] ?></p>
        <p><?php echo $list[0][7] ?></p>
        <p><?php echo $list[0][8] ?></p>
    </div>
    
</body>
</html>
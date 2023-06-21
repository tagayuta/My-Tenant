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
    <title>物件詳細</title>
    <link rel="stylesheet" href="/My-Tenant/user/user.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/bxslider/4.2.12/jquery.bxslider.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/bxslider/4.2.12/jquery.bxslider.min.js"></script>

    <script>
    $(document).ready(function(){
        $('.slider').bxSlider({ slideWidth: 200});
    });
    </script>
</head>
<body>
    <header>
        <h1 class="header">My Tenant</h1>
    </header>

    <div class="icon">
        <a href="mypage.php"><img src="/My-Tenant/icon/user.svg" alt="アカウント画像" width="30" height="30"></a>
        <a href ='../login/logout.php' class="a-text">ログアウト</a>
    </div>

    <h1 class="title">物件詳細</h1>

    <div class="container">
        <h1 class="houseName"><?php echo $list[0][1] ?></h1>

        <div class="parent">
            <div class='slider'>
                <?php foreach($list as $product): ?>
                <img src="/My-Tenant/admin/image/<?= $product["imgPass"] ?>">
                <?php endforeach; ?>
            </div>

            <div class="houseSource">
                <table>
                    <tr>
                        <th>賃料</th>
                        <td><?php echo $list[0][2] ?>円</td>
                    </tr>
                    <tr>
                        <th>築年数</th>
                        <td><?php echo $list[0][8] ?>年</td>
                    </tr>
                    <tr>
                        <th>敷金</th>
                        <td><?php echo $list[0][4] ?>円</td>
                    </tr>

                    <tr>
                        <th>礼金</th>
                        <td><?php echo $list[0][5] ?>円</td>
                    </tr>
                    <tr>
                        <th>最寄り駅</th>
                        <td><?php echo $list[0][7] ?>駅</td>
                    </tr>
                </table>
            </div>
        </div>
        <h3 class="key">物件詳細キーワード</h3>
        <p class="list"><?php echo $list[0][3]?></p>
    </div>
</body>
</html>

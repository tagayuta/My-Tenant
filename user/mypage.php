<?php
    session_start();

    $dns = 'mysql:host=localhost; dbname=Tenant; charset=utf8';
    $user = 'root';
    $pass = '';

    $userSource = $_SESSION["user"];

    try{
        $db = new PDO($dns, $user, $pass);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $SQL = "SELECT * FROM product INNER JOIN mark ON product.product_id = mark.product_id WHERE mark.user_id = ?";

        $stmt = $db->prepare($SQL);
        $stmt->bindParam(1, $userSource[0][0]);
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/bxslider/4.2.12/jquery.bxslider.css">
    <link rel="stylesheet" href="/My-Tenant/user/user.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/bxslider/4.2.12/jquery.bxslider.min.js"></script>
    <script>
    $(document).ready(function(){
        $('.slider').bxSlider({ slideWidth: 200});
    });
    </script>
    <title>マイページ</title>
</head>
<body>
    <header class="header">
        <h1>My Tenant</h1>
    </header>

    <div class="icon">
        <a href ='../login/logout.php' class="a-text">ログアウト</a>
    </div>

    <h1 class="title">あなたのお気に入り</h1>
    <?php foreach($list as $product): ?>
        <div class="container">
            <h1 class="houseName"><?php echo $product["name"] ?></h1>
            <div class="parent">
                <div class="slider">
                    <?php
                    try{
                        $db = new PDO($dns, $user, $pass);
                        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                        $SQL = "SELECT * FROM images INNER JOIN product ON product.product_id = images.product_id WHERE images.product_id = ?";

                        $stmt = $db->prepare($SQL);
                        $stmt->bindParam(1, $product["product_id"]);
                        $stmt->execute();
                        $imgList = $stmt->fetchAll();

                    } catch(PDOException $e) {
                        echo "アクセスできませんでした";
                        echo $e->getMessage();
                    } finally {
                        $db = null;
                    }

                    foreach($imgList as $img) {
                    ?>
                    <img src="/My-Tenant/admin/image/<?= $img["imgPass"] ?>">
                    <?php } ?>
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
        </div>
    <?php endforeach; ?>
</body>
</html>

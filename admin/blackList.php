<?php
    $dsn = "mysql:host=localhost;dbname=Tenant;charset=utf8";
    $user = "root";
    $pass = "";
    
    try{
        $db = new PDO($dsn,$user,$pass);
        $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

        $SQL = "SELECT * FROM user WHERE BL = false";
        $stmt = $db->prepare($SQL);
        $stmt->execute();
        $BL = $stmt->fetchAll();
    } catch(PDOException $e) {
        echo "エラー内容：".$e->getMessage();
    } finally {
        $db = null;
    }
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/My-Tenant/admin/root.css">
    <title>ブラックリスト</title>
</head>
<body>

    <header>
        <h1 class="header">My Tenant</h1>
    </header>
    <?php if(!(empty($BL) || $BL == null)) {?>
        <?php foreach($BL as $list): ?>
            <div class="blTable">
                <table>
                    <tr>
                        <th>id</th>
                        <td><?php echo $list["user_id"] ?></td>
                    </tr>
                    <tr>
                        <th>名前</th>
                        <td><?php echo $list["name"] ?></td>
                    </tr>
                    <tr>
                        <th>メールアドレス</th>
                        <td><?php echo $list["mail"] ?></td>
                    </tr>
                    <tr>
                        <th>電話番号</th>
                        <td><?php echo $list["tel"] ?></td>
                    </tr>
                </table>
            </div>
            
            <form action="unLockBL.php" method="post">
                <input type="hidden" name="user_id" value="<?= $list["user_id"] ?>">
                <input type="submit" value="BL解除" class="submit">
            </form>
        <?php endforeach; ?>
    <?php } else {?>
        <h2 class="noBL">ブラックリストに登録されているユーザはいません。</h2>
        <div class="top"><a href="ProductAll.php" >→管理者トップページ</a></div>
    <?php } ?>
</body>
</html>
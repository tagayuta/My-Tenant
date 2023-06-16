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
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ブラックリスト</title>
</head>
<body>
    <?php if(!(empty($BL) || $BL == null)) {?>
        <?php foreach($BL as $list): ?>
            <p>id：<?php echo $list["user_id"] ?></p>
            <p>名前：<?php echo $list["name"] ?></p>
            <p>メールアドレス：<?php echo $list["mail"] ?></p>
            <p>電話番号：<?php echo $list["tel"] ?></p>
            <form action="unLockBL.php" method="post">
                <input type="hidden" name="user_id" value="<?= $list["user_id"] ?>">
                <input type="submit" value="BL解除">
            </form>
        <?php endforeach; ?>
    <?php } else {?>
        <p>ブラックリストに登録されているユーザはいません。</p>
        <a href="adminIndex.php">→管理者トップページ</a>
    <?php } ?>
</body>
</html>
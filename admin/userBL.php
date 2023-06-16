<?php
    session_start();
    if(!empty($_SESSION["userList"])) {
        $userList = $_SESSION["userList"];
    }
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ユーザー設定</title>
</head>
<body>
    <a href="blackList.php">ブラックリスト一覧</a>
    <form action="searchUser.php" method="post">
        <input type="number" name="user_id" pattern="^[0-9]+$" min="0" required="required" placeholder="id検索">
        <input type="submit" value="検索">
    </form>
    <p>or</p>
    <form action="searchUser.php" method="post">
        <input type="text" name="mail" required="required" placeholder="メールアドレス検索">
        <input type="submit" value="検索">
    </form>

    <?php if(!empty($userList)) { ?>
        <?php foreach($userList as $user): ?>
            <?php if($user["BL"] == true) { ?>
                <p>id：<?php echo $user["user_id"] ?></p>
                <p>名前：<?php echo $user["name"] ?></p>
                <p>メールアドレス：<?php echo $user["mail"] ?></p>
                <p>電話番号：<?php echo $user["tel"] ?></p>
                <form action="exeUserBL.php" method="post">
                    <input type="hidden" name="user_id" value="<?= $user["user_id"] ?>">
                    <input type="submit" value="BL登録">
                </form>
            <?php } ?>
        <?php endforeach; ?>
    <?php } ?>
</body>
</html>
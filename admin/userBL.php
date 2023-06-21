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
    <link rel="stylesheet" href="/My-Tenant/admin/root.css">
    <title>ユーザー設定</title>
</head>
<body>

    <header>
        <h1 class="header">My Tenant</h1>
    </header>

    <div class="blList">
        <a href="blackList.php">ブラックリスト一覧</a>
    </div>
    
    <h2 class="ans">IDかメールアドレスで検索して下さい</h2>
    <div class="blsearch">
        <form action="searchUser.php" method="post">
            <input type="number" name="user_id" pattern="^[0-9]+$" min="0" required="required" placeholder="id検索">
            <input type="submit" value="検索" class="submit">
        </form>
        <p>or</p>
        <form action="searchUser.php" method="post">
            <input type="text" name="mail" required="required" placeholder="メールアドレス検索">
            <input type="submit" value="検索" class="submit">
        </form>
    </div>
    

    <?php if(!empty($userList)) { ?>
        <?php foreach($userList as $user): ?>
            <?php if($user["BL"] == true) { ?>
                <div class="userList">
                    <table>
                        <tr>
                            <th>id</th>
                            <td><?php echo $user["user_id"] ?></td>
                        </tr>
                        <tr>
                            <th>名前</th>
                            <td><?php echo $user["name"] ?></td>
                        </tr>
                        <tr>
                            <th>メールアドレス</th>
                            <td><?php echo $user["mail"] ?></td>
                        </tr>
                        <tr>
                            <th>電話番号</th>
                            <td><?php echo $user["tel"] ?></td>
                        </tr>
                    </table>
                    <form action="exeUserBL.php" method="post">
                        <input type="hidden" name="user_id" value="<?= $user["user_id"] ?>">
                        <input type="submit" value="BL登録" class="submit">
                    </form>
                </div>
            <?php } ?>
        <?php endforeach; ?>
    <?php } ?>
</body>
</html>
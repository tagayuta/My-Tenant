<!-- ログアウトボタンを押されたらここに飛んでくる -->
<?php
session_start();
$_SESSION=array();
session_destroy();

?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>logout</title>
    <link rel="stylesheet" href="/My-Tenant/login/login.css">
</head>
<body>
    <header>
        <h1 class="header">My-Tenant</h1>
    </header>
    <h2 class="title">ログアウトしました。</h2>
    <a href ="../index.php"><h3 class="top">トップページへ戻る</h3></a>
</body>
</html>

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
    <link rel="stylesheet" href="../index.css">
</head>
<body>
    <header>
        <h1>ATTOWN</h1>
    </header>
    <h2>ログアウトしました。</h2>
    <a href ="../index.php">トップページへ戻る</a>
</body>
</html>







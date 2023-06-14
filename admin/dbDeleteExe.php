<?php

//ここに商品のIDが入る。わかりづらい変数名でごめん。
$form_id2= $_POST["form_id2"];

$dsn = 'mysql:host=localhost;dbname=at_town;charset=utf8';
$user = 'root';
$pass = '';

try{
    $dbh = new PDO($dsn,$user,$pass);
    $dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    if($dbh == null){

    } else {
        $SQL = "DELETE FROM product where id = ".$form_id2."";
        $dbh->query($SQL);
        $html = <<< _HTML_
        <!DOCTYPE html>
        <html lang="ja">
            <head>
                <meta charset="UTF-8">
                <title>削除完了</title>
                <link rel="stylesheet" href="style1.css">
            </head>
            <body>
                <header>
                    <h1>削除完了</h1>
                    <div id = "button">
                        <a href = "adminIndex.php" class="btn bgskew"><span>トップページに戻る</span></a>
                    </div> 
                </header>
                <main>
                </main>
            </body>
        </html>
        _HTML_;
        echo $html;

    }
} catch(PDOException $e) {
    echo "エラー内容：".$e->getMessage();
    die();

}

<!-- 退会するボタンを押すとここにとんでくる -->
<?php

session_start();
$id = $_SESSION["id"];//sessionのidを$idに入れる。ログインしている人のidで指定できる

//データベースと接続
$dsn = 'mysql:host=localhost; dbname=at_town; charset=utf8';
$user = 'root';
$pass = "";
//passを変えました。by橋本

try{
        
    $dbh = new PDO($dsn,$user,$pass);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //データベースに接続できた状態
    $SQL = "DELETE FROM user WHERE id = ?";

    $stmt = $dbh->prepare($SQL);//SQL文書いてコマンドプロンプトで準備している状態
    $stmt -> bindParam(1, $id);
    $stmt->execute();//SQLの実行

    $_SESSION=array();
    session_destroy();



}catch(PDOException $e) 
{
    echo $e->getMessage();
    echo "アクセスできません";
}
$dbh = null;//絶対いる文
    


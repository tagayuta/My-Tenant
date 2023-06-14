<!-- gender == g1 M SQL = "select * from product where gender = ? and category = ?" -->

<?php
    session_start();

    $gender = $_POST["gender"];
    $category = $_POST["category"]; 

    //データベースと接続
    $dns = 'mysql:host=localhost; dbname=at_town; charset=utf8';
    $user = 'root';
    $pass = '';

    try{
        $dbh = new PDO($dns,$user,$pass);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        //データベースに接続できた状態
        $SQL = "SELECT * FROM product WHERE gender = ? AND category = ?";
        $stmt = $dbh -> prepare($SQL);//SQL文書いてコマンドプロンプトで準備している状態
        $stmt -> bindParam(1, $gender);
        $stmt -> bindParam(2, $category);
        $stmt -> execute();//コマンドプロンプトでいうエンター、実行してください

        $list = $stmt->fetchAll();
        $_SESSION["list"] = $list;

        header('Location: userIndex.php');
        exit();


    } catch(PDOException $e) {
        echo "アクセスできませんでした";
        echo $e->getMessage();
    }




<?php
    session_start();
    $dns = 'mysql:host=localhost; dbname=at_town; charset=utf8';
    $user = 'root';
    $pass = '';

    try{
        $db = new PDO($dns, $user, $pass);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $SQL = "SELECT id, name, price, stock, img0, size FROM product";

        $stmt = $db->prepare($SQL);
        $stmt->execute();
        $list = $stmt->fetchAll();

        $_SESSION["list"] = $list;

        header('Location: userIndex.php');
        exit();

    } catch(PDOException $e) {
        echo "アクセスできませんでした";
        echo $e->getMessage();
    }
    
?>
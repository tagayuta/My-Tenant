<?php
    session_start();
    $dns = 'mysql:host=localhost; dbname=Tenant; charset=utf8';
    $user = 'root';
    $pass = '';

    try{
        $db = new PDO($dns, $user, $pass);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $SQL = "SELECT product_id, name, price, s_money, r_money, nearStation, year FROM product";
        $stmt = $db->prepare($SQL);
        $stmt->execute();
        $list = $stmt->fetchAll();

        $SQL = "SELECT * FROM images";
        $stmt = $db->prepare($SQL);
        $stmt->execute();
        $imgList = $stmt->fetchAll();

        $_SESSION["list"] = $list;
        $_SESSION["imgList"] = $imgList;

        header('Location: userIndex.php');
        exit();

    } catch(PDOException $e) {
        echo "アクセスできませんでした";
        echo $e->getMessage();
    }
    
?>
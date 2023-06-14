<?php
    session_start();
    $dns = 'mysql:host=localhost; dbname=at_town; charset=utf8';
    $user = 'root';
    $pass = '';

    $low = $_POST["low"];
    $high = $_POST["high"];


    try{
        $db = new PDO($dns, $user, $pass);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $SQL = "SELECT id, name, price, stock, img0, size FROM product WHERE price BETWEEN ? AND ?";

        $stmt = $db->prepare($SQL);
        $stmt->bindParam(1, $low);
        $stmt->bindParam(2, $high);
        $stmt->execute();
        $list = $stmt->fetchAll();

        $_SESSION["list"] = $list;

        $db = null;

        header('Location: userIndex.php');
        exit();

    } catch(PDOException $e) {
        echo "アクセスできませんでした";
        echo $e->getMessage();
    }
    
?>
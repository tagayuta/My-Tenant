<?php

    $product_id= $_POST["product_id"];

    $dsn = 'mysql:host=localhost;dbname=Tenant;charset=utf8';
    $user = 'root';
    $pass = '';

    try{
        $db = new PDO($dsn,$user,$pass);
        $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        $SQL = "DELETE FROM product WHERE product_id = ?";
        $stmt = $db->prepare($SQL);
        $stmt->bindParam(1, $product_id);
        $stmt->execute();

        header("Location: adminIndex.php");
    } catch(PDOException $e) {
        echo "エラー内容：".$e->getMessage();
    } finally {
        $db = null;
    }

?>
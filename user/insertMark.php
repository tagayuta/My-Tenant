<?php
session_start();
    if(empty($_SESSION["name"]) && empty($_SESSION["password"]))
    {
        header('Location:../login/login.html');
    }else{
  
        $name = $_POST["name"];
        $price = $_POST["price"];
        $size = $_POST["size"];
        $count = $_POST["count"];
        $img = $_POST["img"];
        $user_id = $_POST["user_id"];
        $product_id = $_POST["product_id"];
        
        $dns = 'mysql:host=localhost; dbname=at_town; charset=utf8';
        $user = 'root';
        $pass = '';

        try{
            $db = new PDO($dns, $user, $pass);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $SQL = "INSERT INTO cart(name, price, size, count, img, user_id, product_id) VALUES(?,?,?,?,?,?,?)";

            $stmt = $db->prepare($SQL);
            $stmt->bindParam(1, $name);
            $stmt->bindParam(2, $price);
            $stmt->bindParam(3, $size);
            $stmt->bindParam(4, $count);
            $stmt->bindParam(5, $img);
            $stmt->bindParam(6, $user_id);
            $stmt->bindParam(7, $product_id);
            $stmt->execute();

            header('Location: dbCart.php');
            exit();

        } catch(PDOException $e) {
            echo "アクセスできませんでした";
            echo $e->getMessage();
        }
    }
?>
<?php

    $arr = $_FILES["image"]['name'];
    $name = $_POST["name"];
    $price = $_POST["price"];
    $address = $_POST["address"];
    $s_money = $_POST["s_money"];
    $r_money = $_POST["r_money"];
    $station = $_POST["station"];
    $year = $_POST["year"];
    $keyword = $_POST["keyword"];

    $now = intval(date('Y'));
    $year = $now - $year;
    
    $dsn = "mysql:host=localhost;dbname=Tenant;charset=utf8";
    $user = "root";
    $pass = "";
    
    try {
        $db = new PDO($dsn,$user,$pass);
        $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        $SQL = "INSERT INTO product(name, price, keyword, address, s_money, r_money, nearStation, year) VALUES(?,?,?,?,?,?,?,?)";
        $stmt = $db->prepare($SQL);
        $stmt->bindParam(1, $name);
        $stmt->bindParam(2, $price);
        $stmt->bindParam(3, $keyword);
        $stmt->bindParam(4, $address);
        $stmt->bindParam(5, $s_money);
        $stmt->bindParam(6, $r_money);
        $stmt->bindParam(7, $station);
        $stmt->bindParam(8, $year);
        $stmt->execute();

        $SQL = "SELECT product_id FROM product ORDER BY product_id DESC LIMIT 1";
        $stmt = $db->prepare($SQL);
        $stmt->execute();
        $p_id = $stmt->fetchAll();
        
        $product_id = $p_id[0]["product_id"];

        foreach($arr as $img) {
            if($img == "") {
                $SQL = "INSERT INTO images(product_id) VALUES(?)";
                $stmt = $db->prepare($SQL);
                $stmt->bindParam(1, $product_id);
            } else {
                $SQL = "INSERT INTO images(imgPass, product_id) VALUES(?,?)";
                $stmt = $db->prepare($SQL);
                $stmt->bindParam(1, $img);
                $stmt->bindParam(2, $product_id);
            }
            $stmt->execute();
        }

        header("Location: ProductAll.php");
    } catch(PDOException $e) {
        echo "エラー内容：".$e->getMessage();
        die();
    } finally {
        $db = null;
    }
        
?>


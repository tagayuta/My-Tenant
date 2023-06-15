<?php
    $arr = $_FILES["image"]['name'];
    $product_id = $_POST["product_id"];
    $name = $_POST["name"];
    $price = $_POST["price"];
    $s_money = $_POST["s_money"];
    $r_money = $_POST["r_money"];

    $dsn = "mysql:host=localhost;dbname=Tenant;charset=utf8";
    $user = "root";
    $pass = "";

    var_dump($arr);

    try{
        $db = new PDO($dsn,$user,$pass);
        $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        $SQL = "UPDATE product SET name = ?, price = ?, s_money = ?, r_money = ? WHERE product_id = ?";
        $stmt = $db->prepare($SQL);
        $stmt->bindParam(1, $name);
        $stmt->bindParam(2, $price);
        $stmt->bindParam(3, $s_money);
        $stmt->bindParam(4, $r_money);
        $stmt->bindParam(5, $product_id);
        $stmt->execute();

        $noImage = "noImage.jpg";
        foreach($arr as $img) {
            if($img == "") {
                $SQL = "UPDATE images SET imgPass = ? WHERE product_id = ?";
                $stmt = $db->prepare($SQL);
                $stmt->bindParam(1, $noImage);
                $stmt->bindParam(2, $product_id);
            } else {
                $SQL = "UPDATE images SET imgPass = ? WHERE img_id = ?";
                $stmt = $db->prepare($SQL);
                $stmt->bindParam(1, $img);
                $stmt->bindParam(2, $product_id);
            }

            $stmt->execute();
        }

        header("Location: adminIndex.php");
    } catch(PDOException $e) {
        echo "エラー内容：".$e->getMessage();
        die();
    } finally {
        $db = null;
    }
?>

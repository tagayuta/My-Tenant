<?php
    session_start();
    $list = $_SESSION["cart"];

    $dns = 'mysql:host=localhost; dbname=at_town; charset=utf8';
    $user = 'root';
    $pass = '';
    
    try{
        $db = new PDO($dns, $user, $pass);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        foreach($list as $buy) {
            $SQL = "INSERT INTO buy_log(product_id, user_id, price, count) VALUES(?,?,?,?)";

            $stmt = $db->prepare($SQL);
            $stmt->bindParam(1, $buy["product_id"]);
            $stmt->bindParam(2, $buy["user_id"]);
            $stmt->bindParam(3, $buy["price"]);
            $stmt->bindParam(4, $buy["count"]);
            $stmt->execute();
        }

        $deleteSQL = "DELETE FROM cart WHERE user_id = ?";
        $st = $db->prepare($deleteSQL);
        $st->bindParam(1, $list[0]["user_id"]);
        $st->execute();

        header('Location: thanks.html');
        exit();

    } catch(PDOException $e) {
        echo "アクセスできませんでした";
        echo $e->getMessage();
    }
?>
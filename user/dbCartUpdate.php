<?php
    $id = $_POST["id"];
    $user_id = $_POST["user_id"];
    $count = $_POST["count"];

    $dns = 'mysql:host=localhost; dbname=at_town; charset=utf8';
    $user = 'root';
    $pass = '';

    try{
        $db = new PDO($dns, $user, $pass);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $SQL = "UPDATE cart SET count = ? WHERE user_id = ? AND  id = ?";

        $stmt = $db->prepare($SQL);
        $stmt->bindParam(1, $count);
        $stmt->bindParam(2, $user_id);
        $stmt->bindParam(3, $id);
        $stmt->execute();

        header('Location: dbCart.php');
        exit();
    } catch(PDOException $e) {
        echo "アクセスできませんでした";
        echo $e->getMessage();
    }
?>
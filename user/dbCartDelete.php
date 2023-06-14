<?php
    $id = $_POST["id"];
    $user_id = $_POST["user_id"];

    $dns = 'mysql:host=localhost; dbname=at_town; charset=utf8';
    $user = 'root';
    $pass = '';

    try{
        $db = new PDO($dns, $user, $pass);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $SQL = "DELETE FROM cart WHERE id = ? AND user_id = ?";

        $stmt = $db->prepare($SQL);
        $stmt->bindParam(1, $id);
        $stmt->bindParam(2, $user_id);
        $stmt->execute();

        header('Location: dbCart.php');
        exit();

    } catch(PDOException $e) {
        echo "アクセスできませんでした";
        echo $e->getMessage();
    }
?>
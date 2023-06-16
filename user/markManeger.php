<?php
    $mode = $_POST["mode"];
    $product_id = $_POST["product_id"];
    $user_id = $_POST["user_id"];

    $dns = "mysql:host=localhost;dbname=Tenant;charset=utf8";
    $user = "root";
    $pass = "";

    try{
        $db = new PDO($dns, $user, $pass);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        if($mode == "r") {
            $SQL = "DELETE FROM mark WHERE product_id = ? AND user_id = ?";
            $stmt = $db->prepare($SQL);
            $stmt->bindParam(1, $product_id);
            $stmt->bindParam(2, $user_id);
            $stmt->execute();
        } else {
            $SQL = "INSERT INTO mark(product_id, user_id) VALUES(?, ?)";
            $stmt = $db->prepare($SQL);
            $stmt->bindParam(1, $product_id);
            $stmt->bindParam(2, $user_id);
            $stmt->execute();
        }

        header("Location: userIndex.php");
        exit();
    } catch(PDOException $e) {
        echo "アクセスできませんでした";
        echo $e->getMessage();
    } finally {
        $db = null;
    }

?>
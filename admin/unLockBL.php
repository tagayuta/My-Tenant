<?php
    $user_id = $_POST["user_id"];
    $dsn = "mysql:host=localhost;dbname=Tenant;charset=utf8";
    $user = "root";
    $pass = "";
    
    try{
        $db = new PDO($dsn,$user,$pass);
        $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

        $SQL = "UPDATE user SET BL = true WHERE user_id = ?";
        $stmt = $db->prepare($SQL);
        $stmt->bindParam(1, $user_id);
        $stmt->execute();

        header("Location: blackList.php");
    } catch(PDOException $e) {
        echo "エラー内容：".$e->getMessage();
    } finally {
        $db = null;
    }
?>
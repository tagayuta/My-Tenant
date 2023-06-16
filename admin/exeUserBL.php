<?php
    $user_id = $_POST["user_id"];

    $dsn = "mysql:host=localhost;dbname=Tenant;charset=utf8";
    $user = "root";
    $pass = "";

    try {
        $db = new PDO($dsn,$user,$pass);
        $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

        $SQL = "UPDATE user SET BL = false WHERE user_id = ?";
        $stmt = $db->prepare($SQL);
        $stmt->bindParam(1, $user_id);
        $stmt->execute();

        session_start();
        $_SESSION=array();
        session_destroy();
        
        header("Location: userBL.php");
        exit();
    } catch(PDOException $e) {
        echo "エラー内容：".$e->getMessage();
    } finally {
        $db = null;
    }
?>
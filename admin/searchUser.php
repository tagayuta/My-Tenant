<?php
    session_start();
    if(!empty($_POST["user_id"])) {
        $uesr_id = $_POST["user_id"];
    } else {
        $mail = $_POST["mail"];
    }

    $dsn = "mysql:host=localhost;dbname=Tenant;charset=utf8";
    $user = "root";
    $pass = "";

    try {
        $db = new PDO($dsn,$user,$pass);
        $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

        if(!empty($_POST["user_id"])) {
            $SQL = "SELECT * FROM user WHERE user_id = ?";
            $stmt = $db->prepare($SQL);
            $stmt->bindParam(1, $uesr_id);
            $stmt->execute();
        } else {
            $SQL = "SELECT * FROM user WHERE mail = ?";
            $stmt = $db->prepare($SQL);
            $stmt->bindParam(1, $mail);
            $stmt->execute();
        }

        $userList = $stmt->fetchAll();
        $_SESSION["userList"] = $userList;

        header("Location: userBL.php");
        exit();
    } catch(PDOException $e) {
        echo "エラー内容：".$e->getMessage();
    } finally {
        $db = null;
    }
?>
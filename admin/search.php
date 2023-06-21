<?php
    session_start();
    $dns = 'mysql:host=localhost; dbname=Tenant; charset=utf8';
    $user = 'root';
    $pass = '';

    $keyword = htmlentities($_POST["keyword"], ENT_QUOTES, "UTF-8");
    $keyword = str_replace("\r\n","",$keyword);

    try{
        $db = new PDO($dns, $user, $pass);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $SQL = "SELECT * FROM product WHERE keyword LIKE ? OR name LIKE ? OR address LIKE ? OR nearStation LIKE ?";

        $stmt = $db->prepare($SQL);
        $keyword = '%' . $keyword . '%';
        $stmt->bindParam(1, $keyword);
        $stmt->bindParam(2, $keyword);
        $stmt->bindParam(3, $keyword);
        $stmt->bindParam(4, $keyword);
        $stmt->execute();
        $list = $stmt->fetchAll();

        $_SESSION["list"] = $list;

        header('Location: adminIndex.php');
        exit();

    } catch(PDOException $e) {
        echo "アクセスできませんでした";
        echo $e->getMessage();
    }
    
?>
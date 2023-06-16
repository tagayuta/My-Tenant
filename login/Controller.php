<?php
    session_start();

    $mail = $_POST["mail"];
    $password = $_POST["password"];

    //送られてきたデータの特殊文字処理
    $mail = htmlentities($mail,ENT_QUOTES,"utf-8");
    $password = htmlentities($password,ENT_QUOTES,"utf-8");

    //パスワードのハッシュ化
    $password = hash("sha256", $password);

    $dsn = 'mysql:host=localhost; dbname=Tenant; charset=utf8';
    $user = 'root';
    $pass = "";

    try{
        $db = new PDO($dsn,$user,$pass);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $SQL = "SELECT * FROM user WHERE mail = ? and pass = ?";

        $stmt = $db->prepare($SQL);

        $stmt->bindParam(1,$mail);
        $stmt->bindParam(2,$password);

        $stmt->execute();
        $row = $stmt->fetchAll();
            
        if(!empty($row)) {
            $_SESSION["user"] = $row;
            if($row[0][5] == 0) {
                header("Location: freeze.html");
                exit();
            } else if($row[0][6] == 1){
                //admin=0　管理者
                header("Location:../admin/adminIndex.php");
                exit();
            }else if($row[0][6] == 0){
                //admin=1　ユーザー
                header("Location:../user/ProductAll.php");
                exit();
            }
        } else {
            echo "ログイン失敗";
            echo "<br>";
            echo '<input type="button" value="戻る" onClick="history.back()">';
        }

    } catch(PDOException $e) {
        echo $e->getMessage();
        echo "アクセスできません";
    } finally {
        $db = null;
    }
?>
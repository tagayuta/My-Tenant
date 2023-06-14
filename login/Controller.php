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
        $dbh = new PDO($dsn,$user,$pass);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $SQL = "SELECT * FROM user WHERE mail = ? and pass = ?";

        $stmt = $dbh->prepare($SQL);

        $stmt->bindParam(1,$mail);
        $stmt->bindParam(2,$password);

        $stmt->execute();
        $row = $stmt->fetch();


        if(!empty($row)) {
            //$rowの中身が空でない=ログイン成功
            $_SESSION["user"] = $row;
            if($row["admin"] == 0){
                //admin=0　管理者
                header("Location:../admin/adminIndex.php");
                exit();
            }else if($row["admin"] == 1){
                //admin=1　ユーザー
                header("Location:../user/dbProductAll.php");
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
        $dbh = null;
    }
?>
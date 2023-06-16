<?php
    session_start();
    $name = $_POST["name"];
    $password = $_POST["password"];
    $mail = $_POST["mail"];
    $tel = $_POST["tel"];

    $name = htmlentities($name,ENT_QUOTES,"UTF-8");
    $password = htmlentities($password,ENT_QUOTES,"UTF-8");
    $mail = htmlentities($mail,ENT_QUOTES,"UTF-8");
    $tel = htmlentities($tel,ENT_QUOTES,"UTF-8");

    $password = hash("sha256", $password);
    //改行処理
    $name = str_replace("\r\n","",$name);
    $password = str_replace("\r\n","",$password);
    $mail = str_replace("\r\n","",$mail);
    $tel = str_replace("\r\n","",$tel);

    if($_POST["mode"] == "post"){
        new_form();
    }
    else{
    error("エラーです");
    }


    function new_form(){
        global $name;
        global $mail;
        global $password;
        global $tel;

        $dsn = 'mysql:host=localhost; dbname=Tenant; charset=utf8';
        $user = 'root';
        $pass = "";

        try{
            $db = new PDO($dsn,$user,$pass);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $SQL = "INSERT INTO user (name, mail, pass, tel) VALUES (?, ?, ?, ?)";
            
            $stmt = $db->prepare($SQL);

            $stmt->bindParam(1, $name);
            $stmt->bindParam(2, $mail);
            $stmt->bindParam(3, $password);
            $stmt->bindParam(4, $tel);

            $stmt->execute();
            echo "<h1>登録完了しました</h1>";
            echo "<a href='login.html'>ログインする</a>";
        } catch(PDOException $e) {
            echo $e->getMessage();
            echo "アクセスできません";
        } finally {
            $db = null;
        }
    }

    function error($msg){
        echo $msg;
    }
?>
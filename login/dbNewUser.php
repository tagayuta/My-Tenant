<?php

session_start();
//受け取るデータ宣言
$name = $_POST["name"];
$password = $_POST["password"];
$mail = $_POST["mail"];
$tel = $_POST["tel"];
$address = $_POST["address"];
$gender = $_POST["gender"];
$size = $_POST["size"];


//無効化
$name = htmlentities($name,ENT_QUOTES,"UTF-8");
$password = htmlentities($password,ENT_QUOTES,"UTF-8");
$mail = htmlentities($mail,ENT_QUOTES,"UTF-8");
$tel = htmlentities($tel,ENT_QUOTES,"UTF-8");
$address = htmlentities($address,ENT_QUOTES,"UTF-8");
$gender = htmlentities($gender,ENT_QUOTES,"UTF-8");
$size = htmlentities($size,ENT_QUOTES,"UTF-8");

//送られてきたパスワードのハッシュ化、その状態でデータベースに入るように
$password = hash("sha256", $password);
//改行処理
$name = str_replace("\r\n","",$name);
$password = str_replace("\r\n","",$password);
$mail = str_replace("\r\n","",$mail);
$tel = str_replace("\r\n","",$tel);
$address = str_replace("\r\n","",$address);
$gender = str_replace("\r\n","",$gender);
$size = str_replace("\r\n","",$size);


// //入力チェック
// if($name == ""){
//     error("名前を入力してください");
// }
// if($password == ""){
//     error("パスワードを作成してください");
// }
// if($mail == ""){
//     error("メールアドレスを入力してくだい");
// }
// if($tel == ""){
//     error("電話番号を入力してください");
// }if($address == ""){
//     error("住所を入力してください");
// }
// if($gender == ""){
//     error("在庫数を入力してください");
// }
// if($size == ""){
//     error("在庫数を入力してください");
// }

//分岐チェック　なくてもいいかも、あってもいい
if($_POST["mode"] == "post"){
    new_form();
}
else{
   error("エラーです");
}

//データベースに飛ぶ
function new_form(){
    global $name;
    global $mail;
    global $password;
    global $tel;
    global $address;
    global $size;
    global $gender;

    //データベースと接続
    $dsn = 'mysql:host=localhost; dbname=at_town; charset=utf8';
    $user = 'root';
    $pass = "";

    try{
        
        $dbh = new PDO($dsn,$user,$pass);
        $dbh -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        //データベースに接続できた状態

        $SQL = "INSERT INTO user (name, mail, pass, tel, address, size, gender,admin) VALUES (?, ?, ?, ?, ?, ?, ?,1)";
        
        $stmt = $dbh -> prepare($SQL);//SQL文書いてコマンドプロンプトで準備している状態

        $stmt -> bindParam(1, $name);
        $stmt -> bindParam(2, $mail);
        $stmt -> bindParam(3, $password);
        $stmt -> bindParam(4, $tel);
        $stmt -> bindParam(5, $address);
        $stmt -> bindParam(6, $gender);
        $stmt -> bindParam(7, $size);
        //値が？はてなだから、そこに何が入るのかを明示する

        $stmt -> execute();//コマンドプロンプトでいうエンター、実行してください


        echo "<h1>登録完了しました</h1>";
        echo "<a href='login.html'>ログインする</a>";

    } catch(PDOException $e) {
        echo $e->getMessage();
        echo "アクセスできません";
    }
    $dbh = null;//絶対いる文
}

function error($msg){
    echo "エラーです";
}
?>
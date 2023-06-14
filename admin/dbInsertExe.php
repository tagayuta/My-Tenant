<?php

    $name = $_POST["name"];
    $price = $_POST["price"];
    $gender = $_POST["gender"];
    $stock = $_POST["stock"];
    $category = $_POST["category"]; 
    $size = $_POST["size"];
    $keyword = $_POST["keyword"];
    $ar = $_POST['image'];
    $admin_id = $_POST["admin_id"];

    $name = entity($name);
    $price = entity($price);
    $gender = entity($gender);
    $stock = entity($stock);
    $category = entity($category);
    $size = entity($size);
    $keyword = entity($keyword);

    $dsn = 'mysql:host=localhost;dbname=at_town;charset=utf8';
    $user = 'root';
    $pass = '';

    try{
        $dbh = new PDO($dsn,$user,$pass);
        $dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        if($dbh == null){

        } else {
            $im = "";
            $imp = "";
            for($i =0; $i < count($ar); $i++){
                $im .="img{$i},";
                $imp .="'image/"."$ar[$i]',";
            }

            $sql = "insert into product (name,gender,price,stock,category,size,keyWord,$im admin_id) values(:name, :gender, :price, :stock, :category, :size,:keyWord,$imp:admin_id)";

            $stmt = $dbh->prepare($sql);
            $stmt-> bindParam(':name',$name);
            $stmt-> bindParam(':gender',$gender);
            $stmt-> bindParam(':price',$price);
            $stmt-> bindParam(':stock',$stock);
            $stmt-> bindParam(':category',$category);
            $stmt-> bindParam(':size',$size);
            $stmt-> bindParam(':keyWord',$keyword);
            $stmt->bindParam(':admin_id',$admin_id);
            $stmt->execute();
            
            $html = <<< _HTML_

            <!DOCTYPE html>
            <html lang="ja">
            <head>
                <meta charset="UTF-8">
                <title>登録完了</title>
                <link rel="stylesheet" href="style1.css">
            </head>
            <body>
                <header>
                    <h1>登録完了</h1>
                    <div id = "button">
                        <a href = "adminIndex.php" class="btn bgskew"><span>トップページに戻る</span></a>
                    </div> 
                </header>
                <div class="balloon5-left">
                <p class="text">登録ありがとう。。。</p>
                </div>
            </body>
            </html>

            _HTML_;
            echo $html;

        }
    } catch(PDOException $e) {
        echo "エラー内容：".$e->getMessage();
        die();

    }
$dbh = null;

function entity($variable)
{
    $enc = mb_detect_encoding($variable);
    $variable = mb_convert_encoding($variable,"utf-8",$enc);
    return  $variable = htmlentities($variable,ENT_QUOTES,"utf-8");
}

<?php

    $product_id = $_POST["product_id"];
    $image = $_FILES["image"]['name'];
    $num = $_POST["num"];
    move_uploaded_file($_FILES["image"]['tmp_name'], 'image/'. $image);
    $image = "image/".$image;

function entity($variable){
    $enc = mb_detect_encoding($variable);
    $variable = mb_convert_encoding($variable,"utf-8",$enc);
    return  $variable = htmlentities($variable,ENT_QUOTES,"utf-8");
}

$image = entity($image);



connectDB($product_id,$image,$num);
function connectDB($product_id,$image,$img_num){


    $dsn = 'mysql:host=localhost;dbname=at_town;charset=utf8';
    $user = 'root';
    $pass = '';

    try{
        $dbh = new PDO($dsn,$user,$pass);
        $dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        if($dbh == null){

        } else {
            $sql ="UPDATE product SET img{$img_num} = :img WHERE id = '$product_id'";
            var_dump($sql);
            $stmt = $dbh->prepare($sql);
            $stmt-> bindParam(':img',$image);
            $stmt->execute();
            header("Location:adminIndex.php");
        }
    } catch(PDOException $e) {
        echo "エラー内容：".$e->getMessage();
        die();

    } 
    $dbh = null;
}
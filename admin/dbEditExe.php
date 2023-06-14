<?php
    $id = $_POST["id"];
    $name = $_POST["name"];
    $price = $_POST["price"];
    $gender = $_POST["gender"];
    $stock = $_POST["stock"];
    $category = $_POST["category"]; 
    $size = $_POST["size"];
    $keyword = $_POST["keyword"];
    $ar = $_POST["img"];
    
//いちいち、セキュリティ対策の関数を書くのが面倒くさかったため、関数化してまとめて、呼び出す形にしている。
function entity($variable)
{
    $enc = mb_detect_encoding($variable);
    $variable = mb_convert_encoding($variable,"utf-8",$enc);
    return  $variable = htmlentities($variable,ENT_QUOTES,"utf-8");
}

//ここで呼び出している。
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

        $stmt = $dbh->prepare("UPDATE product SET name = :nam , gender = :gender, price = :price, stock = :stock, category = :category, size = :size, keyWord = :keyWord  WHERE id = '$id'");
            $stmt-> bindParam(':nam',$name);
            $stmt-> bindParam(':gender',$gender);
            $stmt-> bindParam(':price',$price);
            $stmt-> bindParam(':stock',$stock);
            $stmt-> bindParam(':category',$category);
            $stmt-> bindParam(':size',$size);
            $stmt-> bindParam(':keyWord',$keyword);

            $stmt->execute();

            header("Location:adminIndex.php");
    }
} catch(PDOException $e) {
    echo "エラー内容：".$e->getMessage();
    die();

}
$dbh = null;
<?php 
    session_start();
    if(empty($_SESSION["name"]) && empty($_SESSION["password"])){
        header('Location:../login/login.html');
    } elseif ($_SESSION["admin"] == 1){
        header('Location:../user/userIndex.php');
    }
    
    $form_id= $_POST["form_id"];
    $dsn = 'mysql:host=localhost;dbname=at_town;charset=utf8';
    $user = 'root';
    $pass = '';
    try{
        $dbh = new PDO($dsn,$user,$pass);
        $dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        if($dbh == null){

        } else {
            $SQL = "SELECT * FROM product where id =".$form_id."";
            foreach ($dbh->query($SQL) as $row){
                $id = $row['id'];
                $name= $row['name'];
                $gender = $row['gender'];
                $price = $row['price'];
                $stock = $row['stock'];
                $category = $row['category'];
                $size = $row['size'];
                $keyword = $row['keyWord'];
            }
        }
    } catch(PDOException $e) {
        echo "エラー内容：".$e->getMessage();
        die();
    }
$html  = <<< HTML
    <!DOCTYPE html>
    <html lang="ja">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width,initial-scale=1.0">
            <title>編集確認</title>
            <link rel="stylesheet" href="style1.css">
        </head>
        <body>
            <header>
                <h1>編集確認</h1>
                <div id = "button">
                    <a href = "adminIndex.php" class="btn bgskew"><span>トップページに戻る</span></a>
                </div>  
            </header>
            <main>
HTML;
$html .= " <form method = 'post' action='dbEditExe.php' enctype='multipart/form-data'>";
$html .= "<p>名前：<input type='text' value = '{$name}' name = 'name'></p>";
$html .= "<p>価格：<input type='text' value = '{$price}' name = 'price'></p>";
//性別〇
$ge=["メンズ","ウィメンズ"];
$html .= "<p>性別：";
$html .= "<select name = 'gender' required>";
for($g = 0; $g < count($ge); $g++){
    if($gender == $ge[$g]){
        $html .=  "<option value = '{$gender}' selected>{$gender}</option>";
        continue;
    }
    $html .=  "<option value = '{$ge[$g]}'>{$ge[$g]}</option>";
}
$html .=  "</select></p>";

//在庫〇
$html .= "<p>在庫：";
$html .= "<select name = 'stock' required>";
for($i = 0; $i <= 100; $i++){
    if($i == $stock){
        $html .= "<option value = '{$stock}' required selected>{$stock}個</option>";
        continue;
    }
    $html .="<option value = '{$i}' required>{$i}個</option>";
}
$html .= "</select></p>";
//カテゴリー〇
$cate=["トップス","スカート","パンツ","ジャケット/アウター","シューズ"];
$html .= "<p>カテゴリー：";
$html .= "<select name = 'category' required>";
for($c = 0; $c < count($cate); $c++){
    if($category == $cate[$c]){
        $html .=  "<option value = '{$category}' selected>{$category}</option>";
        continue;
    }
    $html .=  "<option value = '{$cate[$c]}'>{$cate[$c]}</option>";
    //これがないと選択されたスカートしか出ない。選択されたもの以外の選択肢も表示させるための記述

}
$html .= "</select></p>";
//サイズ〇
$si=["S","M","L"];
$html .= "<p>サイズ：";
$html .= "<select name = 'size' required>";
for($s = 0; $s < count($si); $s++){
    if($size == $si[$s]){
        $html .= "<option value = '{$size}' selected>{$size}</option>";
        continue;
    }
    $html .=  "<option value = '{$si[$s]}'>{$si[$s]}</option>";
}
$html .= "</select></p>";

//キーワード
$html .= "<p>キーワード：<input type='text' value = '{$keyword}' name = 'keyword'> </p>";

$html.= "<form  method='post' action='dbEditExe.php'>";
$html.="<input type ='hidden' name='id' value='{$id}'>";
$html.="<input type='submit' value='編集する' id='delete_button'>";
$html.="</form>";

$html  .= <<< HTML
        </main>
    </body>
</html>
HTML;
echo $html;
?>
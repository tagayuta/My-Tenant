<?php 
    session_start();
    if(empty($_SESSION["name"]) && empty($_SESSION["password"])){
        header('Location:../login/login.html');
    } elseif ($_SESSION["admin"] == 1){
        header('Location:../user/userIndex.php');
    }
    //ここに商品のIDが入る。わかりづらい変数名でごめん。
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
                $name= $row['name'];
                $gender = $row['gender'];
                $price = $row['price'];
                $stock = $row['stock'];
                $category = $row['category'];
                $size = $row['size'];
                $keyword = $row['keyWord'];
                $image1 = $row['img0'];
                if($row['img3'] != null){
                    $image2 = $row['img1'];
                    $image3 = $row['img2'];
                    $image4 = $row['img3'];
                } else if($row['img2'] != null){
                    $image2 = $row['img1'];
                    $image3 = $row['img2'];
                }  else if($row['img1'] != null){
                    $image2 = $row['img1'];
                }
                  


            }
        }
    } catch(PDOException $e) {
        echo "エラー内容：".$e->getMessage();
        die();
    }
//ここからヒアドキュメント。見える部分を記述している。
$html  = <<< HTML
    <!DOCTYPE html>
    <html lang="ja">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width,initial-scale=1.0">
            <title>削除確認</title>
            <link rel="stylesheet" href="style1.css">
        </head>
        <body>
            <header>
                <h1>削除確認</h1>
                <div id = "button">
                    <a href = "adminIndex.php" class="btn bgskew"><span>トップページに戻る</span></a>
                </div>  
            </header>
            <main>
HTML;
$html .= "<p><img src ='{$image1}'</p>";

//ここで商品の画像の枚数によって、表示する画像の数を変えている。
if($row['img3'] != null){
    $html .= "<p><img src ='{$image2}' height=200 width=200></p>";
    $html .= "<p><img src ='{$image3}'height=200 width=200></p>";
    $html .= "<p><img src ='{$image4}'height=200 width=200></p>";
} else if($row['img2'] != null){
    $html .= "<p><img src ='{$image2}'height=200 width=200></p>";
    $html .= "<p><img src ='{$image3}'height=200 width=200></p>";
}  else if($row['img1'] != null){
    $html .= "<p><img src ='{$image2}'height=200 width=200></p>";
}
$html .= "<p>名前：{$name}</p>";
$html .= "<p>価格：{$price}</p>";
$html .= "<p>性別：{$gender}</p>";
$html .= "<p>在庫：{$stock}</p>";
$html .= "<p>カテゴリー：{$category} </p>";
$html .= "<p>サイズ：{$size} </p>";
$html .= "<p>キーワード：{$keyword} </p>";
$html.= "<form  method='post' action='dbDeleteExe.php'>";
$html.="<input type ='hidden' name='form_id2' value='{$form_id}'>";
$html.="<input type='submit' value='削除する' id='delete_button'>";
$html.="</form>";

$html  .= <<< HTML
        </main>
    </body>
</html>
HTML;
echo $html;
?>
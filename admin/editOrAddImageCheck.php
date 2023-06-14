<?php 
    session_start();

    //ここに商品のIDが入る。わかりづらい変数名でごめん。
    $product_id= $_POST["form_id"];
    //ここで、画像の内容が入る。
    if($_POST["img"]==NULL){
        $img = NULL;
    } else {
        $img = $_POST["img"];
    }
    
    $mode = $_POST["mode"];
    EditImage($mode,$product_id,$img);
    function EditImage($num,$product_id,$img){
        $num1 = $num +1;
        $html = <<< _HTML_
        <!DOCTYPE html>
        <html lang="ja">
            <head>
                <meta charset="UTF-8">
                <title>編集確認</title>
            </head>
            <body>
                    <h1>画像{$num1}を編集・追加</h1>
                    <a href = "adminIndex.php" class="btn bgskew"><span>トップページに戻る</span></a>
                    <br>
        _HTML_;
        if($img == NULL){
            $html .= "<p>画像が設定されていません。</p>";
        } else {
            $html .= "<img src ='{$img}' width =200 hight 200>";
            $html .=  "<p>画像ファイル{$num1}：{$img}</p>";
        } 
        $html .= "<form action='dbEditOrAddImageExe.php' method='post' enctype='multipart/form-data'>";
        $html .=  "<input type='file'name='image' required>";
        $html .=  "<input type= 'hidden' name='img_num' value='{$num}'>";
        $html .=                "<input type= 'hidden' name='product_id' value='{$product_id}'>";
        $html .=                "<input type ='hidden' name='num' value='{$num}'>";
        $html .=               "<input type = 'submit' value~'画像を追加'>";
        $html .=            "</form>";
        $html .=    "</body>";
        $html .= "</html>";
        echo $html;
    }

?>
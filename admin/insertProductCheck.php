<?php
    session_start();
    if(empty($_SESSION["name"]) && empty($_SESSION["password"])){
        header('Location:../login/login.html');
    } elseif ($_SESSION["admin"] == 1){
        header('Location:../user/userIndex.php');
    }
    $ar = $_FILES["image"]['name'];
        $name = $_POST["name"];
        $price = $_POST["price"];
        $gender = $_POST["gender"];
        $stock = $_POST["stock"];
        $category = $_POST["category"]; 
        $size = $_POST["size"];
        $keyword = $_POST["keyword"];
        $count = count($ar);
        $admin_id = $_POST["admin_id"];
        for ($i=0; $i<$count; $i++) 
        {
            move_uploaded_file($_FILES["image"]["tmp_name"][$i],"image/".$_FILES["image"]["name"][$i]);
        } 
        $html = <<< _HTML_
            <!DOCTYPE html>
            <html lang="ja">
                <head>
                    <meta charset="UTF-8">
                    <title>商品登録確認</title>
                </head>
                <body>
                <header>
                    <h1>内容確認</h1>
                    <button type="button" onclick="history.back()">戻る</button> 
                </header>
                    <form action = "dbInsertExe.php" method ="POST">
                        <div id ="register1">
                            <p>商品名：{$name}</p>
        _HTML_;
        for ($i=0; $i<$count; $i++) 
        {
            $html .= "<img src = './image/{$ar[$i]}' height=300 width=300>";
            $html .= "<input type = 'hidden' name = 'image[]' value='{$ar[$i]}'>";
        } 
        
        $html .= <<< _HTML_

                            <p>価格：{$price}</p>
                            <p> 性別：{$gender}</p>
                            <p>在庫：{$stock}</p>
                            <p>カテゴリー：{$category}</p>
                            <p>サイズ：{$size}</p>
                            <p>キーワード：{$keyword}</p>
                            
                        </div>
                        <p>上記の内容で登録します。</p>
                        <input type ="hidden" name ="name" value='$name'>


                        <input type = "hidden" name = "price" value='{$price}'>
                        <input type = "hidden" name = "gender" value='{$gender}'>
                        <input type = "hidden" name = "stock" value='{$stock}'>
                        <input type = "hidden" name = "category" value='{$category}'>
                        <input type = "hidden" name = "size" value='{$size}'>
                        <input type = "hidden" name = "keyword" value='{$keyword}'>
                        <input type = "hidden" name = "admin_id" value='{$admin_id}'>
                        <input type = "submit" value="登録する" id="submit">
                    </form>
                </body>
            </html>

        _HTML_;


echo $html;


?>

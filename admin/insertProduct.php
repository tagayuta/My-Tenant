<?php  
    session_start();
    $id = $_SESSION["id"];
    if(empty($_SESSION["name"]) && empty($_SESSION["password"])){
        header('Location:../login/login.html');
    } elseif ($_SESSION["admin"] == 1){
        header('Location:../user/userIndex.php');
    }
?> 

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>商品登録</title>
</head>
<body>
    <header>
        <h1>商品登録ページ</h1>
        <button type="button" onclick="history.back()">戻る</button> 
    </header>
    <main>
        <form method = "post" action="insertProductCheck.php" enctype="multipart/form-data">
            <p>商品名：<input type = "text" name = "name" required></p>
            <p>値段：<input type = "text" name= "price" required></p>
            <p>性別：
            <select name = "gender" required>
                <option value = "">選択してください</option>
                <option value = "メンズ">メンズ</option>
                <option value = "ウィメンズ">ウィメンズ</option>
            </select>
            </p>
            <p>在庫：
                <select name = "stock" required>
                    <option value = "">選択してください</option>
                    <?php 
                    for($i = 0; $i <= 100; $i++){
                        echo ("<option value = '{$i}' required>{$i}個</option>");
                    }
                    ?>
                </select>
            </p>
            <p>カテゴリー：
                <select name="category">
                    <option value="トップス">トップス</option>
                    <option value="スカート">スカート</option>
                    <option value="パンツ">パンツ</option>
                    <option value="ジャケット/アウター">ジャケット/アウター</option>
                    <option value="シューズ">シューズ</option>
                </select>
            </p>
            <p>サイズ：
            <select name = "size" required>
                <option value = "">選択してください</option>
                <option value = "S">S</option>
                <option value = "M">M</option>
                <option value = "L">L</option>
            </select>
            </p>
            <p>キーワード：<input type = "text" name="keyword" required></p>
            <p>画像：<input type ="file" name ="image[]"  multiple required></p> 
            <input type = "hidden" name ="admin_id" value=<?php echo $id ?>>
            <input type = "submit" value="確認する" id="submit">
            


        </form>
    </main>
</body>
</html>
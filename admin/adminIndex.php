<?php
    session_start();
    $id = $_SESSION["id"];
    $name = $_SESSION["name"];

    $dsn = 'mysql:host=localhost;dbname=at_town;charset=utf8';
    $user = 'root';
    $pass = '';

    define('max_view',4);
    
    try{
        $dbh = new PDO($dsn,$user,$pass);
        $dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
            
        //必要なページ数を求める。ここら辺はペジネーションを作るための記述。
        $count = $dbh->prepare("SELECT COUNT(*) AS count FROM product where admin_id = '$id'");
        $count->execute();
        $total_count = $count->fetch(PDO::FETCH_ASSOC);
        $pages = ceil($total_count['count'] / max_view);

                
        //現在いるページのページ番号を取得
        if(!isset($_GET['page_id']))
        { 
            $now = 1;
        }else{
            $now = $_GET['page_id'];
        }

        //ここから商品の情報をデータベースから取得するための記述。
        $SQL = "SELECT * FROM product ORDER BY id DESC LIMIT :start,:max";
        $select = $dbh->prepare($SQL);

        //ここらへんもペジネーション。
        if ($now == 1){
            $select->bindValue(":start",$now -1,PDO::PARAM_INT);
            $select->bindValue(":max",max_view,PDO::PARAM_INT);
        } else {
            $select->bindValue(":start",($now -1 ) * max_view,PDO::PARAM_INT);
            $select->bindValue(":max",max_view,PDO::PARAM_INT);
        }

        $select->execute();
        $data = $select->fetchAll(PDO::FETCH_ASSOC);

        //ここからヒアドキュメント（PHPにHTMLを書くための手法）。$htmlにHTMLの記述を格納している感じ。

        <!DOCTYPE html>
        <html lang="ja">
        <head>
            <meta charset="UTF-8">
            <title>管理者トップページ</title>
                            <!-- CSSファイルの読み込み開始 -->
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/bxslider/4.2.12/jquery.bxslider.css">
            <!-- // CSSファイルの読み込み終了 -->


            <!-- JavaScriptファイルの読み込み開始 -->
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
            <script src="https://cdn.jsdelivr.net/bxslider/4.2.12/jquery.bxslider.min.js"></script>
            <!-- // JavaScriptファイルの読み込み終了 -->


            <!-- JavaScriptの記述開始 -->
            <script>
            $(document).ready(function(){
                $('.slider').bxSlider({ slideWidth: 200});
            });
            </script>
        </head>
        <body>
            <header>
                <h1>管理者トップページ</h1>
                <ul>
                    <li><a href = "insertProduct.php">商品登録</a></li>
                    <li><a href = "../login/logout.php">ログアウト</a></li>
                </ul>
                <p>ユーザー名：{$name}</p>
            </header>
            <main>
                <h2>登録商品一覧</h2>
                    <table border='1'>
                        <tr>    
                            <th>商品名</th>
                            <th>画像</th>
                            <th>値段</th>
                            <th>性別</th>
                            <th>在庫</th>
                            <th>カテゴリー</th>
                            <th>サイズ</th>
                            <th>キーワード</th>
                            <th>編集</th>
                            <th>画像1の編集</th>
                            <th>画像2の編集</th>
                            <th>画像3の編集</th>
                            <th>画像4の編集</th>
                            <th>削除</th>
                        </tr>
            //一旦ここで、PHPを記述したいため、ヒアドキュメントを終えている。
            //ここから、データベースから取得した内容を、繰り返し処理で、全部取り出している。
            foreach ( $data as $row ) {
                "<tr>";
                "<td>{$row['name']}</td>";
                "<td><div class='slider'> ";
                //ここで商品の画像の枚数で、表示する画像の枚数を変えている。
                for($i =0; $i < 4; $i++){
                    if($row["img{$i}"] == NULL){
                        break;
                    }
                     "<div><img src='{$row["img{$i}"]}' width='200' height='100'></div>";
                }
                "</div></td>";

                "<td>{$row['price']}</td>";
                "<td>{$row['gender']}</td>";
                if($row['stock'] <=0){
                    "<td>在庫切れ</td>";
                } else{
                    "<td>{$row['stock']}</td>";
                }
                "<td>{$row['category']}</td>";
                "<td>{$row['size']}</td>";
                "<td>{$row['keyWord']}</td>";
                //ここで、商品の内容を変更するためのページへ飛ばす記述。
                 "<form  method='POST' action='editProductCheck.php'>";
                "<input type ='hidden' name='form_id' value='{$row['id']}'>";
                "<td><input type='image' src='image/pen.jpeg' name ='submit' alt='編集' id='del' width='50' height='50'></td>";
                "</form>";
                //ここで、商品の画像を変更、または追加するためのページへ飛ばす記述。
                 "<form  method='POST' action='editOrAddImageCheck.php'>";  
                "<input type ='hidden' name='img' value='{$row["img0"]}'>";
                "<input type ='hidden' name='form_id' value='{$row['id']}'>";
                "<td><input type='submit' value='画像を編集'></td>";
                "<input type ='hidden' name='mode' value='0'>";
                "</form>";  

                //2枚目の画像があったら、変更するためのボタン。画像がなかったら、追加するためのボタンが表示されるように記述している。
                if($row["img1"]!=NULL){
                     "<form  method='POST' action='editOrAddImageCheck.php'>";  
                    "<input type ='hidden' name='img' value='{$row["img1"]}'>";
                    "<input type ='hidden' name='form_id' value='{$row['id']}'>";
                    "<td><input type='submit' value='画像を編集'></td>";
                    "<input type ='hidden' name='mode' value='1'>";
                    "</form>";
                } else {
                     "<form  method='POST' action='editOrAddImageCheck.php'>";  
                    "<input type ='hidden' name='img' value='{$row["img1"]}'>";
                    "<input type ='hidden' name='form_id' value='{$row['id']}'>";
                    "<input type ='hidden' name='mode' value='1'>";
                    "<td><input type='submit' value='画像を追加'></td>";
                    "</form>";
                }
                //ここは3枚目。
                if($row["img2"]!=NULL){
                     "<form  method='POST' action='editOrAddImageCheck.php'>";  
                    "<input type ='hidden' name='img' value='{$row["img2"]}'>";
                    "<input type ='hidden' name='form_id' value='{$row['id']}'>";
                    "<td><input type='submit' value='画像を編集'></td>";
                    "<input type ='hidden' name='mode' value='2'>";
                    "</form>";
                } else {
                     "<form  method='POST' action='editOrAddImageCheck.php'>";  
                    "<input type ='hidden' name='img' value='{$row["img2"]}'>";
                    "<input type ='hidden' name='form_id' value='{$row['id']}'>";
                    "<input type ='hidden' name='mode' value='2'>";
                    "<td><input type='submit' value='画像を追加'></td>";
                    "</form>";
                }
                //ここは4枚目。
                if($row["img3"]!=NULL){
                     "<form  method='POST' action='editOrAddImageCheck.php'>";  
                    "<input type ='hidden' name='img' value='{$row["img3"]}'>";
                    "<input type ='hidden' name='form_id' value='{$row['id']}'>";
                    "<td><input type='submit' value='画像を編集'></td>";
                    "<input type ='hidden' name='mode' value='3'>";
                    "</form>";
                } else {
                     "<form  method='POST' action='editOrAddImageCheck.php'>";  
                    "<input type ='hidden' name='img' value='{$row["img3"]}'>";
                    "<input type ='hidden' name='form_id' value='{$row['id']}'>";
                    "<input type ='hidden' name='mode' value='3'>";
                    "<td><input type='submit' value='画像を追加'></td>";
                    "</form>";
                }
                //ここは消費の内容を削除するためのページへ飛ばす記述。
                 "<form  method='POST' action='deleteProductCheck.php'>";
                "<input type ='hidden' name='form_id' value='{$row['id']}'>";
                "<td><input type='image' src='image/trashcan.jpeg' name ='submit' alt='削除' id='del' width='50' height='50'></td>";
                "</form>";
                 "</tr>";
            }
            //ここで繰り返し処理終わり。
            //ここはペジネーションを表示するための記述。
            for ( $n = 1; $n <= $pages; $n ++) {
                if ( $n == $now ){
                     "<span style='padding: 5px;'>$now</span>";
                }else{
                     <a href='adminIndex.php?page_id=$n'style='padding: 5px;'>$n</a>
                }
            }
            //最後に残りの、閉じタグを代入している。
                        </table>
                    </main>
                    <footer>

                    </footer>
                    </body>
                    </html>
                HTML;
            //ここで、HTMLの記述が入っている変数をechoすることで、HTMLが表示される、
            echo $html;
        }
    } catch(PDOException $e) {
        echo "エラー内容：".$e->getMessage();
        die();
    }

?>







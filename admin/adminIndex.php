<?php
    session_start();
    $list = $_SESSION["list"];

    $dsn = 'mysql:host=localhost; dbname=Tenant; charset=utf8';
    $user = 'root';
    $pass = '';
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/My-Tenant/admin/root.css">
    <title>管理者ページ</title>
</head>
<body>

<header>
    <h1 class="header">My Tenant</h1>
</header>
    <h1 class="admin">管理者ページ</h1>
    <!-- キーワード -->
    <div class="keyword">
        <form action="search.php" method="post">
            <input type="text" name="keyword" required="required" placeholder="キーワード検索" class="word">
            <input type="submit" value="検索" class="submit">
        </form>
    </div>
    

    <form action="refinement.php" method="post">
        <div class="refinement">
            <div class="price">
                <p>賃料</p>
                <select name="lowPrice">
                    <option value="0">0万</option>
                    <option value="50000">5万</option>
                    <option value="55000">5.5万</option>
                    <option value="60000">6万</option>
                    <option value="65000">6.5万</option>
                    <option value="70000">7万</option>
                    <option value="75000">7.5万</option>
                    <option value="80000">8万</option>
                    <option value="85000">8.5万</option>
                    <option value="90000">9万</option>
                    <option value="95000">9.5万</option>
                    <option value="100000">10万</option>
                    <option value="150000">15万</option>
                </select>
                <label for="">～</label>
                <select name="highPrice">
                    <option value="0">0万</option>
                    <option value="50000">5万</option>
                    <option value="55000">5.5万</option>
                    <option value="60000">6万</option>
                    <option value="65000">6.5万</option>
                    <option value="70000">7万</option>
                    <option value="75000">7.5万</option>
                    <option value="80000">8万</option>
                    <option value="85000">8.5万</option>
                    <option value="90000">9万</option>
                    <option value="95000">9.5万</option>
                    <option value="100000">10万</option>
                    <option value="150000">15万</option>
                </select>
            </div>

            <div class="year">
                <p>築年数</p>
                <select name="year">
                    <option value="5">5年以内</option>
                    <option value="10">10年以内</option>
                    <option value="15">15年以内</option>
                    <option value="20">20年以内</option>
                    <option value="25">25年以内</option>
                    <option value="35">30年以内</option>
                </select>
            </div>

            <div class="area">
                <h3>物件所在地</h3>
                <input type="checkbox" name="prefecture[]" value="東京都" id="tokyo">
                <label for="tokyo">東京都</label>
                <input type="checkbox" name="prefecture[]" value="埼玉県" id="saitama">
                <label for="saitama">埼玉県</label>
                <input type="checkbox" name="prefucture[]" value="神奈川県" id="kanagawa">
                <label for="kanagawa">神奈川県</label>
                <input type="checkbox" name="prefucture[]" value="千葉県" id="tiba">
                <label for="tiba">千葉県</label>
                <input type="checkbox" name="prefucture[]" value="群馬" id="gunma">
                <label for="gunma">群馬県</label>
                <input type="checkbox" name="prefucture[]" value="茨城県" id="ibaragi">
                <label for="ibaragi">茨城県</label>
            </div>

            <input type="submit" value="絞り込み" class="submit">
        </div>
    </form>

    <div class="sortBox">
        <a href="ProductAll.php">全物件表示</a>
        <a href="priceSort.php?mode=a">賃料が高い順</a>
        <a href="priceSort.php">賃料が安い順</a>
    </div>  

    <div class="add">
        <a href="insertProduct.html" class="addHouse">物件追加</a>
        <a href="userBL.php" class="black">ユーザーBL設定</a>
    </div>
    

    <?php if(!(empty($list) || $list == null)) {?>
        <div class="product-container">
        <?php foreach($list as $product): ?>
            <div class="product-link">
                <a href="productPickUp.php?id=<?= $product["product_id"] ?>">
                    <h2><?php echo $product["name"] ?></h2>
                        <?php 
                            try {
                                $db = new PDO($dsn,$user,$pass);
                                $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
                                $SQL = "SELECT * FROM images WHERE product_id = ?";
                                $stmt = $db->prepare($SQL);
                                $stmt->bindParam(1, $product["product_id"]);
                                $stmt->execute();
                                $imgList = $stmt->fetchAll();
                            } catch(PDOException $e) {
                                echo "エラー内容：".$e->getMessage();
                            } finally {
                                $db = null;
                            }
                        ?>
                    <div class="flex-container">
                        <div class="houseImg">
                            <a href="productPickUp.php/?id=<?= $product["product_id"] ?>">
                                <img src="/My-Tenant/admin/image/<?= $imgList[0][0]?>" alt="商品画像">
                            </a>
                        </div>


                        <div class="houseSource">
                            <table>
                                <tr>
                                    <th>賃料</th>
                                    <td><?php echo $product["price"] ?>円</td>
                                </tr>

                                <tr>
                                    <th>敷金</th>
                                    <td><?php echo $product["s_money"] ?>円</td>
                                </tr>

                                <tr>
                                    <th>礼金</th>
                                    <td><?php echo $product["r_money"] ?>円</td>
                                </tr>
                                <tr>
                                    <th>築年数</th>
                                    <td><?php echo $product["year"] ?>年</td>
                                </tr>

                                <tr>
                                    <th>最寄り駅</th>
                                    <td><?php echo $product["nearStation"] ?>駅</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="btnContainer">
                        <form action="editProduct.php" method="post" class="edit">
                            <input type="hidden" name="product_id" value="<?= $product["product_id"] ?>">
                            <input type="submit" value="編集">
                        </form>

                        <form action="deleteProduct.php" method="post" class="delete">
                            <input type="hidden" name="product_id" value="<?= $product["product_id"] ?>">
                            <input type="submit" value="削除">
                        </form>
                    </div>
                
            </div>
        <?php endforeach; ?>
    <?php } else{ ?>
        <p>検索条件に一致する商品はありませんでした</p>
    <?php } ?>
        </div>
        
</body>
</html>
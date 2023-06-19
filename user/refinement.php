<?php
    session_start();
    $SQL = "SELECT * FROM product WHERE ";
    $dns = 'mysql:host=localhost; dbname=Tenant; charset=utf8';
    $user = 'root';
    $pass = '';

    $lowPrice = $_POST["lowPrice"];
    $highPrice = $_POST["highPrice"];
    $prefecture = $_POST["prefecture"];
    $year = $_POST["year"];

    if(!empty($highPrice)) {
        $SQL .= "price BETWEEN " . $lowPrice . " AND " . $highPrice;
    }

    if(!empty($year)) {
        $SQL .= " AND year <= " . $year; 
    }

    if(!empty($prefecture)) {
        $SQL .= " AND ";
        foreach($prefecture as $pf) {
            $SQL .= "address LIKE '%" . $pf . "%' OR ";
        }
         
    }

    $SQL = substr($SQL, 0, -3);


    try{
        $db = new PDO($dns, $user, $pass);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $db->prepare($SQL);
        $stmt->execute();
        $list = $stmt->fetchAll();

        $_SESSION["list"] = $list;

        header('Location: userIndex.php');
        exit();

    } catch(PDOException $e) {
        echo "アクセスできませんでした";
        echo $e->getMessage();
    } finally {
        $db = null;
    }
    
?>
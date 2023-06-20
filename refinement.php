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
    $count = 0;

    if(!empty($highPrice)) {
        $SQL .= "price BETWEEN " . $lowPrice . " AND " . $highPrice . " ";
        $count++;
    }

    if(!empty($year)) {
        if($count == 0) {
            $SQL .= "year <= " . $year . " ";
        } else {
            $SQL .= "AND year <= " . $year . " ";
        }
        $count++;
    }

    if(!empty($prefecture)) {
        if($count >= 1) {
            $SQL .= "AND (";
            foreach($prefecture as $pf) {
                $SQL .= "address LIKE '%" . $pf . "%' OR ";
            }
        } else {
            foreach($prefecture as $pf) {
                $SQL .= "address LIKE '%" . $pf . "%' OR ";
            }
        }
        $SQL = substr($SQL, 0, -3);
        $SQL .= ")";
    }

    try{
        $db = new PDO($dns, $user, $pass);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $db->prepare($SQL);
        $stmt->execute();
        $list = $stmt->fetchAll();

        var_dump($list);

        $_SESSION["list"] = $list;

        header('Location: viewIndex.php');
        exit();

    } catch(PDOException $e) {
        echo "アクセスできませんでした";
        echo $e->getMessage();
    } finally {
        $db = null;
    }
    
?>
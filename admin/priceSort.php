<?php
    session_start();
    $list = $_SESSION["list"];
    $mode = $_GET["mode"];
    
    $ids = array_column($list, 'price');

    if($mode == "a") {
        // priceの降順に並び替える.
        array_multisort($ids, SORT_DESC, $list);
        $_SESSION["list"] = $list;
    } else {
        // priceの昇順に並び替える
        array_multisort($ids, SORT_ASC, $list);
        $_SESSION["list"] = $list;
    }

    header('Location: adminIndex.php');
    exit();
?>
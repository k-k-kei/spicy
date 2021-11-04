<?php

session_start();

require('function.php');

$val = $_SESSION["cart"];

// 表示用のHTMLを生成する
foreach ($_SESSION["cart"] as $key => $item) {
    $view .="<li class='cart-list'>";
    $view .="<div>".$item['title']."</div>";
    $view .="<div>".$item['text']."</div>";
    $view .="</li>";
};

?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/detail.css">
    <title>SPICY</title>
</head>

<body>
    <div>カート</div>
    <ul>
        <!-- 生成したHTMLを挿入する -->
        <?= $view ?>
    </ul>
    <a href="index_login.php">一覧</a>
    <a href="buy_confirm.php">お支払いにすすむ</a>
</body>

</html>
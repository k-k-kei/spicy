<?php
session_start();

require('function.php');

// 入力フォームのバリデーション設定
//------------------------------------------------------------
if (!isset($_POST["img_url"]) || $_POST["img_url"]=="") {
    exit("ParamError:img_url");
}

if (!isset($_POST["item_name"]) || $_POST["item_name"]=="") {
    exit("ParamError:item_name");
}

if (!isset($_POST["price"]) || $_POST["price"]=="") {
    exit("ParamError:price");
}

if (!isset($_POST["quantity"]) || $_POST["quantity"]=="") {
    exit("ParamError:quantity");
}
//------------------------------------------------------------

// もしログイン済みであれば各変数に入力値を代入する
$logined = $_SESSION["id"];

if ($logined > 0) {
    $id = $_POST["id"];
    $img_url = $_POST["img_url"];
    $item_name = $_POST["item_name"];
    $price = $_POST["price"];
    $quantity = $_POST["quantity"];

    $_SESSION["cart"]["$id"] = [
    'img_url' => $img_url,
    'item_name' => $item_name,
    'price' => $price,
    'quantity' => $quantity
    ];

    redirect("cart.php");
} else {
    redirect("./auth/login.php");
}

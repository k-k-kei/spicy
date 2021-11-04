<?php

session_start();
require('function.php');
require('database.php');

//画像アップロード時のファイル名を作成
$image = date('YmdHis') .$_FILES['image']['name'];
move_uploaded_file($_FILES['image']['tmp_name'], './image/' . $image);

//ファイル名を代入
$img_url = './image/'.$image;

$id = $_POST["id"];
$item_name = $_POST["item_name"];
$price = $_POST["price"];
$item_text = $_POST["item_text"];

//フォームに入力された情報で商品データを更新する
$sql = "UPDATE products SET item_name=:item_name,price=:price, item_text=:item_text WHERE id=:id";
$update = $pdo->prepare($sql);
$update->bindValue(':id', $id, PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
$update->bindValue(':item_name', $item_name, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$update->bindValue(':price', $price, PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
$update->bindValue(':item_text', $item_text, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)

$status = $update->execute();

//画像が添付されなければ既存の画像を保持するように分岐処理
if (isset($_FILES["image"]) && $_FILES["image"]["error"] == UPLOAD_ERR_OK) {
    $sql = "UPDATE articles SET img_url=:img_url WHERE id=:id";
    $img_update = $pdo->prepare($sql);
    $img_update->bindValue(':id', $id, PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
    $img_update->bindValue(':img_url', $img_url, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
    $img_status = $img_update->execute();
}

if ($status==false) {
    sql_error($update);
} else {
    redirect("myproductlist.php");
    exit();
}

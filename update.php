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
$title = $_POST["title"];
$text = $_POST["text"];

//フォームに入力された情報で記事データを更新する
$sql = "UPDATE articles SET title=:title, text=:text WHERE id=:id";
$update = $pdo->prepare($sql);
$update->bindValue(':id', $id, PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
$update->bindValue(':title', $title, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$update->bindValue(':text', $text, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)

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
    redirect("mypage.php");
    exit();
}

<?php

require('function.php');
require('database.php');

$id = $_POST["id"];

// 指定したIDと同一の記事を取得
$sql = "SELECT * FROM articles WHERE id=:id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
$res = $stmt->execute();

$val = $stmt->fetch();
$img = $val["img_url"];

unlink($img);

// 指定したIDの記事を削除
$sql = "DELETE FROM articles WHERE id=:id";
$delete = $pdo->prepare($sql);
$delete->bindValue(':id', $id, PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
$status = $delete->execute();

if ($status==false) {
    sql_error($delete);
} else {
    redirect("mypage.php");
    exit();
}

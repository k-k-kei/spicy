<?php

session_start();

require('function.php');
require('database.php');

//ユニークになるようにファイル名を命名
//※セッションIDも入れればなおよし
$image = date('YmdHis') .$_FILES['image']['name'];

//画像アップロード後、tempフォルダに自動で格納される。
//そのためtempフォルダ内にある画像ファイルを指定のファイルにうつして上げる必要がある。
//move_uploaded_file関数を使って（どのデータを？, どこに？）移すかを指示する。
move_uploaded_file($_FILES['image']['tmp_name'], './image/' . $image);

$title = $_POST["title"];
$text = $_POST["text"];
$product_url = $_POST["product_url"];
$img_url = './image/'.$image;
$member_id = $_POST["member_id"];

//CSRF対策のためのトークン認証実施
//空白は通さないバリデーションを実施
if ($_POST['csrfToken'] === $_SESSION['csrfToken']) {
    if ($_POST["title"] !=="" || $_POST["text"] !=="" || $_FILES['image']['name'] !=="") {
        $sql = "INSERT INTO articles(title, text,product_url, img_url, member_id, created_at)VALUES(:title, :text, :product_url, :img_url, :member_id, sysdate())";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':title', $title, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
        $stmt->bindValue(':text', $text, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
        $stmt->bindValue(':product_url', $product_url, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
        $stmt->bindValue(':img_url', $img_url, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
        $stmt->bindValue(':member_id', $member_id, PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
        $status = $stmt->execute();
    } else {
        redirect("index_login.php");
        echo("空白は登録できません！");
    }
} else {
    redirect("index_login.php");
}

if ($status==false) {
    sql_error($stmt);
} else {
    redirect("index_login.php");
    exit();
}

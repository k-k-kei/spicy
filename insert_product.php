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

$item_name = $_POST["item_name"];
$price = $_POST["price"];
$item_text = $_POST["item_text"];
$img_url = './image/'.$image;
$member_id = $_POST["member_id"];
$quantity = $_POST["quantity"];


//CSRF対策のためのトークン認証実施
//空白は通さないバリデーションを実施
if ($_POST['csrfToken'] === $_SESSION['csrfToken']) {
    if ($_POST["item_name"] !=="" || $_POST["price"] !=="" || $_POST["item_text"] !=="" || $_FILES['image']['name'] !=="") {
        $sql = "INSERT INTO products(item_name, price, item_text, img_url, quantity, member_id, created_at)VALUES(:item_name, :price, :item_text, :img_url, :quantity, :member_id, sysdate())";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':item_name', $item_name, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
        $stmt->bindValue(':price', $price, PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
        $stmt->bindValue(':item_text', $item_text, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
        $stmt->bindValue(':img_url', $img_url, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
        $stmt->bindValue(':quantity', $quantity, PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
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
    redirect("myproductlist.php");
    exit();
}

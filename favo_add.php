<?php

session_start();

require('function.php');
require('database.php');

    //フォーム入力された値を変数に代入
    $article_id = $_POST["post_id"];
    $maker_id = $_POST["post_member"];
    $user_id = $_POST["post_user"];
    $status = $_POST["favo"];

    // お気に入り登録ステータスの場合入力されたデータをデータベースへ保存
    if ($status === "お気に入り登録") {
        $sql = "INSERT INTO favorites(article_id, user_id, maker_id, created_at)VALUES(:article_id, :user_id, :maker_id, sysdate())";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(":article_id", $article_id, PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
        $stmt->bindValue(":user_id", $user_id, PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
        $stmt->bindValue(":maker_id", $maker_id, PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
        $status = $stmt->execute();

        if ($status==false) {
            sql_error($stmt);
        } else {
            redirect("detail.php?id=".$article_id);
        }
    } else {
        //その他の場合は削除処理行う
        $sql = "DELETE FROM favorites WHERE article_id=:article_id AND user_id=:user_id";
        $delete = $pdo->prepare($sql);
        $delete->bindValue(':article_id', $article_id, PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
        $delete->bindValue(':user_id', $user_id, PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
        $status = $delete->execute();
        
        if ($status==false) {
            sql_error($stmt);
        } else {
            redirect("detail.php?id=".$article_id);
        }
    }

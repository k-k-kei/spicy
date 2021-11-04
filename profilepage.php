<?php

session_start();

require('function.php');
require('database.php');

//記事詳細の作者
$member_id = $_SESSION["maker_id"];

//usersデータベースから取得
$sql = "SELECT * FROM users WHERE id=:member_id";
$info = $pdo->prepare($sql);
$info->bindValue(":member_id", $member_id, PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
$profile = $info->execute();

if ($profile==false) {
    sql_error($info);
} else {
    $user_info = $info->fetch();
}

//articlesデータベースから取得
$sql = "SELECT * FROM articles WHERE member_id=:member_id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(":member_id", $member_id, PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
$status = $stmt->execute();

if ($status==false) {
    sql_error($stmt);
}

//productsデータベースから取得
$sql = "SELECT * FROM products WHERE member_id=:member_id";
$response = $pdo->prepare($sql);
$response->bindValue(":member_id", $member_id, PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
$res = $response->execute();

if ($res==false) {
    sql_error($response);
}

?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/backyard.css">
    <title>SPICY</title>
</head>

<body>

    <div class="content">プロフィール</div>
    <div>
        <?= $user_info["name"] ?>
    </div>

    <div class="post-back">
        <?php foreach ($stmt as $article): ?>
        <div class="items-back">
            <table class="item-table">
                <tr>
                    <td>
                        <?= h($article["title"]) ?>
                    </td>
                    <td>
                        <?= h($article["text"]) ?>
                    </td>
                </tr>
            </table>
        </div>
        <?php endforeach; ?>
    </div>

    <div class="post-back">
        <?php foreach ($response as $product): ?>
        <div class="items-back">
            <table class="item-table">
                <tr>
                    <td>
                        <?= h($product["item_name"]) ?>
                    </td>
                    <td>
                        <?= h($product["item_text"]) ?>
                    </td>
                </tr>
            </table>
        </div>
        <?php endforeach; ?>
    </div>

    <script src="js/jquery-3.6.0.min.js"></script>
    <script src="js/main.js"></script>

</body>

</html>
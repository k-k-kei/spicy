<?php

session_start();
require('function.php');
require('database.php');


$id = $_GET["id"];
$user_id = $_SESSION["id"];

// 指定したIDの記事を取得
$sql = "SELECT * FROM articles WHERE id=:id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$status = $stmt->execute();

if ($status == false) {
    sql_error($stmt);
} else {
    $row = $stmt->fetch();
}

$_SESSION["maker_id"] = $row["member_id"];

// お気に入り登録一覧で現在開いている記事のidと一致する
// かつ、自身のidが登録されているものを取得する
$sql = "SELECT count(*) FROM favorites WHERE user_id = $user_id AND article_id = $id";
$response = $pdo->prepare($sql);
$response->bindValue(':articleid', $id, PDO::PARAM_STR);
$response->bindValue(':user_id', $user_id, PDO::PARAM_STR);
$res = $response->execute();

if ($res == false) {
    sql_error($res);
} else {
    $val = $response->fetch();
}

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
    <div class="wrap">

        <!-- 詳細を表示 -->
        <form action="add_cart.php" method="post">
            <div class="main">
                <div class="content">
                    <div class="info">
                        <div class="img_url">
                            <img src="<?= h($row['img_url']) ?>"
                                alt="">
                        </div>
                        <div class="title">
                            <?= h($row['title']) ?>
                        </div>
                        <div class="text">
                            <?= h($row['text']) ?>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <!-- 商品ページへ遷移 -->
        <div class="product_url">商品ページはこちら：<a
                href="<?= h($row['product_url']) ?>">
                <?= h($row['product_url']) ?>
            </a>
        </div>

        <!-- お気に入り登録 -->
        <form class="favorite_count" action="favo_add.php" method="post">
            <input class="article_id" type="hidden" name="post_id"
                value="<?= $row["id"] ?>">
            <input class="member_id" type="hidden" name="post_member"
                value="<?= $row["member_id"] ?>">
            <input class="user_id" type="hidden" name="post_user"
                value="<?= $user_id ?>">
            <?php if ($val["count(*)"] > 0): ?>
            <input type="submit" name="favo" class="favo-btn01" value="登録解除">
            <?php else: ?>
            <input type="submit" name="favo" class="favo-btn02" value="お気に入り登録">
            <?php endif; ?>
        </form>

        <!-- 戻るボタン -->
        <div class="back">
            <?php if ($user_id > 0):  ?>
            <a href="index_login.php">メインへ</a>
            <?php else:  ?>
            <a href="index.php">メインへ</a>
            <?php endif;  ?>
        </div>

    </div>

    <script src="js/jquery-3.6.0.min.js"></script>
    <script src="js/main.js"></script>

</body>

</html>
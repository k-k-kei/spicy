<?php

session_start();
require('function.php');
require('database.php');


$id = $_GET["id"];
$user_id = $_SESSION["id"];

//指定したIDと一致する商品データを取得
$sql = "SELECT * FROM products WHERE id=:id";
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
$sql = "SELECT count(*) FROM favorites WHERE user_id=$user_id AND article_id=$id";
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
                        <!-- <a href="profilepage.php">個人</a> -->
                        <div class="title">
                            <?= h($row['item_name']) ?>
                        </div>
                        <div class="text">
                            <?= h($row['item_text']) ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- カートに追加するフォームと連携 -->
            <div class="cart">
                何個ほしい？：<input type="text" name="quantity" placeholder="0">
                <button class="cart-btn">カートに入れる</button>
            </div>
            <input type="hidden" name="id"
                value="<?= $row["id"] ?>">
            <input type="hidden" name="img_url"
                value="<?= $row["img_url"] ?>">
            <input type="hidden" name="item_name"
                value="<?= $row["item_name"] ?>">
            <input type="hidden" name="price"
                value="<?= $row["price"] ?>">
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
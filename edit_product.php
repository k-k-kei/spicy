<?php

require('function.php');
require('database.php');

$id = $_GET["id"];

// 指定したIDと一致する商品データを取得
$sql = "SELECT * FROM products WHERE id=:id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$status = $stmt->execute();

if ($status == false) {
    sql_error($stmt);
} else {
    $row = $stmt->fetch();
}

?>

<!DOCTYPE html>
<html lang="ja">

<head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="css/reset.css">
        <link rel="stylesheet" href="css/myproducts.css">
        <title>SPICY</title>
</head>

<body>
        <div class="wrap">
                <div class="back">
                        <a href="mypage.php">戻る</a>
                </div>
                <div class="main-text">
                        <h1>商品を編集</h1>
                </div>

                <!-- 画像、タイトル、テキストを入力 -->
                <div class="container">
                        <div class="input-box">
                                <form method="post" action="update_product.php" enctype="multipart/form-data">
                                        <div class="form-box">
                                                <div>画像：<input type="file" name="image" class="image-input"
                                                                value="<?= h($row["img_url"]) ?>">
                                                </div></br>
                                                <div class="title">
                                                        <input type="text" name="item_name" class="item_name"
                                                                value="<?= h($row["item_name"]) ?>">
                                                </div></br>
                                                <div class="price">
                                                        <input type="text" name="price" class="price"
                                                                value="<?= h($row["price"]) ?>">
                                                </div></br>
                                                <div class="text">
                                                        <textarea name="item_text"
                                                                class="item_text"><?= h($row["item_text"]) ?></textarea>
                                                </div></br>
                                                <div class="quantity">
                                                        数量：<input name="quantity" class="quantity"
                                                                value="<?= h($row["quantity"]) ?>"></input>
                                                </div></br>
                                                <input type="hidden" name="id"
                                                        value="<?= h($row["id"]) ?>">
                                                <input type="hidden" name="csrfToken"
                                                        value="<?= $csrfToken ?>">
                                                <input type="submit" value="送信">
                                        </div>
                                </form>
                        </div>

                        <div class="view-area">
                                <img class="view-img">
                                <div class="name-box">
                                        <p class="view-title">商品名を入力</p>
                                </div>
                                <div class="text-box">
                                        <p class="view-text">商品の概要を記載しよう</p>
                                </div>
                        </div>
                </div>
        </div>

        <script src="js/jquery-3.6.0.min.js"></script>
        <script src="js/mystories_product.js"></script>

</body>

</html>
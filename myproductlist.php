<?php

session_start();

require('function.php');
require('database.php');

//ログインしているユーザーのusers idを取得
$user_id = intval($_SESSION["id"]);

$sql = "SELECT * FROM products WHERE member_id=$user_id";
$stmt = $pdo->prepare($sql);
$status = $stmt->execute();

if ($status==false) {
    sql_error($stmt);
}

?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/myproductlist.css">
    <title>SPICY</title>
</head>

<body>
    <div class="wrap">
        <div class="main-text">
            <h1>登録済みの商品</h1>
        </div>

        <div class="list">
            <table class="item-table">
                <tr>
                    <th>画像</th>
                    <th>商品名</th>
                    <th>料金</th>
                    <th>数量</th>
                    <th></th>
                    <th></th>
                </tr>
                <?php foreach ($stmt as $product): ?>
                <tr class="list-table">
                    <td class="img_url">
                        <img
                            src="<?= h($product['img_url']) ?>">
                    </td>
                    <td class="item_name">
                        <a
                            href="detail.php?id=<?= h($product['id']) ?>">
                            <?= h($product["item_name"]) ?>
                        </a>
                    </td>
                    <td>
                        <?= h($product["price"]) ?>
                    </td>
                    <td>
                        <?= h($product["quantity"]) ?>
                    </td>
                    <td class="edit">
                        <a
                            href="edit_product.php?id=<?= h($product['id']) ?>">編集</a>
                    </td>
                    <td class="delete">
                        <form action="delete.php" method="post">
                            <div class="delete-back">削除</div>
                            <input type="hidden" name="id"
                                value="<?= h($product["id"]) ?>">
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
        </div>
        </table>
    </div>
    </div>

    <!-- 戻るボタン -->
    <div class="back">
        <?php if ($user_id > 0):  ?>
        <a href="mypage.php">戻る</a>
        <?php else:  ?>
        <a href="index.php">戻る</a>
        <?php endif;  ?>
    </div>
    <script src="js/delete.js"></script>
</body>

</html>
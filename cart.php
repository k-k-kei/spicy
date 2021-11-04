<?php
session_start();

require('function.php');

$val = $_SESSION["cart"];

?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/cart.css">
    <title>SPICY</title>
</head>

<body>
    <div class="wrap">
        <div class="main-text">
            <h1>カートにある商品</h1>
        </div>
        <div class="list">
            <table class="item-table">
                <tr>
                    <th>画像</th>
                    <th>商品名</th>
                    <th>料金</th>
                    <th>数量</th>
                    <th>合計</th>
                </tr>
                <?php foreach ($val as $item): ?>
                <tr class="list-table">
                    <td class="img_url">
                        <img src="<?= $item["img_url"] ?>"
                            alt="">
                    </td>
                    <td>
                        <?= $item["item_name"] ?>
                    </td>
                    <td>
                        <?= $item["price"] ?>
                    </td>
                    <td>
                        <?= $item["quantity"] ?>
                    </td>
                    <td>
                        <?= $item["price"] * $item["quantity"] ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </table>
            <div class="amount">合計金額：<span class="fee">0</span>円</div>
        </div>

    </div>

    <!-- 戻るボタン -->
    <div class="back">
        <?php if ($user_id > 0):  ?>
        <a href="mypage.php">戻る</a>
        <?php else:  ?>
        <a href="mypage.php">戻る</a>
        <?php endif;  ?>
    </div>
</body>

</html>
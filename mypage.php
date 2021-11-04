<?php
session_start();

require('function.php');
require('database.php');

//ログインしているユーザーのusers idを取得
$user_id = $_SESSION["id"];

// favoritesテーブルからお気に入り登録した項目を抽出
$sql = "SELECT * FROM favorites AS f INNER JOIN articles AS a ON f.article_id = a.id WHERE user_id=:user_id LIMIT 0,6";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
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
    <link rel="stylesheet" href="css/mypage.css">
    <title>SPICY</title>
</head>

<body>
    <div class="wrap">
        <div class="main-text">
            <h1>マイページ</h1>
        </div>

        <div class="nav">
            <!-- マイページのナビゲーションバー -->
            <ul class="nav-list">
                <li class="list"><a href="index_login.php">トップに戻る</a></li>
                <li class="list"><a href="mystorylist.php">自分のストーリーを見る</a></li>
                <li class="list"><a href="myproductlist.php">自分の商品一覧を見る</a></li>
                <li class="list"><a href="cart.php">カートを覗く</a></li>
            </ul>
        </div>

        <div class="box">
            <div class="content">
                <div class="content-text">お気に入りしたストーリー</div>
                <div class="main">
                    <!-- お気に入り登録したストーリーを追加 -->
                    <?php foreach ($stmt as $favorite): ?>
                    <div class="item">
                        <div class="img_url">
                            <a
                                href="detail.php?id=<?= h($favorite['id']) ?>">
                                <img src="<?= h($favorite["img_url"]) ?>"
                                    alt="">
                            </a>
                        </div>
                        <div class="title">
                            <?= h($favorite["title"]) ?>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="sub-menu">
                <!-- ストーリー作成と商品登録を行うページへ遷移するボタン -->
                <ul class="menu-list">
                    <li class="list story"><a href="mystories.php">ストーリーを書く</a></li>
                    <li class="list product"><a href="myproducts.php">商品を登録する</a></li>
                </ul>
            </div>
        </div>
    </div>
</body>

</html>
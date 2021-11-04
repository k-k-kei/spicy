<?php

session_start();

//セッションハイジャック対策
//もしログインしていなければエラー文を表示
if (!isset($_SESSION["chk_ssid"]) || $_SESSION["chk_ssid"]!=session_id()) {
    echo "Login Error!";
    exit();
} else {
    session_regenerate_id(true);
    $_SESSION["chk_ssid"] = session_id();
}

require('function.php');
require('database.php');

//ログインユーザーのidと名前を取得
$username = $_SESSION["name"];
$id = $_SESSION["id"] ;


//ログイン中ユーザー自身が作成したものを除く投稿をデータベースから取得
$sql = "SELECT * FROM articles WHERE NOT member_id=:id LIMIT 0,6";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
$status = $stmt->execute();

if ($status==false) {
    sql_error($stmt);
}

//ログイン中ユーザー自身が作成したものを除く商品をデータベースから取得
$sql = "SELECT * FROM products WHERE NOT member_id=:id LIMIT 0,6";
$products = $pdo->prepare($sql);
$products->bindValue(':id', $id, PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
$pds = $products->execute();

if ($pds==false) {
    sql_error($products);
}


?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/main.css">
    <title>SPICY</title>
</head>

<body>
    <div class="wrapper">

        <!-- ヘッダー -->
        <div class="header">
            <div class="header-bar">
                <div class="register">
                    <div class="logo">
                        <div class="logo-img">
                            <div class="service-name">
                                <a href="index_login.php">--- Spicy ---</a>
                            </div>
                        </div>
                    </div>
                    <div class="menu">
                        <div class="menu mypage">
                            <a href="mypage.php">マイページ</a>
                        </div>
                        <div class="menu signin logout">
                            <a href="./auth/logout.php">ログアウト</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- メインビジュアル -->
        <h1 class="stories">物語のある暮らしを</h1>

        <!-- ストーリーボード -->
        <div class="container">
            <div class="box">
                <h2>いろんな人のストーリー</h2>
                <div class="item-block">
                    <div class="main">
                        <!-- 
                            
                        取得した投稿を表示
                    
                    -->
                        <?php foreach ($stmt as $article): ?>
                        <div class="item">
                            <div class="img_url">
                                <a
                                    href="detail.php?id=<?= h($article['id']) ?>">
                                    <img
                                        src="<?= h($article["img_url"]) ?>">
                                </a>
                            </div>
                            <div class="title">
                                <?= h($article["title"]) ?>
                            </div>
                            <div class="detail">
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>

                    <!-- プロダクトボード -->
                    <h2>いろんな商品</h2>
                    <div class="main">
                        <!-- 
                            
                        取得した商品を表示
                    
                    -->
                        <?php foreach ($products as $product): ?>
                        <div class="item">
                            <div class="img_url">
                                <a
                                    href="product_detail.php?id=<?= h($product['id']) ?>">
                                    <img
                                        src="<?= h($product["img_url"]) ?>">
                                </a>
                            </div>
                            <div class="title">
                                <?= h($product["item_name"]) ?>
                            </div>
                            <div class="detail">
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <!-- サイドバー -->
            <!-- 投稿の種となるキーワードを表示する領域 -->
            <div class="side">
                <div class="side-box">
                    <div class="story-title">あなたのストーリーを投稿しませんか？</div>
                    <ul class="side-contents">
                        <li class="list">
                            <form action="mystories.php" method="post">
                                <a href="./mystories.php">
                                    #人生で面白かったこと
                                </a>
                                <input type="hidden" name="theme" value="#人生で面白かったこと">
                            </form>
                        </li>
                        <li class="list">
                            <form action="mystories.php" method="post">
                                <a href="./mystories.php">
                                    #作ったときの気持ち
                                </a>
                                <input type="hidden" name="theme" value="#作ったときの気持ち">
                            </form>
                        </li>
                        <li class="list">
                            <form action="mystories.php" method="post">
                                <a href="./mystories.php">
                                    #どんぐりころころ
                                </a>
                                <input type="hidden" name="theme" value="#どんぐりころころ">
                            </form>
                        </li>
                        <li class="list">
                            <form action="mystories.php" method="post">
                                <a href="./mystories.php">
                                    #それがないとどうなる？
                                </a>
                                <input type="hidden" name="theme" value="#それがないとどうなる？">
                            </form>
                        </li>
                        <li class="list">
                            <form action="mystories.php" method="post">
                                <a href="./mystories.php">
                                    #明日地球が滅ぶなら？
                                </a>
                                <input type="hidden" name="theme" value="#明日地球が滅ぶなら？">
                            </form>
                        </li>
                        <li class="list">
                            <form action="mystories.php" method="post">
                                <a href="./mystories.php">
                                    #あなたの勝負メシは？
                                </a>
                                <input type="hidden" name="theme" value="#あなたの勝負メシは？">
                            </form>
                        </li>
                        <li class="list">
                            <form action="mystories.php" method="post">
                                <a href="./mystories.php">
                                    #今叫びたいこと
                                </a>
                                <input type="hidden" name="theme" value="#今叫びたいこと">
                            </form>
                        </li>
                        <li class="list">
                            <form action="mystories.php" method="post">
                                <a href="./mystories.php">
                                    #discord難民
                                </a>
                                <input type="hidden" name="theme" value="#discord難民">
                            </form>
                        </li>
                        <li class="list">
                            <form action="mystories.php" method="post">
                                <a href="./mystories.php">
                                    #夢と希望がない世界で
                                </a>
                                <input type="hidden" name="theme" value="#夢と希望がない世界で">
                            </form>
                        </li>
                        <li class="list">
                            <form action="mystories.php" method="post">
                                <a href="./mystories.php">
                                    #何でも食える。何食う？
                                </a>
                                <input type="hidden" name="theme" value="#何でも食える。何食う？">
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- jsファイル読み込み -->
        <script src="js/jquery-3.6.0.min.js"></script>
        <script src="js/main.js"></script>

</body>

</html>
<?php

session_start();

require('function.php');
require('database.php');

$user_id = $_SESSION["id"];

//CSRF対策
$csrfToken = csrf();
$_SESSION['csrfToken'] = $csrfToken;


?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/mystories.css">
    <title>SPICY</title>
</head>

<body>
    <div class="wrap">
        <div class="back">
            <a href="mypage.php">戻る</a>
        </div>
        <div class="main-text">
            <h1>ストーリーを登録</h1>
        </div>

        <!-- 画像、タイトル、テキストを入力 -->
        <div class="container">
            <div class="input-box">
                <form method="post" action="insert.php" enctype="multipart/form-data">
                    <div class="form-box">
                        <div>画像：<input type="file" name="image" class="image-input"></div></br>
                        <div class="title">
                            <input type="text" name="title" class="title-input" placeholder="タイトルを入力">
                        </div></br>
                        <div class="text">
                            <textarea name="text" class="text-input" placeholder="ストーリーを綴ろう"></textarea>
                        </div></br>
                        <div class="product_url">
                            <input name="product_url" class="product_url" placeholder="URL貼り付け"></input>
                        </div></br>
                        <input type="hidden" name="member_id"
                            value="<?= $user_id ?>">
                        <input type='hidden' name='csrfToken'
                            value='<?= $csrfToken ?>'>
                        <input type="submit" value="送信">
                    </div>
                </form>
            </div>

            <div class="view-area">
                <img class="view-img">
                <div class="title-box">
                    <p class="view-title">タイトルを入力</p>
                </div>
                <div class="text-box">
                    <p class="view-text">あなたのストーリーを教えてください</p>
                </div>
            </div>
        </div>
    </div>

    <script src="js/jquery-3.6.0.min.js"></script>
    <script src="js/mystories.js"></script>

</body>

</html>
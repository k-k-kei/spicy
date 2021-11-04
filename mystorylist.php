<?php

session_start();

require('function.php');
require('database.php');

//ログインしているユーザーのusers idを取得
$user_id = intval($_SESSION["id"]);

// 自身のidと一致する記事をデータベースから取得
$sql = "SELECT * FROM articles WHERE member_id=$user_id";
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
    <link rel="stylesheet" href="css/mystorylist.css">
    <title>SPICY</title>
</head>

<body>
    <div class="wrap">
        <div class="main-text">
            <h1>作成済みのストーリー</h1>
        </div>

        <div class="list">
            <table class="item-table">
                <tr>
                    <th>画像</th>
                    <th>タイトル</th>
                    <th></th>
                    <th></th>
                </tr>
                <?php foreach ($stmt as $article): ?>
                <tr>
                    <td class="img_url">
                        <img
                            src="<?= h($article['img_url']) ?>">
                    </td>
                    <td class="title">
                        <a
                            href="detail.php?id=<?= h($article['id']) ?>">
                            <?= h($article["title"]) ?>
                        </a>
                    </td>
                    <td class="edit">
                        <a
                            href="edit_story.php?id=<?= h($article['id']) ?>">編集</a>
                    </td>
                    <td class="delete">
                        <form action="delete.php" method="post">
                            <div class="delete-back">削除</div>
                            <input type="hidden" name="id"
                                value="<?= h($article["id"]) ?>">
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
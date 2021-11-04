<?php

// 各ページで汎用的に使用する関数をまとめる
// 主にセキュリティ保護系の関数
//-------------------------------------------------------------------

//XXS対策
function h($str)
{
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

//エラー処理
function sql_error($stmt)
{
    $error = $stmt->errorInfo();
    exit("ErrorQuery:".$error[2]);
}

//リダイレクト
function redirect($file_name)
{
    header("Location: ".$file_name);
    exit();
}

//CSRF対策
function csrf()
{
    $TOKEN_LENGTH = 16;
    $tokenByte = openssl_random_pseudo_bytes($TOKEN_LENGTH);
    $csrfToken = bin2hex($tokenByte);
    return $csrfToken;
}

//-------------------------------------------------------------------

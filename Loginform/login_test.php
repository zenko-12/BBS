<?php // login.php

try {
	// データベースに接続
    $dbh = new PDO(
        'mysql:dbname=zenko;host=localhost;charset=utf8mb4',
        'zenko',
        'pazenkoss',
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]
    );
    // 接続出来た場合
    //echo("MySQLへの接続成功!");

    /* データベースから値を取ってきたり， データを挿入したりする処理 */
} catch (PDOException $e) {

    //接続失敗した場合
    //echo("MySQLへの接続失敗 <br>");
    
    //エラーの表示
    exit($e->getMessage()); 
}

//
$login_account = login($dbh, strval($_POST['login_id'] ?? ''), strval($_POST['password'] ?? ''));
if (null === $login_account) {
    // ログイン失敗
    echo 'NG';
    //exit;
}

function login($dbh, string $login_id, string $password) : ?array
{
    // ごく最低限のvalidate
    if ( ('' === $login_id)||('' === $password) ) {
        // ログイン失敗
        return null;
    }

    // プリペアドステートメントの作成
    $pre = $dbh->prepare('SELECT * FROM user WHERE login_id=:login_id AND password=:password;');
    // 値のバインド
    $pre->bindValue(':login_id', $login_id);
    $pre->bindValue(':password', $password);
    // SQLの実行
    $r = $pre->execute();
    // レコードの取得
    $account = $pre->fetch( \PDO::FETCH_ASSOC );

    // レコードが空なら
    if (false === $account) {
        // ログイン失敗
        echo("ログイン失敗");
        return null;
    }
    
    // ログイン成功
    echo("ログイン成功!");
    return $account;
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>ログインページ</title>
<link href="login.css" rel="stylesheet" type="text/css">
</head>
<body>
<h1>ログインページ</h1>
<div class="loginform">

    <form action="login.php" method="POST">
		<div>次回ここからログイン失敗です。</div>
        <ul>
            <li>ユーザー名：<input name="login_id" type="text"></li>
            <li>パスワード：<input name="password" type="password"></li>
            <li><input name="送信" type="submit"></li>
        </ul>
  </form>
</div>
</body>
</html>
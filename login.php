<?php // login.php

// DB接続
require_once('dbconnect.php');

// Authenticationクラスのloginを呼び出して認証
require_once('init.php');

//


$login_account = Authentication::login($dbh, strval($_POST['login_id'] ?? ''), strval($_POST['password'] ?? ''));
if (null === $login_account) {
    // ログイン失敗
    //echo 'NG';
    //exit;
} else {
	// 認可処理
	session_regenerate_id(true);
	unset($login_account['password']);
	$_SESSION['user'] = $login_account;
	
	//
	//echo 'ログイン成功';
	header("Location: post.php");
	exit;
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
        <ul>
            <li>ユーザー名：<input name="login_id" type="text"></li>
            <li>パスワード：<input name="password" type="password"></li>
            <li><input name="送信" type="submit"></li>
        </ul>
  </form>
</div>
<a href= "register.php">会員登録はこちら</a>
</body>
</html>
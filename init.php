<?php //
//
ob_start();
session_start();

//
require_once('dbconnect.php');

//
function h($s) {
	return htmlspecialchars($s, ENT_QUOTES); 
}
function postAndH($data, $name) {
	return h($data[$name] ?? '');
}

class Authentication
{
	public static function login($dbh, string $login_id, string $password) : ?array
	{
		// ごく最低限のvalidate
		if ( ('' === $login_id)||('' === $password) ) {
			// ログイン失敗
			return null;
		}

		// プリペアドステートメントの作成
		$pre = $dbh->prepare('SELECT * FROM user WHERE login_id=:login_id');
		// 値のバインド
		$pre->bindValue(':login_id', $login_id);
		// $pre->bindValue(':password', $password);
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
	
		// パスワードを比較(ハッシュで比較)
		if (false === password_verify($password, $account['password'])) {
			// ログイン失敗
			echo("ログイン失敗");
			return null;
		}

		// ログイン成功
		echo("ログイン成功");
		return $account;
	}
}
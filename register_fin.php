<?php //register.php
//
// 内部処理のコード
require_once('init.php');

//
$data = [];
foreach(['id', 'password', 'password2'] as $s) {
    $data[$s] = strval($_POST[$s] ?? '');
}

//
$error = [];
//
if (!empty($_POST)) {
//
    if ($data['id'] == ""){
        $error['id'] = true;
    }
    if ($data['password'] == ""){
        $error['password'] = true;
    }
    if ($data['password2'] == ""){
        $error['password2'] = true;
    }

// パスワード6文字以上の設定 
    if (strlen($data['password'] )< 6 ) {
        $error['password_length'] = true;
    }

//  パスワードと再入力のパスワードが違った場合
    if (($data['password'] != $data['password2']) && ($data['password2'] != "")){
        $error['password_difference'] = true;
    }
}

// 

//
if ([] !== $error) {
	//
	unset($data['password']);
	unset($data['password2']);
	//
	$_SESSION['flash']['error'] = $error;
	$_SESSION['flash']['data'] = $data;
	header('Location: ./register.php');
	exit;
}

//  SQLに書き込む処理
//var_dump($data);exit;

try {
	// プリペアドステートメント(準備された文)を用意
	$sql = 'INSERT INTO user(login_id, password) VALUES(:login_id, :password);';
	$pre = $dbh->prepare($sql);
	//var_dump($pre);

	// プレースホルダに値をバインド
	$p = password_hash($data["password"],PASSWORD_DEFAULT);

	$pre->bindValue(':login_id', $data["id"]);
	$pre->bindValue(':password', $p);

	// SQLを実行
	$r = $pre->execute();
	//var_dump($r);

} catch(\PDOException $e) {
    //echo $e->getMessage();
	// 受け取ったとき戻る
	$s = $e->getMessage();
	$needle = 'Duplicate entry';
	if (strpos($s, $needle)){
		$_SESSION['flash']['sql_error']= '登録済みのIDです';
	} else {
		$_SESSION['flash']['sql_error']= $s;
	}
	//var_dump($_SESSION);
	//exit;
	header('Location: ./register.php');
	exit;
}

//
header('Location: ./register_thx.html');

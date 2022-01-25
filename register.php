<?php //register.php
//
// 表示のコード
require_once('init.php');

$error = $_SESSION['flash']['error'] ?? [];
$data = $_SESSION['flash']['data'] ?? [];
$sql_error = $_SESSION['flash']['sql_error'] ?? '';
unset($_SESSION['flash']);

?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <title>会員登録</title>
</head>
<body>
<h1>会員登録</h1> 
<?php  echo $sql_error; ?>
<form action="./register_fin.php" method="POST">
    <!--idの処理-->
    <?php if (isset($error['id'])): ?>
        <p class="error">IDを入力してください</p>
    <?php endif; ?>

    <p>ID:<input type="text" name="id" value="<?php echo postAndH($data, 'id'); ?>"></p>
    <!-- ここからシンタクスエラーと関数にしたところの変更 -->

    <!--passwordの処理-->
    <?php if (isset($error['password'])): ?>
        <p class="error">パスワードを入力してください</p>
    <?php endif; ?>

    <?php if (isset($error['password'])): ?>
        <p class="error"> 6文字以上で指定してください</p>
    <?php endif; ?>

    <p>パスワード:<input type="password" name="password"></p>
 
    <!--password2の処理-->
    <?php if (isset($error['password2'])): ?>
        <p class="error"> パスワードを入力してください</p>
    <?php endif; ?>

    <?php if (isset($error['password2'])): ?>
        <p class="error"> パスワードが上記と違います</p>
    <?php endif; ?>
    
    <p>パスワード再入力<input type="password" name="password2"></p>

    <input type="submit" value="登録する" class="button">
<form>
<br>
<a href= "login.php" >ログインページはこちら</a>
</body>
</html>

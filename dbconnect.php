<?php // dbconnect.php
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
    echo("MySQLへの接続失敗 <br>");
    
    //エラーの表示
    exit($e->getMessage()); 
}